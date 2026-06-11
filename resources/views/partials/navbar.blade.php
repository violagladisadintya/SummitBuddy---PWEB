<nav>
    <div class="logo">
        <img src="{{ asset('image/logo.png') }}" alt="Logo SummitBuddy">
        <span>SummitBuddy</span>
    </div>
    
    <!-- Mobile toggle controls -->
    <div class="mobile-toggle-group">
        <button id="darkModeToggleMobile" class="dark-mode-toggle mobile-only-toggle" style="background: none; border: none; cursor: pointer; font-size: 18px; padding: 8px;">
            <span id="darkModeIconMobile">🌙</span>
        </button>
        <button id="menuToggle" class="menu-toggle">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <div class="nav-links-container" id="navLinksContainer">
        <div class="menu">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('data-alat') }}">Data Alat</a>
            @if(auth()->check() && auth()->user()->email === 'admin@summitbuddy.com')
                <a href="{{ route('kelola-alat', ['tab' => 'sewa']) }}">Form Sewa</a>
            @else
                <a href="{{ route('form-sewa') }}">Form Sewa</a>
            @endif
            @if(auth()->check() && auth()->user()->email !== 'admin@summitbuddy.com')
                <a href="{{ route('riwayat-sewa') }}">Riwayat Sewa</a>
            @endif
            @if(auth()->check() && auth()->user()->email === 'admin@summitbuddy.com')
                <a href="{{ route('kelola-alat') }}">Kelola Alat</a>
            @endif
        </div>
        <div class="auth-menu">
            <button id="darkModeToggle" class="dark-mode-toggle desktop-only-toggle">
                <span id="darkModeIcon">🌙</span>
            </button>
            @auth
                <a href="{{ route('profile.edit') }}"><i class="fas fa-user"></i> {{ auth()->user()->name }}</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @endauth
        </div>
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

// Dark Mode Toggles
const toggleBtn = document.getElementById('darkModeToggle');
const toggleBtnMobile = document.getElementById('darkModeToggleMobile');
const darkModeIcon = document.getElementById('darkModeIcon');
const darkModeIconMobile = document.getElementById('darkModeIconMobile');

function updateDarkModeIcon() {
    const isDark = document.documentElement.classList.contains('dark');
    if (darkModeIcon) darkModeIcon.textContent = isDark ? '☀️' : '🌙';
    if (darkModeIconMobile) darkModeIconMobile.textContent = isDark ? '☀️' : '🌙';
}

function handleThemeToggle() {
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
}

if (toggleBtn) {
    toggleBtn.addEventListener('click', handleThemeToggle);
}
if (toggleBtnMobile) {
    toggleBtnMobile.addEventListener('click', handleThemeToggle);
}

updateDarkModeIcon();

// Hamburger Menu Toggle
const menuToggle = document.getElementById('menuToggle');
const navLinksContainer = document.getElementById('navLinksContainer');

if (menuToggle && navLinksContainer) {
    menuToggle.addEventListener('click', () => {
        navLinksContainer.classList.toggle('show');
        const icon = menuToggle.querySelector('i');
        if (icon) {
            if (navLinksContainer.classList.contains('show')) {
                icon.className = 'fas fa-times';
            } else {
                icon.className = 'fas fa-bars';
            }
        }
    });
}
</script>
