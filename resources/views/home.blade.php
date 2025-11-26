@extends('welcome')

@section('content')
<div class="py-3 py-md-4">
    <div class="row g-3 g-lg-4">
        {{-- Hero --}}
        <div class="col-12">
            <div class="p-4 p-md-5 rounded-4 bg-info-subtle border border-info-subtle shadow-sm">
                <div class="d-flex flex-column flex-md-row align-items-md-center gap-3 gap-md-4">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-white text-info fw-bold fs-3 shadow-sm flex-shrink-0" style="width: 64px; height: 64px;">
                        🌈
                    </div>
                    <div class="flex-grow-1">
                        <span class="badge text-bg-warning text-dark mb-2">Aplikasi Tabungan Ceria</span>
                        <h1 class="h3 fw-bold mb-2 text-info">
                            Tabungan Anak Pintar
                        </h1>
                        <p class="mb-0 text-secondary">
                            Kumpulkan uang jajanmu, capai impianmu, dan jadikan menabung terasa seru! ✨
                        </p>
                    </div>
                    <div class="d-flex flex-wrap gap-2 justify-content-md-end">
                        <span class="badge text-bg-primary">🎯 Target Bulanan: Rp 200.000</span>
                        <span class="badge text-bg-success">🏆 Hari ini: +Rp 25.000</span>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="col-12">
                <div class="alert alert-success rounded-3 border-0 shadow-sm mb-0">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        {{-- Balance + progress --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="row gy-3 align-items-center">
                        <div class="col-12 col-md-6">
                            <p class="text-uppercase text-secondary mb-1 small fw-semibold">Total Tabungan</p>
                            <p class="h2 fw-bold mb-1">
                                Rp {{ number_format($balance ?? 0, 0, ',', '.') }}
                            </p>
                            <p class="text-muted small mb-1">
                                Masuk: <span class="text-success">Rp {{ number_format($totalIn ?? 0, 0, ',', '.') }}</span>
                                · Keluar: <span class="text-danger">Rp {{ number_format($totalOut ?? 0, 0, ',', '.') }}</span>
                            </p>
                            <p class="text-muted small mb-0">
                                Terakhir diperbarui:
                                {{ ($lastUpdated ?? null)?->format('d M Y H:i') ?? 'Belum ada transaksi' }}
                            </p>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="d-flex justify-content-between small fw-semibold text-secondary mb-1">
                                <span>Perjalanan ke target</span>
                                <span>62%</span>
                            </div>
                            <div class="progress bg-info-subtle rounded-pill">
                                <div class="progress-bar progress-bar-striped bg-warning text-dark fw-semibold" role="progressbar" style="width: 62%;" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="mt-2 d-flex flex-wrap gap-2">
                                <span class="badge text-bg-light text-dark border border-warning">🧸 Tabungan Jajan</span>
                                <span class="badge text-bg-light text-dark border border-success">🚲 Beli Sepeda</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form + history --}}
        <div class="col-12 col-lg-6 d-flex">
            <div class="card border-0 shadow-sm rounded-4 w-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div>
                            <h2 class="h5 fw-bold mb-1">Tambah Tabungan</h2>
                            <p class="text-secondary mb-0">Catat uang jajanmu agar impian makin dekat ✨</p>
                        </div>
                        <span class="badge text-bg-success">+ Rp 10.000/hari</span>
                    </div>

                    <form method="POST" action="{{ route('transactions.store') }}" class="d-flex flex-column gap-3">
                        @csrf

                        <div class="row g-3">
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
                            <h2 class="h5 fw-bold mb-1">Riwayat Tabungan</h2>
                            <p class="text-secondary mb-0">Pantau setiap kali kamu menabung 💰</p>
                        </div>
                        <span class="badge text-bg-info text-dark">
                            {{ isset($transactions) ? $transactions->count() : 0 }} catatan
                        </span>
                    </div>

                    <div class="list-group list-group-flush">
                        @forelse ($transactions ?? [] as $transaction)
                            <div class="list-group-item rounded-3 border-0 px-0 d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="mb-1 fw-semibold">
                                        {{ $transaction->type === 'out' ? '-' : '+' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                    </p>
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
                                    <span>Belum ada transaksi. Yuk mulai menabung!</span>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Chart placeholder --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div>
                            <h2 class="h5 fw-bold mb-1">Grafik Tabungan</h2>
                            <p class="text-secondary mb-0">Perkembangan 7 hari terakhir</p>
                        </div>
                        <span class="badge text-bg-light text-dark">Live data</span>
                    </div>
                    @php
                        $chartData = $chart['daily'] ?? [];
                        $chartMax = $chart['max'] ?? 1;
                    @endphp

                    @forelse ($chartData as $day)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center small fw-semibold mb-1">
                                <span>{{ $day['label'] }}</span>
                                <span class="{{ $day['net'] >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $day['net'] >= 0 ? '+' : '-' }}Rp {{ number_format(abs($day['net']), 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="progress bg-info-subtle rounded-pill" style="height: 12px;">
                                <div class="progress-bar bg-success" role="progressbar"
                                    style="width: {{ $chartMax > 0 ? ($day['in'] / $chartMax) * 100 : 0 }}%;"
                                    aria-valuenow="{{ $day['in'] }}" aria-valuemin="0" aria-valuemax="{{ $chartMax }}">
                                </div>
                                <div class="progress-bar bg-danger" role="progressbar"
                                    style="width: {{ $chartMax > 0 ? ($day['out'] / $chartMax) * 100 : 0 }}%;"
                                    aria-valuenow="{{ $day['out'] }}" aria-valuemin="0" aria-valuemax="{{ $chartMax }}">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between text-muted small mt-1">
                                <span>Masuk: Rp {{ number_format($day['in'], 0, ',', '.') }}</span>
                                <span>Keluar: Rp {{ number_format($day['out'], 0, ',', '.') }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 border border-2 border-info-subtle rounded-4 text-center text-secondary fw-semibold">
                            Belum ada data transaksi untuk grafik.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="col-12">
            <div class="text-center text-muted py-3 small">
                Tetap semangat menabung! Setiap rupiah sangat berharga 💪
            </div>
        </div>
    </div>
</div>
@endsection
