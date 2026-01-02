<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
}
