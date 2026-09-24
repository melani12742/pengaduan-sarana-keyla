<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary: #6A1E55;
            --primary-hover: #8B2E70;
            --secondary: #EBD3F8;
            --secondary-hover: #DDBEEF;
            --bg-white: #FFFFFF;
            --bg-alt: #F9F5FB;
            --text-dark: #2D1B2E;
            --text-gray: #6B5B6E;
            --border: #EBD3F8;
            --sidebar-width: 260px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Figtree', sans-serif;
            background: var(--bg-alt);
            color: var(--text-dark);
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--bg-white);
            border-right: 1px solid var(--border);
            padding: 0;
            overflow-y: auto;
            z-index: 1000;
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand {
            padding: 24px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-brand-icon {
            width: 42px;
            height: 42px;
            background: var(--primary);
            color: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .sidebar-brand-text h4 {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary);
            margin: 0;
            line-height: 1.2;
        }

        .sidebar-brand-text small {
            font-size: 11px;
            color: var(--text-gray);
        }

        .sidebar-nav {
            flex: 1;
            padding: 16px 12px;
            overflow-y: auto;
        }

        .nav-section {
            font-size: 11px;
            text-transform: uppercase;
            color: var(--text-gray);
            padding: 16px 12px 8px;
            letter-spacing: 1px;
            opacity: 0.7;
            font-weight: 600;
        }

        .sidebar .nav-link {
            color: var(--text-gray);
            padding: 11px 16px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 3px;
            text-decoration: none;
            transition: all 0.25s ease;
        }

        .sidebar .nav-link i {
            width: 20px;
            text-align: center;
            font-size: 16px;
        }

        .sidebar .nav-link:hover {
            background: var(--secondary);
            color: var(--primary);
        }

        .sidebar .nav-link.active {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 15px rgba(106, 30, 85, 0.25);
        }

        .sidebar .nav-link .badge {
            margin-left: auto;
            background: var(--secondary);
            color: var(--primary);
            font-size: 11px;
            padding: 3px 10px;
            border-radius: 20px;
            font-weight: 600;
        }

        .sidebar .nav-link.active .badge {
            background: rgba(255, 255, 255, 0.25);
            color: white;
        }

        /* SIDEBAR PROFILE */
        .sidebar-profile {
            padding: 16px 20px;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-profile img {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid var(--secondary);
            cursor: pointer;
        }

        .sidebar-profile-info {
            flex: 1;
            min-width: 0;
        }

        .sidebar-profile-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-dark);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-profile-role {
            font-size: 11px;
            color: var(--text-gray);
            text-transform: capitalize;
        }

        /* LOGOUT */
        .sidebar-logout {
            padding: 0 12px 20px;
        }

        .btn-logout {
            width: 100%;
            padding: 11px 16px;
            border-radius: 12px;
            border: none;
            background: transparent;
            color: var(--text-gray);
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 14px;
            cursor: pointer;
            transition: all 0.25s ease;
            text-align: left;
        }

        .btn-logout:hover {
            background: #FEE2E2;
            color: #EF4444;
        }

        /* MAIN CONTENT */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 30px 40px;
            min-height: 100vh;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .page-header h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
        }

        .page-header h1 span {
            color: var(--primary);
        }

        /* CARD */
        .card-modern {
            background: var(--bg-white);
            border-radius: 20px;
            padding: 24px;
            border: 1px solid var(--border);
            box-shadow: 0 2px 10px rgba(106, 30, 85, 0.05);
            transition: all 0.3s ease;
        }

        .card-modern:hover {
            box-shadow: 0 8px 30px rgba(106, 30, 85, 0.1);
        }

        /* BUTTONS */
        .btn-primary-modern {
            background: var(--primary);
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary-modern:hover {
            background: var(--primary-hover);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(106, 30, 85, 0.3);
        }

        .btn-outline-modern {
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
            padding: 8px 20px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-outline-modern:hover {
            background: var(--primary);
            color: white;
        }

        /* ALERT */
        .alert-modern {
            padding: 14px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
        }

        .alert-modern.success {
            background: #D1FAE5;
            color: #065F46;
            border: 1px solid #10B981;
        }

        .alert-modern.danger {
            background: #FEE2E2;
            color: #991B1B;
            border: 1px solid #EF4444;
        }

        /* TABLE */
        .table-modern {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 8px;
        }

        .table-modern thead th {
            font-size: 12px;
            text-transform: uppercase;
            color: var(--text-gray);
            font-weight: 600;
            padding: 12px 16px;
            text-align: left;
            border-bottom: 2px solid var(--border);
        }

        .table-modern tbody tr {
            background: var(--bg-white);
        }

        .table-modern tbody td {
            padding: 16px;
            font-size: 14px;
            color: var(--text-dark);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }

        .table-modern tbody td:first-child {
            border-left: 1px solid var(--border);
            border-top-left-radius: 12px;
            border-bottom-left-radius: 12px;
        }

        .table-modern tbody td:last-child {
            border-right: 1px solid var(--border);
            border-top-right-radius: 12px;
            border-bottom-right-radius: 12px;
        }

        /* BADGE */
        .badge-modern {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-menunggu {
            background: #FEF3C7;
            color: #92400E;
        }

        .badge-ditinjau {
            background: #DBEAFE;
            color: #1E40AF;
        }

        .badge-dalam_perbaikan {
            background: #E0E7FF;
            color: #3730A3;
        }

        .badge-selesai {
            background: #D1FAE5;
            color: #065F46;
        }

        .badge-ditolak {
            background: #FEE2E2;
            color: #991B1B;
        }

        /* HAMBURGER */
        .hamburger {
            display: none;
            position: fixed;
            top: 16px;
            left: 16px;
            z-index: 1001;
            background: var(--primary);
            border: none;
            color: white;
            padding: 10px 14px;
            border-radius: 12px;
            cursor: pointer;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
                padding-top: 70px;
            }

            .hamburger {
                display: block;
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 999;
            }

            .sidebar-overlay.active {
                display: block;
            }
        }
    </style>
</head>

<body>

    {{-- OVERLAY --}}
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    {{-- HAMBURGER --}}
    <button class="hamburger" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    {{-- SIDEBAR --}}
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-brand-icon">
                <i class="fas fa-school"></i>
            </div>
            <div class="sidebar-brand-text">
                <h4>Pengaduan</h4>
                <small>Sarana Sekolah</small>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section">Menu Utama</div>

            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> Dashboard
            </a>

            @auth
                @if(Auth::user()->role === 'guest')
                    <a href="{{ route('aspirasi.create') }}"
                        class="nav-link {{ request()->routeIs('aspirasi.create') ? 'active' : '' }}">
                        <i class="fas fa-plus-circle"></i> Buat Aspirasi
                    </a>
                @endif
            @endauth

            <a href="{{ route('aspirasi.index') }}"
                class="nav-link {{ request()->routeIs('aspirasi.index') ? 'active' : '' }}">
                <i class="fas fa-list"></i> Daftar Aspirasi
            </a>

            @auth
                @if(Auth::user()->role === 'admin')
                    <div class="nav-section">Administrasi</div>

                    <a href="{{ route('admin.all-aspirasi') }}"
                        class="nav-link {{ request()->routeIs('admin.all-aspirasi') ? 'active' : '' }}">
                        <i class="fas fa-clipboard-list"></i> Semua Aspirasi
                        <span class="badge">{{ \App\Models\Aspirasi::count() }}</span>
                    </a>

                    <a href="{{ route('admin.users') }}"
                        class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                        <i class="fas fa-users"></i> Kelola User
                        <span class="badge">{{ \App\Models\User::where('role', 'guest')->count() }}</span>
                    </a>

                    <a href="{{ route('admin.kategori.index') }}"
                        class="nav-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                        <i class="fas fa-tags"></i> Kelola Kategori
                        <span class="badge">{{ \App\Models\Category::count() }}</span>
                    </a>
                @endif
            @endauth

            <div class="nav-section">Lainnya</div>

            <a href="{{ route('landing') }}" class="nav-link">
                <i class="fas fa-home"></i> Landing Page
            </a>
        </nav>

        @auth
            <div class="sidebar-profile">
                <img src="{{ Auth::user()->profile_photo ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=6A1E55&color=fff&size=50' }}"
                    alt="{{ Auth::user()->name }}">
                <div class="sidebar-profile-info">
                    <div class="sidebar-profile-name">{{ Auth::user()->name }}</div>
                    <div class="sidebar-profile-role">{{ ucfirst(Auth::user()->role) }}</div>
                </div>
            </div>

            <div class="sidebar-logout">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        @endauth
    </aside>

    {{-- MAIN CONTENT --}}
    <main class="main-content">
        <div class="page-header">
            <h1>@yield('header', 'Dashboard')</h1>
            @yield('actions')
        </div>

        @if(session('success'))
            <div class="alert-modern success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert-modern danger">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('active');
        }
        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('sidebarOverlay').classList.remove('active');
        }
    </script>
</body>

</html>