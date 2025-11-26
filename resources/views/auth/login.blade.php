@extends('welcome')

@section('content')
<div class="py-4 py-md-5 d-flex justify-content-center">
    <div class="card shadow-sm border-0 rounded-4" style="max-width: 420px; width: 100%;">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <div class="d-inline-flex align-items-center justify-content-center bg-info-subtle text-info rounded-circle shadow-sm"
                    style="width: 64px; height: 64px;">
                    🔒
                </div>
                <h1 class="h4 fw-bold mt-3 mb-1">Masuk Dulu, Yuk!</h1>
                <p class="text-muted small mb-0">Akses tabungan ceria dan lanjutkan menabung.</p>
            </div>

            <form method="POST" action="{{ route('login.process') }}" class="d-flex flex-column gap-3">
                @csrf

                <div>
                    <label for="email" class="form-label small fw-semibold">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="form-control form-control-lg rounded-3 @error('email') is-invalid @enderror"
                        placeholder="nama@email.com"
                    >
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div>
                    <label for="password" class="form-label small fw-semibold">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        class="form-control form-control-lg rounded-3 @error('password') is-invalid @enderror"
                        placeholder="••••••••"
                    >
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember">
                    <label class="form-check-label small" for="remember">
                        Ingat saya
                    </label>
                </div>

                <button type="submit" class="btn btn-warning text-dark fw-semibold rounded-3 w-100">
                    Masuk ke Tabungan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
