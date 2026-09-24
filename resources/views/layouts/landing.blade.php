<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pengaduan Sarana Sekolah')</title>

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
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Figtree', sans-serif;
            background: var(--bg-white);
            color: var(--text-dark);
        }

        /* NAVBAR */
        .navbar-landing {
            padding: 20px 0;
            background: var(--bg-white);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .navbar-landing .brand {
            color: var(--primary);
            font-weight: 700;
            font-size: 22px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-landing .brand-icon {
            width: 40px;
            height: 40px;
            background: var(--primary);
            color: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .navbar-landing .nav-link {
            color: var(--text-gray);
            text-decoration: none;
            padding: 10px 20px;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .navbar-landing .nav-link:hover {
            color: var(--primary);
        }

        /* BUTTONS */
        .btn-primary-modern {
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 28px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
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
            padding: 10px 28px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-outline-modern:hover {
            background: var(--primary);
            color: white;
        }

        /* CARD */
        .card-modern {
            background: var(--bg-white);
            border-radius: 20px;
            padding: 30px;
            border: 1px solid var(--border);
            box-shadow: 0 2px 10px rgba(106, 30, 85, 0.05);
            transition: all 0.3s ease;
        }

        .card-modern:hover {
            box-shadow: 0 8px 30px rgba(106, 30, 85, 0.1);
            transform: translateY(-4px);
        }

        /* FOOTER */
        .footer-landing {
            padding: 40px 0;
            background: var(--bg-alt);
            text-align: center;
            border-top: 1px solid var(--border);
        }

        .footer-landing p {
            color: var(--text-gray);
            font-size: 14px;
            margin: 0;
        }
    </style>
</head>

<body>

    {{-- NAVBAR --}}
    <nav class="navbar-landing">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('landing') }}" class="brand">
                    <div class="brand-icon">
                        <i class="fas fa-school"></i>
                    </div>
                    Pengaduan
                </a>
                <div class="d-flex align-items-center gap-3">
                    @guest
                        <a href="{{ route('login') }}" class="nav-link">Login</a>
                        <a href="{{ route('register') }}" class="btn-primary-modern">
                            <i class="fas fa-user-plus"></i> Daftar
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="btn-primary-modern">
                            <i class="fas fa-chart-pie"></i> Dashboard
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    {{-- CONTENT --}}
    <main>
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="footer-landing">
        <div class="container">
            <p>&copy; {{ date('Y') }} Pengaduan Sarana Sekolah. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>