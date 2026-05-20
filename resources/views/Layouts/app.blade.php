<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SummitBuddy') - Sewa Alat Pendakian</title>

    <script>
        (function() {
            function getCookie(name) {
                const cookies = document.cookie.split(';');
                for (const cookie of cookies) {
                    const [key, val] = cookie.trim().split('=');
                    if (key === name) return decodeURIComponent(val);
                }
                return null;
            }
            const theme = getCookie('preferensi_tema') || 'light';
            const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (theme === 'dark' || (theme === 'system' && systemDark)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @stack('styles')
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #f5f9f5 0%, #e8f0e8 100%); color: #2c3e2f; line-height: 1.6; }

        /* DARK MODE STYLES */
        .dark { background: #1a1a2e; color: #eee; }
        .dark .stat-card, .dark .card, .dark .ulasan-card, .dark aside, .dark form, .dark .table-container table { background: #2d2d44; color: #eee; }
        .dark td { border-bottom-color: #3d3d5c; }
        .dark tr:hover { background: #3d3d5c; }
        .dark input, .dark select, .dark textarea { background: #1a1a2e; border-color: #3d3d5c; color: #eee; }
        .dark input::placeholder { color: #888; }
        .dark nav { background: rgba(15, 25, 35, 0.95); }
        .dark footer { background: #0f1923; }
        .dark .alert-success { background: #1a3a2a; color: #90ee90; border-color: #2d5a3d; }
        .dark .alert-error { background: #3a1a1a; color: #ff9999; border-color: #5a2d2d; }
        .dark .stat-card .angka { color: #ff8c42; }

        nav { display: flex; justify-content: space-between; align-items: center; background: rgba(27, 94, 47, 0.95); backdrop-filter: blur(10px); padding: 15px 30px; color: white; position: fixed; width: 100%; top: 0; z-index: 1000; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        .logo { display: flex; align-items: center; gap: 10px; }
        .logo img { width: 40px; height: 40px; object-fit: contain; filter: brightness(0) invert(1); }
        .logo span { font-size: 22px; font-weight: 800; }
        .menu { display: flex; align-items: center; }
        .menu a { color: white; margin-left: 25px; text-decoration: none; padding: 8px 16px; border-radius: 30px; transition: all 0.3s ease; font-weight: 500; }
        .menu a:hover, .menu a.active { background: rgba(255,255,255,0.2); transform: translateY(-2px); }
        .auth-menu { display: flex; align-items: center; gap: 15px; margin-left: auto; }
        .auth-menu span { color: white; font-weight: 500; }
        .auth-menu a { color: white; text-decoration: none; padding: 8px 16px; border-radius: 30px; transition: all 0.3s ease; }
        .auth-menu a:hover { background: rgba(255,255,255,0.2); }
        .auth-menu button { background: #ff8c42; border: none; padding: 8px 16px; border-radius: 30px; color: white; cursor: pointer; font-weight: 500; transition: all 0.3s ease; }
        .auth-menu button:hover { background: #e67e22; }
        .dark-mode-toggle { background: none !important; padding: 8px 12px !important; }

        .hero-home { margin-top: 70px; height: 550px; position: relative; background-image: url('https://images.unsplash.com/photo-1551632811-561732d1e306?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'); background-size: cover; background-position: center 30%; background-attachment: fixed; display: flex; justify-content: center; align-items: center; color: white; text-align: center; }
        .hero-small { margin-top: 70px; height: 300px; position: relative; background-image: url('{{ asset("image/headersewa.jpg") }}'); background-size: cover; background-position: center; display: flex; justify-content: center; align-items: center; color: white; text-align: center; }
        .hero-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(135deg, rgba(27,94,47,0.7) 0%, rgba(67,160,71,0.5) 100%); }
        .hero-content { position: relative; z-index: 2; }
        .hero-home h1 { font-size: 64px; font-weight: 800; margin-bottom: 15px; }
        .hero-small h1 { font-size: 48px; font-weight: 800; margin-bottom: 15px; }
        .container { max-width: 1400px; margin: 0 auto; padding: 50px 30px; }
        .stat-row { display: grid; grid-template-columns: repeat(5, 1fr); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 20px; border-radius: 15px; text-align: center; box-shadow: 0 5px 20px rgba(0,0,0,0.08); }
        .stat-card .angka { font-size: 32px; font-weight: 700; color: #ff8c42; }
        .btn-tambah { display: inline-block; background: #43a047; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; margin-bottom: 20px; }
        .table-container { overflow-x: auto; margin: 20px 0; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 20px; overflow: hidden; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #1b5e2f; color: white; }
        .btn-edit, .btn-hapus { padding: 6px 12px; border: none; border-radius: 8px; cursor: pointer; color: white; }
        .btn-edit { background: #ff8c42; }
        .btn-hapus { background: #e74c3c; }
        .alert { padding: 15px; border-radius: 10px; margin-bottom: 20px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        footer { display: flex; justify-content: space-around; background: #1a2e1f; color: white; padding: 40px; flex-wrap: wrap; gap: 30px; }
        .footer-section h4 { color: #ff8c42; margin-bottom: 15px; }
        .footer-section a { color: #ccc; text-decoration: none; }
        @media (max-width: 768px) { .stat-row { grid-template-columns: repeat(2, 1fr); } .hero-home h1 { font-size: 32px; } .container { padding: 20px; } nav { flex-direction: column; gap: 10px; } }
    </style>
</head>
<body>

@include('partials.navbar')

@yield('hero')

<div class="container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif
    @yield('content')
</div>

@include('partials.footer')

@stack('scripts')
</body>
</html>
