<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'SummitBuddy')</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(rgba(27, 94, 47, 0.45), rgba(15, 25, 35, 0.75)), url('{{ asset('image/headergunung.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .auth-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 24px;
            padding: 40px 30px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.3);
            color: white;
            animation: fadeIn 0.6s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .auth-logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .auth-logo i {
            font-size: 54px;
            color: #ff8c42;
            margin-bottom: 12px;
            filter: drop-shadow(0 0 10px rgba(255,140,66,0.3));
        }
        .auth-logo h2 {
            font-size: 32px;
            font-weight: 800;
            letter-spacing: 1px;
            background: linear-gradient(135deg, #ffffff, #ff8c42);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .auth-logo p {
            font-size: 13px;
            opacity: 0.8;
            margin-top: 5px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #ff8c42;
        }
        .input-group {
            position: relative;
        }
        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.6);
            transition: color 0.3s ease;
        }
        .input-group input {
            width: 100%;
            padding: 14px 15px 14px 45px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            color: white;
            font-size: 14px;
            outline: none;
            transition: all 0.3s ease;
        }
        .input-group input:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: #ff8c42;
            box-shadow: 0 0 12px rgba(255, 140, 66, 0.4);
        }
        .input-group input:focus + i {
            color: #ff8c42;
        }
        .input-group input::placeholder {
            color: rgba(255,255,255,0.4);
        }
        .auth-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #ff8c42, #e67e22);
            color: white;
            border: none;
            border-radius: 50px;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(230, 126, 34, 0.4);
            margin-top: 10px;
        }
        .auth-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(230, 126, 34, 0.6);
        }
        .auth-footer {
            text-align: center;
            margin-top: 25px;
            font-size: 13px;
            opacity: 0.9;
        }
        .auth-footer a {
            color: #ff8c42;
            text-decoration: none;
            font-weight: 600;
        }
        .auth-footer a:hover {
            text-decoration: underline;
        }
        .error-msg {
            color: #ff6b6b;
            font-size: 12px;
            margin-top: 5px;
            display: block;
            font-weight: 500;
        }
        .alert {
            background: rgba(231, 76, 60, 0.2);
            border: 1px solid rgba(231, 76, 60, 0.4);
            color: #ff8b8b;
            padding: 12px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="auth-card">
        @yield('content')
    </div>
</body>
</html>
