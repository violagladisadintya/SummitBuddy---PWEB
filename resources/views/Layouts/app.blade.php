<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SummitBuddy')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    @stack('styles')
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f9f5 0%, #e8f0e8 100%);
            color: #2c3e2f;
        }
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(27, 94, 47, 0.95);
            padding: 15px 30px;
            color: white;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
        .logo span { font-size: 22px; font-weight: 800; }
        .menu a {
            color: white;
            margin-left: 25px;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 30px;
        }
        .menu a:hover { background: rgba(255,255,255,0.2); }
        .hero {
            margin-top: 70px;
            height: 400px;
            background: linear-gradient(135deg, #1b5e2f, #43a047);
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
        }
        .hero-small {
            margin-top: 70px;
            height: 200px;
            background: linear-gradient(135deg, #1b5e2f, #43a047);
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
        }
        .hero h1 { font-size: 56px; }
        .hero-small h1 { font-size: 40px; }
        .btn-hero {
            display: inline-block;
            padding: 14px 35px;
            background: #ff8c42;
            color: white;
            text-decoration: none;
            border-radius: 50px;
            margin-top: 20px;
        }
        .container { max-width: 1200px; margin: 50px auto; padding: 0 20px; }
        .grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 25px; margin-bottom: 50px; }
        .card {
            background: white;
            padding: 20px;
            text-align: center;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }
        .card:hover { transform: translateY(-5px); }
        .card p { font-weight: 700; font-size: 18px; color: #1b5e2f; }
        .card .harga { color: #ff8c42; font-weight: 600; }
        .stat-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }
        .stat-card .angka { font-size: 36px; font-weight: 700; color: #ff8c42; }
        .table-container { overflow-x: auto; margin: 20px 0; }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 20px;
            overflow: hidden;
        }
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
        .tab-buttons { display: flex; gap: 15px; margin-bottom: 25px; }
        .tab-btn {
            padding: 12px 25px;
            background: #e0e0e0;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            font-weight: 600;
        }
        .tab-btn.active { background: linear-gradient(135deg, #1b5e2f, #43a047); color: white; }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        aside {
            background: white;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            height: fit-content;
            position: sticky;
            top: 90px;
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
        }
        .filter-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #1b5e2f;
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
            background: #1a2e1f;
            color: white;
            text-align: center;
            padding: 30px;
            margin-top: 50px;
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 2000;
            justify-content: center;
            align-items: center;
        }
        .modal.active { display: flex; }
        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 20px;
            width: 90%;
            max-width: 500px;
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .close-modal {
            font-size: 28px;
            cursor: pointer;
            color: #999;
        }
        .close-modal:hover { color: #e74c3c; }
        @media (max-width: 768px) {
            .grid { grid-template-columns: repeat(2, 1fr); }
            .stat-row { grid-template-columns: repeat(2, 1fr); }
            nav { flex-direction: column; gap: 10px; }
            .hero h1 { font-size: 32px; }
        }
    </style>
</head>
<body>

<nav>
    <div class="logo">
        <span>🏔️ SummitBuddy</span>
    </div>
    <div class="menu">
        <a href="/">Home</a>
        <a href="/dashboard">Dashboard</a>
        <a href="/data-alat">Data Alat</a>
        <a href="/kelola-alat">Kelola Alat</a>
        <a href="/tentang">Tentang</a>
    </div>
</nav>

@yield('hero')

<div class="container">
    @if(session('success'))
        <div class="alert" style="background:#d4edda; padding:15px; border-radius:10px; margin-bottom:20px;">
            {{ session('success') }}
        </div>
    @endif
    @yield('content')
</div>

<footer>
    <p>&copy; 2024 SummitBuddy - Sistem Penyewaan Alat Pendakian</p>
</footer>

@stack('scripts')
</body>
</html>
