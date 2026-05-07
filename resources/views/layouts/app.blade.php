<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'RSI Ibnu Sina')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="app-shell">
        <aside class="sidebar">
            <a class="brand" href="{{ route('dashboard') }}">
                <span class="brand-mark">IS</span>
                <span>
                    <strong>RSI Ibnu Sina</strong>
                    <small>Rawat Jalan</small>
                </span>
            </a>
            <nav class="nav">
                <a href="{{ route('dashboard') }}" @class(['active' => request()->routeIs('dashboard')])>Dashboard</a>
                <a href="{{ route('kunjungans.index') }}" @class(['active' => request()->routeIs('kunjungans.*')])>Pendaftaran</a>
                <a href="{{ route('laporans.index') }}" @class(['active' => request()->routeIs('laporans.*')])>Laporan</a>
            </nav>
        </aside>

        <main class="main">
            <header class="topbar">
                <div>
                    <p class="eyebrow">@yield('eyebrow', 'Sistem Rawat Jalan')</p>
                    <h1>@yield('page-title', 'Dashboard')</h1>
                </div>
                @yield('header-action')
            </header>

            @include('partials.flash')
            @include('partials.errors')

            @yield('content')
        </main>
    </div>
</body>
</html>
