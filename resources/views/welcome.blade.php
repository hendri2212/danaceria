<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'TabunganAnak') }}</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-light">
        <div class="d-flex flex-column min-vh-100 py-3 py-lg-4">
            <header class="container mb-4">
                @if (Route::has('login'))
                    <nav class="d-flex justify-content-end align-items-center gap-2">
                        @auth
                            <a
                                href="{{ url('/') }}"
                                class="btn btn-outline-dark btn-sm"
                            >
                                Dashboard
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">
                                    Logout
                                </button>
                            </form>
                        @else
                            <a
                                href="{{ route('login') }}"
                                class="btn btn-link btn-sm text-decoration-none"
                            >
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a
                                    href="{{ route('register') }}"
                                    class="btn btn-outline-dark btn-sm"
                                >
                                    Register
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </header>

            {{-- Main content from child view (home.blade.php, etc.) --}}
            <main class="flex-grow-1 d-flex justify-content-center align-items-start">
                <div class="container">
                    @yield('content')
                </div>
            </main>
        </div>

        <!-- Bootstrap JS (optional, untuk komponen interaktif) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
