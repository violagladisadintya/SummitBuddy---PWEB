<nav>
    <div class="logo">
        <img src="{{ asset('image/logo.png') }}" alt="Logo SummitBuddy">
        <span>SummitBuddy</span>
    </div>
    <div class="menu">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('data-alat') }}">Data Alat</a>
        @auth
            <a href="{{ route('kelola-alat') }}">Kelola Alat</a>
            <a href="{{ route('alat.index') }}">CRUD Alat</a>
        @endauth
        <a href="{{ route('form-sewa') }}">Form Sewa</a>
    </div>
    <div class="auth-menu">
        @auth
            <span><i class="fas fa-user"></i> {{ auth()->user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
        @endauth
    </div>
</nav>
