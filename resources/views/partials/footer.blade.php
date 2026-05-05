<footer>
    <div class="footer-section">
        <h4><i class="fas fa-mountain"></i> SummitBuddy</h4>
        <p>Sistem Penyewaan Alat Pendakian</p>
        <p style="margin-top: 10px; font-size: 12px;">&copy; {{ date('Y') }} SummitBuddy</p>
    </div>
    <div class="footer-section">
        <h4>Tentang Kami</h4>
        <p>SummitBuddy adalah platform penyewaan alat pendakian yang berdiri sejak 2020.</p>
        <p>Kami menyediakan perlengkapan pendakian berkualitas dengan harga terjangkau.</p>
    </div>
    <div class="footer-section">
        <h4>Menu</h4>
        <p>
            <a href="{{ route('home') }}">Home</a><br>
            <a href="{{ route('data-alat') }}">Data Alat</a><br>
            <a href="{{ route('kelola-alat') }}">Kelola Alat</a><br>
            <a href="{{ route('form-sewa') }}">Form Sewa</a>
        </p>
    </div>
    <div class="footer-section">
        <h4>Kontak</h4>
        <p><i class="fas fa-envelope"></i> info@summitbuddy.com</p>
        <p><i class="fas fa-phone"></i> 0812-3456-7890</p>
        <p><i class="fab fa-instagram"></i> @summitbuddy</p>
        <p><i class="fab fa-whatsapp"></i> 0812-3456-7890</p>
    </div>
</footer>
