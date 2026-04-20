@extends('welcome')

@section('content')
    @if (in_array(auth()->user()?->role, ['admin', 'teller'], true))
        <div class="mb-3">
            <div class="d-flex justify-content-between gap-2 align-items-center p-3 rounded-4 bg-light border shadow-sm">
                <div>
                    <a href="{{ url('/') }}" class="btn btn-outline-dark btn-sm fw-semibold">Dashboard</a>
                    <a href="{{ url('/teller') }}" class="btn btn-outline-primary btn-sm fw-semibold">Teller</a>
                    <a href="{{ url('/customer') }}" class="btn btn-outline-success btn-sm fw-semibold">Customer</a>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    @endif
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">
            <h1 class="h4 fw-bold mb-2">Halaman Customer</h1>
            <p class="text-secondary mb-3">Lihat total tabungan setiap customer.</p>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th class="text-end">Total Masuk</th>
                            <th class="text-end">Total Keluar</th>
                            <th class="text-end">Saldo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customers ?? [] as $customer)
                            @php
                                $totalIn = (int) ($customer->total_in ?? 0);
                                $totalOut = (int) ($customer->total_out ?? 0);
                                $balance = $totalIn - $totalOut;
                            @endphp
                            <tr>
                                <td class="fw-semibold text-nowrap">{{ $customer->name }}</td>
                                <td class="text-muted">{{ $customer->email }}</td>
                                <td class="text-end text-success text-nowrap">Rp {{ number_format($totalIn, 0, ',', '.') }}</td>
                                <td class="text-end text-danger text-nowrap">Rp {{ number_format($totalOut, 0, ',', '.') }}</td>
                                <td class="text-end fw-semibold text-nowrap">Rp {{ number_format($balance, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada data customer.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
