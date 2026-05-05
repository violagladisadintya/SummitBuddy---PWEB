<nav>
    <div class="logo">
        <img src="{{ asset('image/logo.png') }}" alt="Logo SummitBuddy" onerror="this.src='https://via.placeholder.com/40?text=SB'">
        <span>SummitBuddy</span>
    </div>
    <div class="menu">
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
            <i class="fas fa-home"></i> Home
        </a>
        <a href="{{ route('data-alat') }}" class="{{ request()->routeIs('data-alat') ? 'active' : '' }}">
            <i class="fas fa-box"></i> Data Alat
        </a>
        <a href="{{ route('kelola-alat') }}" class="{{ request()->routeIs('kelola-alat') ? 'active' : '' }}">
            <i class="fas fa-cog"></i> Kelola Alat
        </a>
        <a href="{{ route('form-sewa') }}" class="{{ request()->routeIs('form-sewa') ? 'active' : '' }}">
            <i class="fas fa-file-invoice"></i> Form Sewa
        </a>
    </div>
</nav>
