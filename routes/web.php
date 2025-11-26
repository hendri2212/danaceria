<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;
use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', function (Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak sesuai.',
        ])->onlyInput('email');
    })->name('login.process');
});

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        $transactions = Transaction::where('user_id', Auth::id())
            ->orderByDesc('transacted_at')
            ->orderByDesc('created_at')
            ->take(50)
            ->get();

        $summary = Transaction::where('user_id', Auth::id())
            ->selectRaw("SUM(CASE WHEN type = 'in' THEN amount ELSE 0 END) as total_in")
            ->selectRaw("SUM(CASE WHEN type = 'out' THEN amount ELSE 0 END) as total_out")
            ->selectRaw("MAX(COALESCE(transacted_at, created_at)) as last_time")
            ->first();

        $totalIn = (int) ($summary->total_in ?? 0);
        $totalOut = (int) ($summary->total_out ?? 0);
        $balance = $totalIn - $totalOut;
        $lastUpdated = $summary->last_time ? Carbon::parse($summary->last_time) : null;

        $chartStart = now()->subDays(6)->startOfDay();
        $chartRows = Transaction::where('user_id', Auth::id())
            ->where(function ($query) use ($chartStart) {
                $query->where('transacted_at', '>=', $chartStart)
                    ->orWhere(function ($sub) use ($chartStart) {
                        $sub->whereNull('transacted_at')
                            ->where('created_at', '>=', $chartStart);
                    });
            })
            ->get();

        $dailyChart = collect(range(0, 6))->map(function (int $index) use ($chartStart, $chartRows) {
            $date = $chartStart->copy()->addDays($index)->toDateString();

            $rowsForDay = $chartRows->filter(function (Transaction $transaction) use ($date) {
                $dateToCompare = optional($transaction->transacted_at ?? $transaction->created_at)->toDateString();
                return $dateToCompare === $date;
            });

            $totalIn = (int) $rowsForDay->where('type', 'in')->sum('amount');
            $totalOut = (int) $rowsForDay->where('type', 'out')->sum('amount');
            $net = $totalIn - $totalOut;

            return [
                'label' => $chartStart->copy()->addDays($index)->format('d M'),
                'date' => $date,
                'in' => $totalIn,
                'out' => $totalOut,
                'net' => $net,
                'inOutMax' => max($totalIn, $totalOut),
            ];
        });

        $chartMax = max($dailyChart->max('inOutMax') ?? 0, 1);

        return view('home', [
            'transactions' => $transactions,
            'balance' => $balance,
            'totalIn' => $totalIn,
            'totalOut' => $totalOut,
            'lastUpdated' => $lastUpdated,
            'chart' => [
                'daily' => $dailyChart,
                'max' => $chartMax,
            ],
        ]);
    })->name('home');

    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');

    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    })->name('logout');
});
