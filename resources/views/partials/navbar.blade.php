<nav>
    <div class="logo">
        <img src="{{ asset('image/logo.png') }}" alt="Logo SummitBuddy">
        <span>SummitBuddy</span>
    </div>
    <div class="menu">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('data-alat') }}">Data Alat</a>
        <a href="{{ route('alat.live-search') }}">🔍 Cari Alat</a>
        <a href="{{ route('weather.index') }}">🌤️ Info Cuaca</a>
        <a href="{{ route('kunjungan.index') }}">📈 Kunjungan</a>
        <a href="{{ route('preferensi.index') }}">⚙️ Pengaturan</a>
        @auth
            <a href="{{ route('kelola-alat') }}">Kelola Alat</a>
            <a href="{{ route('alat.index') }}">CRUD Alat</a>
        @endauth
        <a href="{{ route('form-sewa') }}">Form Sewa</a>
    </div>
    <div class="auth-menu">
        <button id="darkModeToggle" class="dark-mode-toggle">
            <span id="darkModeIcon">🌙</span>
        </button>
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

<script>
function setCookie(name, value, days = 365) {
    const expires = new Date();
    expires.setTime(expires.getTime() + days * 24 * 60 * 60 * 1000);
    document.cookie = `${name}=${encodeURIComponent(value)};expires=${expires.toUTCString()};path=/;SameSite=Lax`;
}

function getCookie(name) {
    const cookies = document.cookie.split(';');
    for (const cookie of cookies) {
        const [key, val] = cookie.trim().split('=');
        if (key === name) return decodeURIComponent(val);
    }
    return null;
}

function deleteCookie(name) {
    document.cookie = `${name}=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/`;
}

const toggleBtn = document.getElementById('darkModeToggle');
const darkModeIcon = document.getElementById('darkModeIcon');

if (toggleBtn) {
    function updateDarkModeIcon() {
        const isDark = document.documentElement.classList.contains('dark');
        darkModeIcon.textContent = isDark ? '☀️' : '🌙';
    }

    toggleBtn.addEventListener('click', () => {
        const html = document.documentElement;
        const isDark = html.classList.contains('dark');
        const newTheme = isDark ? 'light' : 'dark';

        setCookie('preferensi_tema', newTheme, 365);

        if (newTheme === 'dark') {
            html.classList.add('dark');
        } else {
            html.classList.remove('dark');
        }

        updateDarkModeIcon();
    });

    updateDarkModeIcon();
}
</script>
