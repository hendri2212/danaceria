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
    <div class="row g-3 g-lg-4">
        <div class="col-12 col-lg-6 d-flex flex-column gap-3">
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

            <div class="card border-0 shadow-sm rounded-4 w-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div>
                            <h2 class="h5 fw-bold mb-1">Transfer Antar Nasabah</h2>
                            <p class="text-secondary mb-0">Pindahkan saldo dari user A ke user B.</p>
                        </div>
                        <span class="badge text-bg-primary">Transfer</span>
                    </div>

                    <form method="POST" action="{{ route('transactions.transfer') }}" class="d-flex flex-column gap-3">
                        @csrf

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="from_user_id" class="form-label fw-semibold small">Dari customer</label>
                                <select id="from_user_id" name="from_user_id" class="form-select form-select-lg rounded-3" required>
                                    <option value="" disabled selected>Pilih pengirim</option>
                                    @foreach ($customers ?? [] as $customer)
                                        <option value="{{ $customer->id }}" @selected((string) old('from_user_id') === (string) $customer->id)>
                                            {{ $customer->name }} ({{ $customer->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="to_user_id" class="form-label fw-semibold small">Ke customer</label>
                                <select id="to_user_id" name="to_user_id" class="form-select form-select-lg rounded-3" required>
                                    <option value="" disabled selected>Pilih penerima</option>
                                    @foreach ($customers ?? [] as $customer)
                                        <option value="{{ $customer->id }}" @selected((string) old('to_user_id') === (string) $customer->id)>
                                            {{ $customer->name }} ({{ $customer->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="transfer_amount" class="form-label fw-semibold small">Jumlah (Rp)</label>
                                <input id="transfer_amount" name="amount" type="number" min="0" step="1000" required
                                    class="form-control form-control-lg rounded-3"
                                    placeholder="Contoh: 50.000">
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="transfer_transacted_at" class="form-label fw-semibold small">Tanggal & waktu</label>
                                <input id="transfer_transacted_at" name="transacted_at" type="datetime-local"
                                    class="form-control form-control-lg rounded-3">
                            </div>
                        </div>

                        <div>
                            <label for="transfer_title" class="form-label fw-semibold small">Judul singkat</label>
                            <input id="transfer_title" name="title" type="text" maxlength="100"
                                class="form-control form-control-lg rounded-3"
                                placeholder="Misal: Transfer bulanan atau kirim uang jajan">
                        </div>

                        <div>
                            <label for="transfer_description" class="form-label fw-semibold small">Keterangan</label>
                            <input id="transfer_description" name="description" type="text" maxlength="500"
                                class="form-control form-control-lg rounded-3"
                                placeholder="Catatan tambahan (opsional)">
                        </div>

                        <button type="submit" class="btn btn-primary fw-semibold rounded-3 w-100">
                            🚀 Proses Transfer
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
                            <p class="text-secondary mb-0">Daftar transaksi terbaru dengan pagination.</p>
                        </div>
                        <span class="badge text-bg-info text-dark">
                            {{ isset($transactions) ? $transactions->total() : 0 }} catatan
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

                    @if (isset($transactions) && method_exists($transactions, 'links'))
                        <div class="mt-3">
                            <p class="text-muted small text-center mb-2">
                                Showing {{ $transactions->firstItem() ?? 0 }} to {{ $transactions->lastItem() ?? 0 }} of {{ $transactions->total() }} results
                            </p>

                            @if ($transactions->hasPages())
                                <div class="d-flex justify-content-center">
                                    {{ $transactions->onEachSide(1)->links() }}
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
