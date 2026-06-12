**SummitBuddy** adalah platform penyewaan alat pendakian berbasis web yang dirancang untuk mempermudah proses peminjaman perlengkapan pendakian secara online. Sistem ini memungkinkan pelanggan melihat informasi alat yang tersedia, mengecek ketersediaan stok, melakukan penyewaan, serta mengunggah bukti pembayaran tanpa harus datang langsung ke lokasi penyewaan.

Selain membantu pelanggan, SummitBuddy juga menyediakan fitur manajemen bagi admin untuk mengelola data alat pendakian, memantau transaksi penyewaan, mengatur status peminjaman dan pengembalian alat, serta melihat laporan pendapatan secara terstruktur. Dengan adanya sistem ini, proses penyewaan yang sebelumnya dilakukan secara manual dapat menjadi lebih efisien, terorganisir, dan minim kesalahan.


Dibuat oleh: Viola Gladis Adintya (NIM: 242410101044)

Program Studi Sistem Informasi Fakultas Ilmu Komputer - Universitas Jember

🎥 Demo Video: https://youtu.be/rYTFfPuUei4


Tujuan Pengembangan
● Menyediakan informasi mengenai alat pendakian yang dapat diakses oleh pelanggan kapan saja tanpa harus datang langsung ke tempat penyewaan. 
● Memudahkan pelanggan dalam melakukan pemesanan alat pendakian sesuai kebutuhan dan ketersediaan perlengkapan. 
● Membantu pengelola dalam mengatur ketersediaan alat agar tidak terjadi bentrok jadwal penyewaan. 
● Mempermudah pencatatan dan pemantauan transaksi penyewaan serta pengembalian alat. 
● Menyediakan laporan penyewaan dan pendapatan yang dapat membantu pengelola dalam memantau perkembangan usaha.

Aplikasi **SummitBuddy** menyediakan fitur yang dirancang untuk memenuhi kebutuhan pelanggan maupun pengelola penyewaan alat pendakian.

### Fitur Pengguna (User)

**Autentikasi**

* Registrasi akun
* Login akun
* Logout akun

**Profil**

* Melihat profil pengguna
* Mengubah data profil

**Alat Pendakian**

* Melihat daftar alat pendakian
* Melihat detail alat pendakian
* Melihat ketersediaan alat
* Melakukan penyewaan alat pendakian
* Upload bukti transfer pembayaran

**Transaksi**

* Pembatalan transaksi yang masih berstatus pending
* Melihat transaksi aktif
* Melihat riwayat transaksi
* Filter transaksi berdasarkan status, kategori alat, dan tanggal penyewaan

**Ulasan**

* Membuat ulasan
* Melihat ulasan pengguna lain

### Fitur Admin

**Autentikasi**

* Login akun
* Logout akun
* Lupa Password

**Dashboard**

* Melihat total transaksi
* Melihat total pendapatan
* Melihat jumlah alat yang tersedia
* Monitoring aktivitas penyewaan

**Pengelolaan Alat**

* Menambah alat pendakian baru
* Mengubah data alat pendakian
* Mengatur status ketersediaan alat
* Soft delete alat 

**Transaksi**

* Melihat seluruh transaksi pengguna
* Mengonfirmasi penyewaan
* Mengonfirmasi pengembalian alat
* Menyelesaikan transaksi
* Monitoring transaksi berdasarkan status

**Ulasan**

* Melihat ulasan pengguna

## Teknologi yang Digunakan

### Backend

**PHP 8+** : Digunakan sebagai bahasa pemrograman utama untuk membangun logika bisnis dan proses pengolahan data pada sistem.

**Laravel 12** : Framework PHP yang digunakan untuk mempercepat pengembangan aplikasi melalui fitur routing, middleware, authentication, migration, Eloquent ORM, serta manajemen keamanan aplikasi.

### Frontend

**HTML5** : Digunakan untuk membangun struktur halaman website.

**CSS3** : Digunakan untuk mengatur tampilan antarmuka agar lebih menarik, responsif, dan mudah digunakan.

**JavaScript** : Digunakan untuk meningkatkan interaktivitas sistem seperti validasi form, popup konfirmasi, pencarian data, dan manipulasi elemen halaman.

**Blade Template Engine** : Digunakan sebagai template engine bawaan Laravel untuk membangun tampilan website secara dinamis dan efisien.

### Database

**MySQL** : Digunakan untuk menyimpan seluruh data aplikasi seperti data pengguna, alat pendakian, transaksi penyewaan, pengembalian alat, dan ulasan pengguna.

### Tools Development

**GitHub** : Digunakan sebagai repositori penyimpanan source code dan kolaborasi pengembangan.

**Laragon** : Digunakan sebagai local development server selama proses pembangunan aplikasi.

**Visual Studio Code** : Digunakan sebagai code editor utama dalam pengembangan sistem.

## Struktur Database

Sistem SummitBuddy menggunakan database relasional MySQL yang terdiri dari beberapa tabel utama berikut:

users : Menyimpan data akun pengguna dan administrator.

penyewas : Menyimpan data penyewa atau pelanggan yang melakukan transaksi penyewaan alat pendakian.

alats : Menyimpan informasi alat pendakian yang tersedia untuk disewakan, seperti nama alat, kategori, stok, harga sewa, dan status ketersediaan.

reviews : Menyimpan data ulasan dan penilaian yang diberikan oleh pengguna terhadap layanan SummitBuddy.

sewas : Mencatat seluruh transaksi penyewaan alat pendakian, termasuk data penyewa, alat yang disewa, tanggal penyewaan, status transaksi, dan informasi pembayaran.

## Status Transaksi

Sistem menggunakan beberapa status transaksi untuk memantau proses penyewaan:

* Tidak aktif
* Aktif

## Akun Akses Default

Berikut akun yang dapat digunakan untuk melakukan pengujian sistem:

### Admin

Email: admin@summitbuddy.com

Password: password

### User

Email: violagladis7@gmail.com

Password: Adintya06

## Lisensi

Proyek ini dikembangkan untuk keperluan akademik dan pembelajaran sebagai Proyek Akhir Mata Kuliah Pemrograman Berbasis Website Program Studi Sistem Informasi Universitas Jember.

Penggunaan, modifikasi, dan pengembangan lebih lanjut diperbolehkan untuk tujuan pendidikan dengan tetap mencantumkan kredit kepada pengembang.

