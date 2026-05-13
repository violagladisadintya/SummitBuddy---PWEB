<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SummitBuddy') - Sewa Alat Pendakian</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @stack('styles')
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f9f5 0%, #e8f0e8 100%);
            color: #2c3e2f;
            line-height: 1.6;
        }
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(27, 94, 47, 0.95);
            backdrop-filter: blur(10px);
            padding: 15px 30px;
            color: white;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .logo { display: flex; align-items: center; gap: 10px; }
        .logo img { width: 40px; height: 40px; object-fit: contain; }
        .logo span { font-size: 22px; font-weight: 800; }
        .menu {
            display: flex;
            align-items: center;
        }
        .menu a {
            color: white;
            margin-left: 25px;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 30px;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        .menu a:hover, .menu a.active {
            background: rgba(255,255,255,0.2);
            transform: translateY(-2px);
        }
        .auth-menu {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-left: auto;
        }
        .auth-menu span {
            color: white;
            font-weight: 500;
        }
        .auth-menu a {
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 30px;
            transition: all 0.3s ease;
        }
        .auth-menu a:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        .auth-menu button {
            background: #ff8c42;
            border: none;
            padding: 8px 16px;
            border-radius: 30px;
            color: white;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .auth-menu button:hover {
            background: #e67e22;
        }
        .hero-home {
            margin-top: 70px;
            height: 550px;
            position: relative;
            background-image: url('https://images.unsplash.com/photo-1551632811-561732d1e306?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');
            background-size: cover;
            background-position: center 30%;
            background-attachment: fixed;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
        }
        .hero-small {
            margin-top: 70px;
            height: 300px;
            position: relative;
            background-image: url('{{ asset("image/headersewa.jpg") }}');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
        }
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(27,94,47,0.7) 0%, rgba(67,160,71,0.5) 100%);
        }
        .hero-content { position: relative; z-index: 2; }
        .hero-home h1 { font-size: 64px; font-weight: 800; margin-bottom: 15px; }
        .hero-small h1 { font-size: 48px; font-weight: 800; margin-bottom: 15px; }
        .hero-home p, .hero-small p { font-size: 20px; margin-bottom: 30px; }
        .btn-hero {
            display: inline-block;
            padding: 14px 35px;
            background: #ff8c42;
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-hero:hover { background: #e67e22; transform: translateY(-3px); }
        .container { max-width: 1400px; margin: 0 auto; padding: 50px 30px; }
        section h2 {
            margin-bottom: 25px;
            color: #1b5e2f;
            border-left: 4px solid #ff8c42;
            padding-left: 15px;
        }
        .grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 25px; margin-bottom: 50px; }
        .card {
            background: white;
            padding: 20px;
            text-align: center;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }
        .card:hover { transform: translateY(-8px); }
        .card img { width: 100%; height: 180px; object-fit: cover; border-radius: 15px; margin-bottom: 15px; }
        .card p { font-weight: 700; font-size: 18px; color: #1b5e2f; }
        .card .harga { color: #ff8c42; font-weight: 600; }
        .ulasan-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 25px; margin: 30px 0; }
        .ulasan-card {
            background: white;
            padding: 25px;
            border-radius: 20px;
            border-left: 5px solid #ff8c42;
        }
        .rating { color: #ffc107; font-size: 20px; margin-bottom: 10px; }
        .table-container { overflow-x: auto; margin: 20px 0; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 20px; overflow: hidden; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #1b5e2f; color: white; }
        tr:hover { background: #f5f5f5; }
        .btn-edit, .btn-hapus, .btn-tambah {
            padding: 6px 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            color: white;
        }
        .btn-edit { background: #ff8c42; }
        .btn-hapus { background: #e74c3c; }
        .btn-tambah { background: #43a047; padding: 10px 20px; margin-bottom: 20px; }
        .stat-row { display: grid; grid-template-columns: repeat(5, 1fr); gap: 20px; margin-bottom: 30px; }
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
        }
        .stat-card .angka { font-size: 32px; font-weight: 700; color: #ff8c42; }
        .tab-buttons { display: flex; gap: 15px; margin-bottom: 25px; }
        .tab-btn { padding: 12px 25px; background: #e0e0e0; border: none; border-radius: 30px; cursor: pointer; font-weight: 600; }
        .tab-btn.active { background: linear-gradient(135deg, #1b5e2f, #43a047); color: white; }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        form { background: white; padding: 30px; border-radius: 20px; max-width: 600px; margin: 0 auto; }
        label { display: block; margin: 15px 0 5px; font-weight: 600; }
        input, select, textarea { width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 10px; }
        button[type="submit"] {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #ff8c42, #e67e22);
            color: white;
            border: none;
            border-radius: 50px;
            font-weight: bold;
            margin-top: 20px;
            cursor: pointer;
        }
        .alert { padding: 15px; border-radius: 10px; margin-bottom: 20px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        aside {
            background: white;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            height: fit-content;
            position: sticky;
            top: 90px;
        }
        aside h3 {
            margin-bottom: 20px;
            color: #1b5e2f;
            font-size: 18px;
            border-bottom: 2px solid #ff8c42;
            padding-bottom: 8px;
            display: inline-block;
        }
        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin: 20px 0 30px 0;
        }
        .filter-group label {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            font-weight: normal;
            padding: 5px 0;
            margin: 0;
        }
        .filter-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #1b5e2f;
            margin: 0;
        }
        .stat-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .stat-value { font-weight: bold; color: #ff8c42; }
        .search-box {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        .search-box input {
            flex: 1;
            padding: 12px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 50px;
        }
        .search-box button {
            padding: 12px 30px;
            background: linear-gradient(135deg, #1b5e2f, #43a047);
            color: white;
            border: none;
            border-radius: 50px;
            cursor: pointer;
        }
        footer {
            display: flex;
            justify-content: space-around;
            background: #1a2e1f;
            color: white;
            padding: 40px;
            flex-wrap: wrap;
            gap: 30px;
        }
        .footer-section h4 { color: #ff8c42; margin-bottom: 15px; }
        .footer-section a { color: #ccc; text-decoration: none; }
        @media (max-width: 768px) {
            .grid { grid-template-columns: repeat(2, 1fr); }
            .ulasan-grid { grid-template-columns: 1fr; }
            nav { flex-direction: column; gap: 10px; }
            .hero-home h1 { font-size: 32px; }
            .stat-row { grid-template-columns: repeat(2, 1fr); }
            .container { padding: 20px; }
            aside { position: static; margin-bottom: 20px; }
        }
    </style>
</head>
<body>

@include('partials.navbar')

@yield('hero')

<div class="container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    @yield('content')
</div>

@include('partials.footer')

@stack('scripts')
</body>
</html>
