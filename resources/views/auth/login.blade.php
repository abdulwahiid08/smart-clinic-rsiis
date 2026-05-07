<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - RSI Ibnu Sina</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="auth-body">
    <main class="auth-shell">
        <section class="auth-panel">
            <div class="auth-brand">
                <span class="brand-mark">IS</span>
                <div>
                    <p class="eyebrow">Sistem Rawat Jalan</p>
                    <h1>RSI Ibnu Sina</h1>
                </div>
            </div>

            @include('partials.flash')
            @include('partials.errors')

            <form method="POST" action="{{ route('login.store') }}" class="login-form">
                @csrf
                <label>Email
                    <input type="email" name="email" value="{{ old('email') }}" autocomplete="email" required autofocus>
                </label>
                <label>Password
                    <input type="password" name="password" autocomplete="current-password" required>
                </label>
                <label class="check-row">
                    <input type="checkbox" name="remember" value="1">
                    <span>Ingat sesi login</span>
                </label>
                <button class="button primary" type="submit">Masuk</button>
            </form>

            <p class="auth-hint">Akun seed: admin@rsi.test / password</p>
        </section>
    </main>
</body>
</html>
