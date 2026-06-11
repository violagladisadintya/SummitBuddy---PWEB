<footer>
    <div class="footer-section">
        <h4><i class="fas fa-mountain"></i> SummitBuddy</h4>
        <p>Sistem Penyewaan Alat Pendakian</p>
        <p style="margin-top: 15px; font-size: 12px; opacity: 0.7;">&copy; {{ date('Y') }} SummitBuddy. All rights reserved.</p>
    </div>
    <div class="footer-section">
        <h4>Tentang Kami</h4>
        <p>SummitBuddy adalah platform penyewaan alat pendakian yang berdiri sejak 2020.</p>
        <p>Kami menyediakan perlengkapan pendakian berkualitas dengan harga terjangkau.</p>
    </div>
    <div class="footer-section" style="display: flex; flex-direction: column;">
        <h4>Menu</h4>
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('data-alat') }}">Data Alat</a>
        <a href="{{ route('form-sewa') }}">Form Sewa</a>
        @if(auth()->check() && auth()->user()->email === 'admin@summitbuddy.com')
            <a href="{{ route('kelola-alat') }}">Kelola Alat</a>
        @endif
    </div>
    <div class="footer-section">
        <h4>Kontak & Alamat</h4>
        <p><i class="fas fa-map-marker-alt"></i> Jl. Mastrip No. 45, Sumbersari, Jember Kota</p>
        <p><i class="fas fa-envelope"></i> info@summitbuddy.com</p>
        <p><i class="fas fa-phone"></i> 0812-3456-7890</p>
        <p><i class="fab fa-instagram"></i> @summitbuddy</p>
        <p><i class="fab fa-whatsapp"></i> 0812-3456-7890</p>
    </div>
</footer>
