@extends('layouts.app')

@section('title', 'Profil Saya - SummitBuddy')

@section('hero')
<header class="hero-small">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1>Profil Saya</h1>
        <p>Kelola data akun dan keamanan Anda</p>
    </div>
</header>
@endsection

@section('content')
<section style="max-width: 800px; margin: 0 auto; display: flex; flex-direction: column; gap: 30px;">
    
    <!-- CARD 1: INFORMASI PROFIL -->
    <div class="form-section-card" style="background: #ffffff; padding: 30px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #e0e0e0; color: #333333;">
        <h3 style="color: #1b5e2f; font-size: 18px; margin-top: 0; margin-bottom: 8px; font-weight: 700; border-bottom: 2px solid #e8f5e9; padding-bottom: 10px; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-id-card"></i> Informasi Profil
        </h3>
        <p style="color: #666; font-size: 13.5px; margin-bottom: 20px;">Perbarui nama akun, alamat email Anda, dan hak akses Anda.</p>
        
        <form method="post" action="{{ route('profile.update') }}" style="background: none; padding: 0; box-shadow: none; max-width: 100%; margin: 0;">
            @csrf
            @method('patch')

            <div style="margin-bottom: 15px;">
                <label for="name" style="font-weight: 600; margin-bottom: 8px; display: block; color: #1b5e2f; margin-top: 0;">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ccc; background: #fff; color: #333;">
                @error('name') <small style="color:red; display:block; margin-top:5px;">{{ $message }}</small> @enderror
            </div>

            <div style="margin-bottom: 15px;">
                <label for="email" style="font-weight: 600; margin-bottom: 8px; display: block; color: #1b5e2f; margin-top: 0;">Alamat Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ccc; background: #fff; color: #333;">
                @error('email') <small style="color:red; display:block; margin-top:5px;">{{ $message }}</small> @enderror
            </div>

            <div style="margin-bottom: 15px;">
                <label style="font-weight: 600; margin-bottom: 8px; display: block; color: #1b5e2f; margin-top: 0;">Hak Akses Akun</label>
                <input type="text" value="{{ $user->email === 'admin@summitbuddy.com' ? 'Administrator' : 'Pelanggan Aktif' }}" disabled style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ccc; background: #f5f5f5; color: #888;">
            </div>

            <div style="display: flex; align-items: center; gap: 15px; margin-top: 25px;">
                <button type="submit" style="padding: 12px 30px; background: linear-gradient(135deg, #1b5e2f, #43a047); color: white; border: none; border-radius: 50px; cursor: pointer; font-weight: 600; font-size: 14px;">Simpan Perubahan</button>
                @if (session('status') === 'profile-updated')
                    <span style="color: #2e7d32; font-size: 13.5px; font-weight: 500;"><i class="fas fa-check-circle"></i> Berhasil disimpan.</span>
                @endif
            </div>
        </form>
    </div>

    <!-- CARD 2: PERBARUI PASSWORD -->
    <div class="form-section-card" style="background: #ffffff; padding: 30px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #e0e0e0; color: #333333;">
        <h3 style="color: #1b5e2f; font-size: 18px; margin-top: 0; margin-bottom: 8px; font-weight: 700; border-bottom: 2px solid #e8f5e9; padding-bottom: 10px; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-key"></i> Keamanan Akun (Ubah Password)
        </h3>
        <p style="color: #666; font-size: 13.5px; margin-bottom: 20px;">Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.</p>
        
        <form method="post" action="{{ route('password.update') }}" style="background: none; padding: 0; box-shadow: none; max-width: 100%; margin: 0;">
            @csrf
            @method('put')

            <div style="margin-bottom: 15px;">
                <label for="update_password_current_password" style="font-weight: 600; margin-bottom: 8px; display: block; color: #1b5e2f; margin-top: 0;">Password Saat Ini</label>
                <input type="password" id="update_password_current_password" name="current_password" required autocomplete="current-password" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ccc; background: #fff; color: #333;">
                @error('current_password', 'updatePassword') <small style="color:red; display:block; margin-top:5px;">{{ $message }}</small> @enderror
            </div>

            <div style="margin-bottom: 15px;">
                <label for="update_password_password" style="font-weight: 600; margin-bottom: 8px; display: block; color: #1b5e2f; margin-top: 0;">Password Baru</label>
                <input type="password" id="update_password_password" name="password" required autocomplete="new-password" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ccc; background: #fff; color: #333;">
                @error('password', 'updatePassword') <small style="color:red; display:block; margin-top:5px;">{{ $message }}</small> @enderror
            </div>

            <div style="margin-bottom: 15px;">
                <label for="update_password_password_confirmation" style="font-weight: 600; margin-bottom: 8px; display: block; color: #1b5e2f; margin-top: 0;">Konfirmasi Password Baru</label>
                <input type="password" id="update_password_password_confirmation" name="password_confirmation" required autocomplete="new-password" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ccc; background: #fff; color: #333;">
                @error('password_confirmation', 'updatePassword') <small style="color:red; display:block; margin-top:5px;">{{ $message }}</small> @enderror
            </div>

            <div style="display: flex; align-items: center; gap: 15px; margin-top: 25px;">
                <button type="submit" style="padding: 12px 30px; background: linear-gradient(135deg, #ff8c42, #e67e22); color: white; border: none; border-radius: 50px; cursor: pointer; font-weight: 600; font-size: 14px;">Perbarui Password</button>
                @if (session('status') === 'password-updated')
                    <span style="color: #2e7d32; font-size: 13.5px; font-weight: 500;"><i class="fas fa-check-circle"></i> Password berhasil diubah.</span>
                @endif
            </div>
        </form>
    </div>

    <!-- CARD 3: HAPUS AKUN -->
    <div class="form-section-card" style="background: #ffffff; padding: 30px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #e0e0e0; color: #333333;">
        <h3 style="color: #d32f2f; font-size: 18px; margin-top: 0; margin-bottom: 8px; font-weight: 700; border-bottom: 2px solid #ffebee; padding-bottom: 10px; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-exclamation-triangle"></i> Hapus Akun
        </h3>
        <p style="color: #666; font-size: 13.5px; margin-bottom: 20px;">Tindakan ini bersifat permanen. Setelah akun Anda dihapus, semua riwayat data penyewaan Anda akan dihapus secara permanen dari sistem kami.</p>
        
        <form method="post" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini? Semua data riwayat Anda akan hilang secara permanen!')" style="background: none; padding: 0; box-shadow: none; max-width: 100%; margin: 0;">
            @csrf
            @method('delete')

            <div style="margin-bottom: 15px; max-width: 400px;">
                <label for="password" style="font-weight: 600; margin-bottom: 8px; display: block; color: #d32f2f; margin-top: 0;">Masukkan Password Anda Untuk Konfirmasi</label>
                <input type="password" id="password" name="password" required placeholder="Password Anda" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #d32f2f; background: #fff; color: #333;">
                @error('password', 'userDeletion') <small style="color:red; display:block; margin-top:5px;">{{ $message }}</small> @enderror
            </div>

            <button type="submit" style="padding: 12px 30px; background: #e74c3c; color: white; border: none; border-radius: 50px; cursor: pointer; font-weight: 600; font-size: 14px; margin-top: 10px;">Hapus Akun Permanen</button>
        </form>
    </div>

</section>
@endsection
