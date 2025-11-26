@extends('welcome')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-background via-background to-chart-1/5 p-4">
    <div class="max-w-6xl mx-auto space-y-6">
        {{-- Header --}}
        <div class="text-center space-y-2">
            <h1
                class="text-4xl font-display font-bold bg-gradient-to-r from-chart-1 to-chart-4 bg-clip-text text-transparent">
                Tabungan Anak Pintar
            </h1>
            <p class="text-muted-foreground text-lg">
                Yuk, kumpulkan uang jajan dan wujudkan impianmu! 🌟
            </p>
        </div>

        {{-- Balance Card --}}

        <div
            class="bg-card border border-border shadow-sm rounded-2xl p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <p class="text-sm text-muted-foreground">Total Tabungan</p>
                <p class="text-3xl font-bold tracking-tight mt-1">
                    Rp 125.000
                </p>
                <p class="text-xs text-muted-foreground mt-2">
                    Terakhir diperbarui: 01 Jan 2025 08:00
                </p>
            </div>
        </div>

        {{-- Grid Layout --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Left Column --}}
            <div class="space-y-6">
                {{-- Savings Form --}}
                <div class="bg-card border border-border rounded-xl shadow-sm p-6 space-y-4">
                    <div class="space-y-1">
                        <h2 class="text-lg font-semibold">Tambah Tabungan</h2>
                        <p class="text-sm text-muted-foreground">
                            Catat uang jajanmu agar impianmu makin dekat ✨
                        </p>
                    </div>

                    <form method="POST" action="javascript:void(0)" class="space-y-4">
                        {{-- Form demo: belum terhubung ke backend --}}
                        <div class="space-y-2">
                            <label for="amount" class="text-sm font-medium">
                                Jumlah Tabungan (Rp)
                            </label>
                            <input id="amount" name="amount" type="number" min="0" step="1000" required
                                class="w-full rounded-md border border-input bg-background px-3 py-2 text-sm outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-chart-1"
                                placeholder="Contoh: 10.000" />
                        </div>

                        <div class="space-y-2">
                            <label for="description" class="text-sm font-medium">
                                Keterangan
                            </label>
                            <input id="description" name="description" type="text" required
                                class="w-full rounded-md border border-input bg-background px-3 py-2 text-sm outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-chart-1"
                                placeholder="Misal: Nabung dari uang jajan sekolah" />
                        </div>

                        <button type="submit"
                            class="inline-flex w-full items-center justify-center rounded-md border border-transparent bg-chart-1 px-4 py-2 text-sm font-medium text-primary-foreground shadow-sm hover:opacity-90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-chart-1 disabled:pointer-events-none disabled:opacity-50">
                            Simpan Tabungan
                        </button>
                    </form>
                </div>

                {{-- Savings Chart Placeholder --}}
                <div class="bg-card border border-border rounded-xl shadow-sm p-6 space-y-4">
                    <div class="space-y-1">
                        <h2 class="text-lg font-semibold">Grafik Tabungan</h2>
                        <p class="text-sm text-muted-foreground">
                            Perkembangan tabunganmu akan tampil di sini 📈
                        </p>
                    </div>

                    {{-- Placeholder chart area --}}
                    <div
                        class="h-48 rounded-lg border border-dashed border-border flex items-center justify-center text-sm text-muted-foreground">
                        Grafik akan tampil di versi React (Home.tsx)
                    </div>
                </div>
            </div>

            {{-- Right Column: Savings History --}}
            <div class="bg-card border border-border rounded-xl shadow-sm p-6 space-y-4">
                <div class="space-y-1">
                    <h2 class="text-lg font-semibold">Riwayat Tabungan</h2>
                    <p class="text-sm text-muted-foreground">
                        Pantau setiap kali kamu menabung 💰
                    </p>
                </div>

                <div class="max-h-[420px] overflow-y-auto pr-1">
                    <ul class="space-y-3">
                        <li class="flex items-center justify-between rounded-lg border border-border px-3 py-2">
                            <div>
                                <p class="text-sm font-medium">
                                    Rp 50.000
                                </p>
                                <p class="text-xs text-muted-foreground mt-0.5">
                                    Nabung dari uang jajan sekolah
                                </p>
                            </div>
                            <span class="text-xs text-muted-foreground">
                                01 Jan 2025 07:30
                            </span>
                        </li>
                        <li class="flex items-center justify-between rounded-lg border border-border px-3 py-2">
                            <div>
                                <p class="text-sm font-medium">
                                    Rp 25.000
                                </p>
                                <p class="text-xs text-muted-foreground mt-0.5">
                                    Hadiah dari nenek
                                </p>
                            </div>
                            <span class="text-xs text-muted-foreground">
                                01 Jan 2025 09:15
                            </span>
                        </li>
                        <li class="flex items-center justify-between rounded-lg border border-border px-3 py-2">
                            <div>
                                <p class="text-sm font-medium">
                                    Rp 50.000
                                </p>
                                <p class="text-xs text-muted-foreground mt-0.5">
                                    Sisa uang beli jajanan
                                </p>
                            </div>
                            <span class="text-xs text-muted-foreground">
                                02 Jan 2025 10:05
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="text-center text-sm text-muted-foreground py-8">
            <p>Tetap semangat menabung! Setiap rupiah sangat berharga 💪</p>
        </div>
    </div>
</div>
@endsection