@extends('welcome')

@section('content')
<div class="py-3 py-md-4">
    <div class="row g-3 g-lg-4">
        <div class="col-12 col-lg-6 d-flex">
            <div class="card border-0 shadow-sm rounded-4 w-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div>
                            <h1 class="h4 fw-bold mb-1">Halaman Teller</h1>
                            <p class="text-secondary mb-0">Kelola transaksi untuk nasabah di sini.</p>
                        </div>
                        <span class="badge text-bg-success">+ Rp 10.000/hari</span>
                    </div>

                    <form method="POST" action="{{ route('transactions.store') }}" class="d-flex flex-column gap-3">
                        @csrf

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="user_id" class="form-label fw-semibold small">Customer</label>
                                <select id="user_id" name="user_id" class="form-select form-select-lg rounded-3" required>
                                    <option value="" disabled selected>Pilih customer</option>
                                    @foreach ($customers ?? [] as $customer)
                                        <option value="{{ $customer->id }}" @selected((string) old('user_id') === (string) $customer->id)>
                                            {{ $customer->name }} ({{ $customer->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="type" class="form-label fw-semibold small">Jenis</label>
                                <select id="type" name="type" class="form-select form-select-lg rounded-3" required>
                                    <option value="in" selected>Masuk (Tambah Tabungan)</option>
                                    <option value="out">Keluar (Tarik Tabungan)</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="amount" class="form-label fw-semibold small">Jumlah (Rp)</label>
                                <input id="amount" name="amount" type="number" min="0" step="1000" required
                                    class="form-control form-control-lg rounded-3"
                                    placeholder="Contoh: 10.000">
                            </div>
                        </div>

                        <div>
                            <label for="title" class="form-label fw-semibold small">Judul singkat</label>
                            <input id="title" name="title" type="text" maxlength="100"
                                class="form-control form-control-lg rounded-3"
                                placeholder="Misal: Nabung jajan, Bonus, atau Tarik mainan">
                        </div>

                        <div>
                            <label for="description" class="form-label fw-semibold small">Keterangan</label>
                            <input id="description" name="description" type="text" maxlength="500"
                                class="form-control form-control-lg rounded-3"
                                placeholder="Misal: Nabung dari uang jajan sekolah">
                        </div>

                        <div>
                            <label for="transacted_at" class="form-label fw-semibold small">Tanggal & waktu</label>
                            <input id="transacted_at" name="transacted_at" type="datetime-local"
                                class="form-control form-control-lg rounded-3">
                            <div class="form-text">Kosongkan jika ingin pakai waktu sekarang.</div>
                        </div>

                        <button type="submit" class="btn btn-warning text-dark fw-semibold rounded-3 w-100">
                            💖 Simpan Tabungan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6 d-flex">
            <div class="card border-0 shadow-sm rounded-4 w-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div>
                            <h2 class="h5 fw-bold mb-1">Riwayat Transaksi</h2>
                            <p class="text-secondary mb-0">Maksimal 50 transaksi terbaru.</p>
                        </div>
                        <span class="badge text-bg-info text-dark">
                            {{ isset($transactions) ? $transactions->count() : 0 }} catatan
                        </span>
                    </div>

                    <form method="GET" action="{{ route('teller') }}" class="mb-3">
                        <label for="user_id" class="form-label fw-semibold small">Filter berdasarkan user</label>
                        <div class="d-flex gap-2">
                            <select id="user_id" name="user_id" class="form-select rounded-3">
                                <option value="">Semua user</option>
                                @foreach ($users ?? [] as $user)
                                    <option value="{{ $user->id }}" @selected((string) $selectedUserId === (string) $user->id)>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-outline-primary rounded-3">Terapkan</button>
                        </div>
                    </form>

                    <div class="list-group list-group-flush">
                        @forelse ($transactions ?? [] as $transaction)
                            <div class="list-group-item rounded-3 border-0 px-0 d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="mb-1 fw-semibold">
                                        {{ $transaction->type === 'out' ? '-' : '+' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                    </p>
                                    <small class="text-muted d-block">
                                        {{ $transaction->user?->name ?? 'User tidak dikenal' }}
                                        <span class="text-muted">•</span>
                                        {{ $transaction->user?->email ?? '-' }}
                                    </small>
                                    <small class="text-muted d-block">{{ $transaction->title ?? 'Tanpa judul' }}</small>
                                    @if ($transaction->description)
                                        <small class="text-muted d-block">{{ $transaction->description }}</small>
                                    @endif
                                </div>
                                <div class="text-end">
                                    <span class="badge {{ $transaction->type === 'out' ? 'text-bg-danger' : 'text-bg-success' }}">
                                        {{ $transaction->type === 'out' ? 'Keluar' : 'Masuk' }}
                                    </span>
                                    <div class="text-muted small mt-1">
                                        {{ optional($transaction->transacted_at)->format('d M Y H:i') ?? $transaction->created_at->format('d M Y H:i') }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="list-group-item rounded-3 border-0 px-0">
                                <div class="d-flex align-items-center gap-2 text-muted">
                                    <span>Belum ada transaksi.</span>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
