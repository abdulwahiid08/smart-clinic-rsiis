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
        <aside class="sidebar" id="app-sidebar" aria-label="Navigasi utama">
            <button class="sidebar-close" type="button" data-sidebar-close aria-label="Tutup sidebar">
                <span></span>
                <span></span>
            </button>
            <a class="brand" href="{{ route('dashboard') }}">
                <span class="brand-mark">IS</span>
                <span class="brand-copy">
                    <strong>RSI Ibnu Sina</strong>
                    <small>Rawat Jalan</small>
                </span>
            </a>
            <nav class="nav">
                <a href="{{ route('dashboard') }}" data-short="D" title="Dashboard" @class(['active' => request()->routeIs('dashboard')])>Dashboard</a>
                <a href="{{ route('kunjungans.index') }}" data-short="P" title="Pendaftaran" @class(['active' => request()->routeIs('kunjungans.*')])>Pendaftaran</a>
                <a href="{{ route('master.polis.index') }}" data-short="M" title="Master Data" @class(['active' => request()->routeIs('master.*')])>Master Data</a>
                <a href="{{ route('laporans.index') }}" data-short="L" title="Laporan" @class(['active' => request()->routeIs('laporans.*')])>Laporan</a>
            </nav>
        </aside>
        <button class="sidebar-overlay" type="button" data-sidebar-close aria-label="Tutup menu"></button>

        <main class="main">
            <header class="topbar">
                <div class="topbar-title">
                    <button class="sidebar-toggle" type="button" data-sidebar-toggle aria-controls="app-sidebar" aria-expanded="true">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                    <div>
                        <p class="eyebrow">@yield('eyebrow', 'Sistem Rawat Jalan')</p>
                        <h1>@yield('page-title', 'Dashboard')</h1>
                    </div>
                </div>
                <div class="topbar-actions">
                    @yield('header-action')
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="button ghost" type="submit">Logout</button>
                    </form>
                </div>
            </header>

            @include('partials.flash')
            @include('partials.errors')

            @yield('content')
        </main>
    </div>
    <script>
        (() => {
            const body = document.body;
            const toggle = document.querySelector('[data-sidebar-toggle]');
            const closeButtons = document.querySelectorAll('[data-sidebar-close]');
            const desktopQuery = window.matchMedia('(min-width: 961px)');

            const setExpanded = (expanded) => {
                body.classList.toggle('sidebar-collapsed', !expanded && desktopQuery.matches);
                body.classList.toggle('sidebar-open', expanded && !desktopQuery.matches);
                toggle?.setAttribute('aria-expanded', String(expanded));

                if (desktopQuery.matches) {
                    localStorage.setItem('rsi-sidebar-expanded', expanded ? '1' : '0');
                }
            };

            const syncInitialState = () => {
                if (desktopQuery.matches) {
                    setExpanded(localStorage.getItem('rsi-sidebar-expanded') !== '0');
                    return;
                }

                body.classList.remove('sidebar-collapsed', 'sidebar-open');
                toggle?.setAttribute('aria-expanded', 'false');
            };

            toggle?.addEventListener('click', () => {
                const isOpenMobile = body.classList.contains('sidebar-open');
                const isCollapsedDesktop = body.classList.contains('sidebar-collapsed');
                setExpanded(desktopQuery.matches ? isCollapsedDesktop : !isOpenMobile);
            });

            closeButtons.forEach((button) => {
                button.addEventListener('click', () => setExpanded(false));
            });

            desktopQuery.addEventListener('change', syncInitialState);
            syncInitialState();
        })();
    </script>
</body>
</html>
