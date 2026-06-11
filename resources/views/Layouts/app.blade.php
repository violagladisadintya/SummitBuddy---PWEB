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
        .dark body { background: linear-gradient(135deg, #12121e 0%, #1a1a2e 100%); color: #eee; }
        .dark aside, .dark form, .dark .table-container table { background: #22223b; color: #eee; }
        
        /* White Cards in Dark Mode */
        .dark .stat-card, .dark .card, .dark .ulasan-card, .dark .form-section-card { 
            background: #ffffff !important; 
            color: #2c3e2f !important; 
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
        }
        .dark .stat-card h4, .dark .card p, .dark .ulasan-user strong, .dark .form-section-card h3 { color: #1b5e2f !important; }
        .dark .card .harga, .dark .stat-card .angka { color: #ff8c42 !important; }
        .dark .ulasan-text { color: #555 !important; }
        .dark .ulasan-user span { color: #999 !important; }

        /* Style inputs inside white cards (even in dark mode) to have light backgrounds & dark text */
        .form-section-card input, .form-section-card select, .form-section-card textarea {
            background-color: #ffffff !important;
            color: #2c3e2f !important;
            border: 2px solid #e8e8e8 !important;
        }
        .form-section-card input:focus, .form-section-card select:focus, .form-section-card textarea:focus {
            border-color: #43a047 !important;
            box-shadow: 0 0 0 3px rgba(67, 160, 71, 0.15) !important;
        }
        .form-section-card label {
            color: #1b5e2f !important;
        }
        .dark .form-section-card p, .dark .form-section-card span, .dark .form-section-card div {
            color: #2c3e2f !important;
        }

        .dark td { border-bottom-color: #3d3d5c; }
        .dark tr:hover { background: #2d2d44; }
        .dark input, .dark select, .dark textarea { background: #12121e; border-color: #3d3d5c; color: #eee; }
        .dark input::placeholder { color: #888; }
        .dark .alert-success { background: #1a3a2a; color: #90ee90; border-color: #2d5a3d; }
        .dark .alert-error { background: #3a1a1a; color: #ff9999; border-color: #5a2d2d; }
        .dark label, .dark h2, .dark h3 { color: #ff8c42 !important; }
        .dark aside h3, .dark section h2 { color: #ff8c42 !important; border-left-color: #ff8c42; }
        .dark p { color: #ddd; }
        .dark .ulasan-text { color: #bbb; }
        .dark td { color: #ddd; }
        
        /* Dark Mode Specific Overrides for White Spaces & Tables */
        .dark table { background: #22223b !important; color: #eee !important; }
        .dark th { background: #143d20 !important; }
        .dark td { border-bottom-color: #3d3d5c !important; color: #ddd !important; }
        .dark aside div { border-bottom-color: #3d3d5c !important; }
        .dark input[type="checkbox"] { accent-color: #ff8c42 !important; }
        .dark #searchInput { border-color: #3d3d5c !important; }

        /* Navigation Bar */
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

        /* Heros */
        .hero-home { margin-top: 70px; height: 550px; position: relative; background-image: url('https://images.unsplash.com/photo-1551632811-561732d1e306?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'); background-size: cover; background-position: center 30%; background-attachment: fixed; display: flex; justify-content: center; align-items: center; color: white; text-align: center; }
        .hero-small { margin-top: 70px; height: 300px; position: relative; background-image: url('{{ asset("image/headersewa.jpg") }}'); background-size: cover; background-position: center; display: flex; justify-content: center; align-items: center; color: white; text-align: center; }
        .hero-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(135deg, rgba(27,94,47,0.7) 0%, rgba(67,160,71,0.5) 100%); }
        .hero-content { position: relative; z-index: 2; }
        .hero-home h1 { font-size: 64px; font-weight: 800; margin-bottom: 15px; }
        .hero-small h1 { font-size: 48px; font-weight: 800; margin-bottom: 15px; }
        
        /* Containers & Stats */
        .container { max-width: 1400px; margin: 0 auto; padding: 50px 30px; }
        .stat-row { display: grid; grid-template-columns: repeat(5, 1fr); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 20px; border-radius: 15px; text-align: center; box-shadow: 0 5px 20px rgba(0,0,0,0.08); }
        .stat-card .angka { font-size: 32px; font-weight: 700; color: #ff8c42; }
        .btn-tambah { display: inline-block; background: #43a047; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; margin-bottom: 20px; }
        
        /* Grid & Cards (Styled for popular equipment and reviews) */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 25px;
            margin-bottom: 50px;
        }
        .card {
            background: white;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.06);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.12);
        }
        .card img {
            width: 100%;
            height: 130px; /* Reduced for home page popular equipment */
            object-fit: cover;
            border-radius: 15px;
            margin-bottom: 15px;
        }
        .card p {
            font-weight: 700;
            font-size: 16px;
            color: #1b5e2f;
            margin-bottom: 8px;
        }
        .card .harga {
            font-size: 14px;
            color: #ff8c42;
            font-weight: 600;
            margin-top: auto;
        }

        /* Aside sidebar */
        aside {
            background: white;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            height: fit-content;
            position: sticky;
            top: 90px;
        }

        /* Reviews as Cards */
        .ulasan-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            margin: 30px 0;
        }
        .ulasan-card {
            background: white;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            border-left: 5px solid #ff8c42;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .ulasan-card:hover {
            transform: translateY(-5px) translateX(3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .rating {
            color: #ffc107;
            font-size: 22px;
            margin-bottom: 12px;
        }
        .ulasan-text {
            font-style: italic;
            margin-bottom: 15px;
            color: #555;
            line-height: 1.6;
        }
        .ulasan-user {
            border-top: 1px solid #eee;
            padding-top: 12px;
            margin-top: auto;
        }
        .ulasan-user strong {
            color: #1b5e2f;
            display: block;
        }
        .ulasan-user span {
            font-size: 12px;
            color: #999;
        }

        /* Form as Card Styling */
        form {
            background: white;
            padding: 35px;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
            max-width: 650px;
            margin: 0 auto;
        }
        label {
            display: block;
            margin: 18px 0 8px;
            font-weight: 600;
            color: #1b5e2f;
        }
        input, select, textarea {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid #e8e8e8;
            border-radius: 12px;
            font-size: 15px;
            background-color: white;
            color: #2c3e2f;
            transition: all 0.3s ease;
        }
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #43a047;
            box-shadow: 0 0 0 3px rgba(67, 160, 71, 0.15);
        }
        form button {
            width: 100%;
            padding: 14px 28px;
            background: linear-gradient(135deg, #ff8c42, #e67e22);
            color: white;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-top: 25px;
            box-shadow: 0 5px 15px rgba(255, 140, 66, 0.3);
        }
        form button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 140, 66, 0.4);
        }
        
        /* Form Helper Text */
        .form-hint {
            color: #666;
            transition: color 0.3s ease;
        }
        .dark .form-hint {
            color: #bbb;
        }
        
        /* Reset forms in Navbar and Admin Modals from Card styling */
        .auth-menu form, .modal form {
            background: none !important;
            padding: 0 !important;
            border-radius: 0 !important;
            box-shadow: none !important;
            max-width: none !important;
            margin: 0 !important;
            display: inline !important;
        }
        
        .auth-menu form button {
            width: auto !important;
            padding: 8px 16px !important;
            background: #ff8c42 !important;
            color: white !important;
            border-radius: 30px !important;
            margin-top: 0 !important;
            box-shadow: none !important;
            font-size: 14px !important;
        }
        .auth-menu form button:hover {
            background: #e67e22 !important;
            transform: none !important;
        }

        /* Tables */
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
        
        /* Warning Row for Low Stock */
        .stok-warning {
            background-color: #fff3cd !important;
            color: #856404 !important;
        }
        .dark .stok-warning {
            background-color: #4a3818 !important; /* dark amber background */
            color: #ffe0b2 !important;
        }
        .dark .stok-warning td {
            color: #ffe0b2 !important;
        }
        .dark .stok-warning td span {
            color: #ffe0b2 !important;
        }

        /* Footer Polished Styling */
        footer {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            background: #1a2e1f;
            color: #eee;
            padding: 50px 40px 30px 40px;
            gap: 40px;
            margin-top: 60px;
            border-top: 4px solid #ff8c42;
        }
        .footer-section h4 {
            color: #ff8c42;
            margin-bottom: 20px;
            font-size: 18px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .footer-section p {
            font-size: 14px;
            color: #ccc;
            line-height: 1.8;
            margin-bottom: 10px;
        }
        .footer-section a {
            color: #ccc;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
            margin-bottom: 8px;
        }
        .footer-section a:hover {
            color: #ff8c42;
            transform: translateX(4px);
        }
        .footer-section i {
            width: 20px;
            color: #ff8c42;
        }

        /* STAT ROW 3 COLUMNS */
        .stat-row-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        @media (max-width: 768px) {
            .stat-row-3 {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 480px) {
            .stat-row-3 {
                grid-template-columns: 1fr;
            }
        }

        /* NAV LINKS CONTAINER (DESKTOP) */
        .nav-links-container {
            display: flex;
            align-items: center;
            flex-grow: 1;
            justify-content: space-between;
        }
        .mobile-toggle-group {
            display: none;
            align-items: center;
            gap: 15px;
        }
        .menu-toggle {
            background: none;
            border: none;
            color: white;
            font-size: 22px;
            cursor: pointer;
            padding: 5px;
            display: none;
        }
        .mobile-only-toggle {
            display: none;
        }

        /* SCROLLABLE MODAL CARD ON SHORT SCREENS */
        .modal > div {
            max-height: 90vh;
            overflow-y: auto;
        }

        /* RESPONSIVE DATE GRID */
        .date-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        @media (max-width: 576px) {
            .date-grid {
                grid-template-columns: 1fr;
            }
        }

        /* RESPONSIVE ALAT ROW SELECTION */
        @media (max-width: 576px) {
            .alat-row {
                flex-direction: column;
                align-items: stretch !important;
                gap: 12px;
                padding: 15px !important;
            }
            .alat-row .qty-container {
                justify-content: flex-end;
                width: 100%;
                border-top: 1px dashed #eee;
                padding-top: 10px;
            }
            .dark .alat-row .qty-container {
                border-top-color: #3d3d5c;
            }
        }

        /* RESPONSIVE TABLES (CARD LOOK ON MOBILE) */
        @media (max-width: 768px) {
            .table-container {
                border: none;
                box-shadow: none;
                padding: 0;
            }
            table.responsive-table {
                background: transparent !important;
                border: none !important;
            }
            table.responsive-table thead {
                display: none;
            }
            table.responsive-table tbody,
            table.responsive-table tr,
            table.responsive-table td {
                display: block;
                width: 100%;
            }
            table.responsive-table tr {
                background: white !important;
                border: 1px solid #e0e0e0;
                border-radius: 16px;
                padding: 16px;
                margin-bottom: 15px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.04);
            }
            .dark table.responsive-table tr {
                background: #22223b !important;
                border-color: #3d3d5c;
            }
            table.responsive-table td {
                text-align: right;
                padding: 10px 0;
                border-bottom: 1px dashed #e8e8e8 !important;
                display: flex;
                justify-content: space-between;
                align-items: center;
                font-size: 14px;
            }
            .dark table.responsive-table td {
                border-bottom-color: #3d3d5c !important;
                color: #ddd !important;
            }
            table.responsive-table td:last-child {
                border-bottom: none !important;
                padding-bottom: 0;
            }
            table.responsive-table td::before {
                content: attr(data-label);
                font-weight: 600;
                color: #1b5e2f;
                text-align: left;
                margin-right: 15px;
            }
            .dark table.responsive-table td::before {
                color: #ff8c42;
            }
            table.responsive-table td img {
                margin-left: auto;
            }
        }

        /* Responsive Media Queries */
        @media (max-width: 768px) {
            .stat-row { grid-template-columns: repeat(2, 1fr); }
            .hero-home { height: 400px; background-position: center; }
            .hero-home h1 { font-size: 40px; }
            .hero-small { height: 220px; }
            .hero-small h1 { font-size: 32px; }
            .container { padding: 20px 15px; }
            
            /* Navbar Mobile Toggle Menu */
            nav {
                padding: 12px 20px;
                flex-wrap: wrap;
            }
            .mobile-toggle-group {
                display: flex;
            }
            .menu-toggle {
                display: block;
            }
            .mobile-only-toggle {
                display: inline-block;
            }
            .desktop-only-toggle {
                display: none !important;
            }
            .nav-links-container {
                display: none;
                flex-direction: column;
                width: 100%;
                margin-top: 15px;
                border-top: 1px solid rgba(255,255,255,0.1);
                padding-top: 15px;
                gap: 15px;
            }
            .nav-links-container.show {
                display: flex;
                animation: slideDown 0.3s ease forwards;
            }
            .menu {
                flex-direction: column;
                width: 100%;
                gap: 10px;
            }
            .menu a {
                margin-left: 0;
                width: 100%;
                text-align: center;
                padding: 10px;
            }
            .auth-menu {
                flex-direction: column;
                width: 100%;
                margin-left: 0;
                gap: 10px;
                border-top: 1px dashed rgba(255,255,255,0.15);
                padding-top: 15px;
            }
            .auth-menu form {
                width: 100%;
                display: block !important;
                text-align: center;
            }
            .auth-menu form button {
                width: 100% !important;
                padding: 12px 20px !important;
            }
            
            footer { grid-template-columns: 1fr; text-align: center; gap: 30px; padding: 40px 20px 20px 20px; }
            .footer-section a:hover { transform: none; }
            .footer-section h4 { justify-content: center; }
        }

        @media (max-width: 480px) {
            .stat-row { grid-template-columns: 1fr; }
            .hero-home { height: 300px; }
            .hero-home h1 { font-size: 32px; }
            .hero-home p { font-size: 14px; }
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Toast Notifications */
        .toast-container {
            position: fixed;
            top: 90px;
            right: 30px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .toast {
            display: flex;
            align-items: center;
            background: white;
            color: #2c3e2f;
            padding: 16px 24px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border-left: 6px solid #43a047;
            min-width: 320px;
            max-width: 450px;
            animation: slideInRight 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            transition: all 0.3s ease;
        }
        .toast.toast-error {
            border-left-color: #e74c3c;
        }
        .toast-icon {
            font-size: 24px;
            margin-right: 15px;
            color: #43a047;
        }
        .toast-error .toast-icon {
            color: #e74c3c;
        }
        .toast-content {
            flex-grow: 1;
        }
        .toast-title {
            font-weight: 700;
            font-size: 15px;
            margin-bottom: 2px;
            color: #1b5e2f;
        }
        .toast-error .toast-title {
            color: #c0392b;
        }
        .toast-message {
            font-size: 13px;
            color: #555;
        }
        .toast-close {
            background: none;
            border: none;
            color: #999;
            cursor: pointer;
            font-size: 18px;
            padding: 0 0 0 15px;
            transition: color 0.2s;
        }
        .toast-close:hover {
            color: #333;
        }
        .dark .toast {
            background: #ffffff !important; /* Keep toast white or allow dark? Let's keep white since user wants nice cards, or styled */
            color: #2c3e2f !important;
        }
        .dark .toast-message {
            color: #555 !important;
        }
        .dark .toast-close:hover {
            color: #000 !important;
        }

        @keyframes slideInRight {
            from { transform: translateX(120%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes fadeOut {
            to { transform: translateY(-20px); opacity: 0; }
        }
    </style>
</head>
<body>

@include('partials.navbar')

@yield('hero')

<div class="container">
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                showToast('success', 'Berhasil', "{{ session('success') }}");
            });
        </script>
    @endif
    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                showToast('error', 'Gagal', "{{ session('error') }}");
            });
        </script>
    @endif
    @yield('content')
</div>

@include('partials.footer')

@stack('scripts')

<script>
function showToast(type, title, message) {
    let container = document.querySelector('.toast-container');
    if (!container) {
        container = document.createElement('div');
        container.className = 'toast-container';
        document.body.appendChild(container);
    }
    
    const toast = document.createElement('div');
    toast.className = `toast ${type === 'error' ? 'toast-error' : ''}`;
    
    const icon = type === 'error' ? 'fa-circle-xmark' : 'fa-circle-check';
    
    toast.innerHTML = `
        <div class="toast-icon"><i class="fa-solid ${icon}"></i></div>
        <div class="toast-content">
            <div class="toast-title">${title}</div>
            <div class="toast-message">${message}</div>
        </div>
        <button class="toast-close">&times;</button>
    `;
    
    container.appendChild(toast);
    
    const closeBtn = toast.querySelector('.toast-close');
    closeBtn.addEventListener('click', () => {
        toast.style.animation = 'fadeOut 0.3s forwards';
        setTimeout(() => toast.remove(), 300);
    });
    
    setTimeout(() => {
        if (toast.parentNode) {
            toast.style.animation = 'fadeOut 0.3s forwards';
            setTimeout(() => toast.remove(), 300);
        }
    }, 5000);
}
</script>
</body>
</html>
