<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    /**
     * Simpan transaksi baru milik user yang sedang login.
     */
    public function store(Request $request)
    {
        $role = $request->user()?->role;
        $isStaff = in_array($role, ['admin', 'teller'], true);

        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:500'],
            'type' => ['required', Rule::in(['in', 'out'])],
            'amount' => ['required', 'integer', 'min:0'],
            'transacted_at' => ['nullable', 'date'],
            'user_id' => $isStaff
                ? ['required', 'integer', Rule::exists('users', 'id')->where('role', 'customer')]
                : ['nullable'],
        ]);

        $validated['user_id'] = $isStaff ? $validated['user_id'] : Auth::id();

        Transaction::create($validated);

        return back()->with('success', 'Transaksi berhasil disimpan!');
    }

    /**
     * Transfer saldo antar customer oleh teller/admin.
     */
    public function transfer(Request $request)
    {
        $role = $request->user()?->role;
        if (!in_array($role, ['admin', 'teller'], true)) {
            abort(403);
        }

        $validated = $request->validate([
            'from_user_id' => ['required', 'integer', Rule::exists('users', 'id')->where('role', 'customer')],
            'to_user_id' => ['required', 'integer', 'different:from_user_id', Rule::exists('users', 'id')->where('role', 'customer')],
            'amount' => ['required', 'integer', 'min:1'],
            'title' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:500'],
            'transacted_at' => ['nullable', 'date'],
        ]);

        $fromUser = User::find($validated['from_user_id']);
        $toUser = User::find($validated['to_user_id']);

        $titleSuffix = $validated['title'] ? ' - ' . $validated['title'] : '';
        $titleOut = 'Transfer ke ' . ($toUser?->name ?? 'penerima') . $titleSuffix;
        $titleIn = 'Transfer dari ' . ($fromUser?->name ?? 'pengirim') . $titleSuffix;

        DB::transaction(function () use ($validated, $titleOut, $titleIn) {
            Transaction::create([
                'user_id' => $validated['from_user_id'],
                'title' => $titleOut,
                'description' => $validated['description'],
                'type' => 'out',
                'amount' => $validated['amount'],
                'transacted_at' => $validated['transacted_at'],
            ]);

            Transaction::create([
                'user_id' => $validated['to_user_id'],
                'title' => $titleIn,
                'description' => $validated['description'],
                'type' => 'in',
                'amount' => $validated['amount'],
                'transacted_at' => $validated['transacted_at'],
            ]);
        });

        return back()->with('success', 'Transfer berhasil diproses!');
    }
}
