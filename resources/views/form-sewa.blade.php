@extends('layouts.app')

@section('title', 'Form Penyewaan Alat - SummitBuddy')

@section('hero')
<header class="hero-small">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1>Form Penyewaan Alat</h1>
        <p>Centang alat yang ingin disewa dan isi kuantitasnya</p>
    </div>
</header>
@endsection

@section('content')
<section style="max-width: 800px; margin: 0 auto;">
    <form action="{{ route('form-sewa.store') }}" method="POST" id="formSewaPelanggan" enctype="multipart/form-data" style="max-width: 100%; background: none; padding: 0; box-shadow: none; margin: 0;">
        @csrf

        <div class="form-card-container" style="display: flex; flex-direction: column; gap: 20px;">
            
            <!-- CARD 1: IDENTITAS PENYEWA -->
            <div class="form-section-card" style="background: #ffffff; padding: 25px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #e0e0e0; color: #333333;">
                <h3 style="color: #1b5e2f; font-size: 18px; margin-top: 0; margin-bottom: 8px; font-weight: 700; border-bottom: 2px solid #e8f5e9; padding-bottom: 10px; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-user-circle"></i> Identitas Penyewa <span style="color: #d32f2f; font-size: 14px; font-weight: bold; margin-left: 5px;">*</span>
                </h3>
                <p style="color: #666; font-size: 13.5px; margin-bottom: 20px; line-height: 1.5;">Masukkan data nama lengkap dan nomor handphone Anda yang aktif.</p>
                <div style="display: grid; grid-template-columns: 1fr; gap: 15px;">
                    <div>
                        <label for="nama" style="font-weight: 600; margin-bottom: 8px; display: block; color: #1b5e2f; margin-top: 0;">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" value="{{ old('nama', auth()->user()->name) }}" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ccc; background: #fff; color: #333;" required>
                        @error('nama') <small style="color:red">{{ $message }}</small> @enderror
                    </div>
                    <div>
                        <label for="no_hp" style="font-weight: 600; margin-bottom: 8px; display: block; color: #1b5e2f; margin-top: 10px;">Nomor HP / WhatsApp</label>
                        <input type="tel" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" placeholder="Contoh: 081234567890" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ccc; background: #fff; color: #333;" required>
                        @error('no_hp') <small style="color:red">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <!-- CARD 2: PILIH ALAT PENDAKIAN -->
            <div class="form-section-card" style="background: #ffffff; padding: 25px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #e0e0e0; color: #333333;">
                <h3 style="color: #1b5e2f; font-size: 18px; margin-top: 0; margin-bottom: 8px; font-weight: 700; border-bottom: 2px solid #e8f5e9; padding-bottom: 10px; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-hiking"></i> Alat Pendakian <span style="color: #d32f2f; font-size: 14px; font-weight: bold; margin-left: 5px;">*</span>
                </h3>
                <p style="color: #666; font-size: 13.5px; margin-bottom: 20px; line-height: 1.5;">Pilih alat-alat pendakian yang ingin Anda sewa dan tentukan jumlahnya.</p>
                <div class="alat-selection-container" style="display: flex; flex-direction: column; gap: 12px;">
                    @foreach($daftarAlat as $alat)
                    <div class="alat-row" style="display: flex; align-items: center; justify-content: space-between; background: #fdfdfd; padding: 15px 20px; border-radius: 12px; border: 2px solid #eee; transition: all 0.3s ease; color: #333;">
                        <label style="display: flex; align-items: center; gap: 12px; margin: 0; cursor: pointer; font-weight: normal; flex-grow: 1; color: #333;">
                            <input type="checkbox" name="alats[{{ $alat['id'] }}][selected]" value="1" class="alat-cb" data-id="{{ $alat['id'] }}" style="width: 20px; height: 20px; accent-color: #1b5e2f; margin: 0; cursor: pointer;">
                            <span style="font-size: 15px; display: inline-block;">
                                <strong>{{ $alat['nama'] }}</strong> - <span style="color: #ff8c42; font-weight: 600;">Rp {{ number_format($alat['harga'], 0, ',', '.') }}/hari</span> 
                                <small style="color: #777; margin-left: 5px;">(Stok: {{ $alat['stok'] }})</small>
                            </span>
                        </label>
                        <div class="qty-container" style="display: flex; align-items: center; gap: 8px; opacity: 0.3; pointer-events: none; transition: all 0.3s ease;">
                            <span style="font-size: 14px; color: #666;">Jumlah:</span>
                            <input type="number" name="alats[{{ $alat['id'] }}][jumlah]" value="1" min="1" max="{{ $alat['stok'] }}" class="qty-input" style="width: 80px; padding: 8px 10px; border-radius: 8px; border: 2px solid #e8e8e8; margin: 0; background: #eee; color: #333;" disabled>
                        </div>
                    </div>
                    @endforeach
                </div>
                @error('alats') <small style="color:red; display:block; margin-top:10px;">{{ $message }}</small> @enderror
            </div>

            <!-- CARD 3: DURASI SEWA -->
            <div class="form-section-card" style="background: #ffffff; padding: 25px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #e0e0e0; color: #333333;">
                <h3 style="color: #1b5e2f; font-size: 18px; margin-top: 0; margin-bottom: 8px; font-weight: 700; border-bottom: 2px solid #e8f5e9; padding-bottom: 10px; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-calendar-alt"></i> Durasi Sewa <span style="color: #d32f2f; font-size: 14px; font-weight: bold; margin-left: 5px;">*</span>
                </h3>
                <p style="color: #666; font-size: 13.5px; margin-bottom: 20px; line-height: 1.5;">Pilih tanggal pengambilan alat dan tanggal pengembalian alat.</p>
                <div class="date-grid">
                    <div>
                        <label for="tgl_sewa" style="font-weight: 600; margin-bottom: 8px; display: block; color: #1b5e2f; margin-top: 0;">Tanggal Pengambilan</label>
                        <input type="date" id="tgl_sewa" name="tgl_sewa" value="{{ old('tgl_sewa', date('Y-m-d')) }}" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ccc; background: #fff; color: #333;" required>
                        @error('tgl_sewa') <small style="color:red">{{ $message }}</small> @enderror
                    </div>
                    <div>
                        <label for="tgl_kembali" style="font-weight: 600; margin-bottom: 8px; display: block; color: #1b5e2f; margin-top: 0;">Tanggal Pengembalian</label>
                        <input type="date" id="tgl_kembali" name="tgl_kembali" value="{{ old('tgl_kembali') }}" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ccc; background: #fff; color: #333;" required>
                        @error('tgl_kembali') <small style="color:red">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <!-- CARD 4: METODE PEMBAYARAN -->
            <div class="form-section-card" style="background: #ffffff; padding: 25px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #e0e0e0; color: #333333;">
                <h3 style="color: #1b5e2f; font-size: 18px; margin-top: 0; margin-bottom: 8px; font-weight: 700; border-bottom: 2px solid #e8f5e9; padding-bottom: 10px; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-wallet"></i> Metode Pembayaran <span style="color: #d32f2f; font-size: 14px; font-weight: bold; margin-left: 5px;">*</span>
                </h3>
                <p style="color: #666; font-size: 13.5px; margin-bottom: 20px; line-height: 1.5;">Pilih metode pembayaran transfer bank atau bayar tunai (COD) saat pengambilan barang.</p>
                <select id="metode_pembayaran" name="metode_pembayaran" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ccc; background: #fff; color: #333;" required>
                    <option value="Transfer">Transfer Bank (BCA / Mandiri)</option>
                    <option value="Tunai">Bayar Tunai saat Pengambilan (COD)</option>
                </select>
                @error('metode_pembayaran') <small style="color:red">{{ $message }}</small> @enderror
            </div>

            <!-- CARD 5: BUKTI PEMBAYARAN -->
            <div id="bukti_pembayaran_section" class="form-section-card" style="background: #ffffff; padding: 25px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #e0e0e0; color: #333333;">
                <h3 style="color: #1b5e2f; font-size: 18px; margin-top: 0; margin-bottom: 8px; font-weight: 700; border-bottom: 2px solid #e8f5e9; padding-bottom: 10px; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-receipt"></i> Bukti Pembayaran <span style="color: #757575; font-size: 13px; font-weight: normal; margin-left: 5px;">(opsional)</span>
                </h3>
                
                <!-- Info Rekening Bank -->
                <div class="bank-accounts-info" style="background: #f1f8f3; padding: 15px; border-radius: 12px; border: 1px solid #c3e6cb; margin-bottom: 20px;">
                    <strong style="color: #1b5e2f; display: block; margin-bottom: 8px;"><i class="fas fa-university"></i> Rekening Pembayaran Transfer:</strong>
                    <ul style="list-style-type: none; padding-left: 0; margin: 0; font-size: 14px; color: #333;">
                        <li style="margin-bottom: 5px;">🏦 <strong>BCA:</strong> 123-456-7890 (a/n SummitBuddy Store)</li>
                        <li>🏦 <strong>Mandiri:</strong> 098-765-4321 (a/n SummitBuddy Store)</li>
                    </ul>
                </div>

                <p style="color: #666; font-size: 13.5px; margin-bottom: 20px; line-height: 1.5;">Unggah gambar bukti transfer pembayaran Anda untuk mempercepat verifikasi pengambilan barang.</p>
                <div style="border: 2px dashed #43a047; padding: 25px; border-radius: 12px; text-align: center; background: #f9fbf9; margin-top: 10px;">
                    <i class="fas fa-cloud-upload-alt" style="font-size: 36px; color: #43a047; margin-bottom: 12px;"></i>
                    <p style="font-size: 14px; margin-bottom: 15px; color: #333; font-weight: 500;">Pilih gambar bukti transfer pembayaran Anda (BCA / Mandiri / GoPay)</p>
                    <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" accept="image/*" style="display: none;" onchange="previewPaymentImage(this)">
                    <button type="button" onclick="document.getElementById('bukti_pembayaran').click()" style="background: #1b5e2f; color: #fff; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;"><i class="fas fa-file-image"></i> Pilih File Gambar</button>
                    <div id="payment-preview-container" style="display: none; margin-top: 15px;">
                        <img id="payment-preview" src="#" alt="Preview Bukti Pembayaran" style="max-height: 200px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); display: inline-block;">
                        <p style="font-size: 12px; color: #666; margin-top: 5px;" id="payment-filename"></p>
                    </div>
                </div>
                @error('bukti_pembayaran') <small style="color:red">{{ $message }}</small> @enderror
            </div>

            <!-- CARD 5.2: PETUNJUK COD (HIDDEN BY DEFAULT) -->
            <div id="cod_instruction_section" class="form-section-card" style="display: none; background: #ffffff; padding: 25px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #e0e0e0; color: #333333;">
                <h3 style="color: #1b5e2f; font-size: 18px; margin-top: 0; margin-bottom: 8px; font-weight: 700; border-bottom: 2px solid #e8f5e9; padding-bottom: 10px; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-hand-holding-usd"></i> Pembayaran Tunai (COD)
                </h3>
                <p style="color: #666; font-size: 13.5px; margin-bottom: 0; line-height: 1.5;">Anda memilih untuk melakukan pembayaran tunai. Pembayaran akan diproses secara langsung oleh kasir di store SummitBuddy saat Anda mengambil barang sewaan di toko.</p>
            </div>

            <!-- CARD 6: KETERANGAN TAMBAHAN -->
            <div class="form-section-card" style="background: #ffffff; padding: 25px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #e0e0e0; color: #333333;">
                <h3 style="color: #1b5e2f; font-size: 18px; margin-top: 0; margin-bottom: 8px; font-weight: 700; border-bottom: 2px solid #e8f5e9; padding-bottom: 10px; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-edit"></i> Keterangan Tambahan <span style="color: #757575; font-size: 13px; font-weight: normal; margin-left: 5px;">(opsional)</span>
                </h3>
                <p style="color: #666; font-size: 13.5px; margin-bottom: 20px; line-height: 1.5;">Tuliskan keterangan tambahan jika ada (misal: ukuran sepatu, request warna tenda, dll).</p>
                <textarea id="keterangan" name="keterangan" rows="3" placeholder="Tuliskan catatan khusus untuk pengambilan atau kondisi barang jika ada..." style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ccc; background: #fff; color: #333;">{{ old('keterangan') }}</textarea>
                @error('keterangan') <small style="color:red">{{ $message }}</small> @enderror
            </div>

        </div>

        <button type="submit" id="btnSubmit" style="width: 100%; padding: 15px 30px; background: linear-gradient(135deg, #ff8c42, #e67e22); color: white; border: none; border-radius: 50px; cursor: pointer; font-size: 16px; font-weight: 600; transition: all 0.3s ease; margin-top: 25px; box-shadow: 0 5px 15px rgba(255, 140, 66, 0.3); display: flex; align-items: center; justify-content: center; gap: 10px;">
            <i class="fas fa-calendar-check"></i> Kirim Form Sewa
        </button>
    </form>

    <div class="form-hint" style="margin-top: 30px; text-align: center; font-size: 14px;">
        * Harga dihitung berdasarkan total harga sewa per hari untuk semua barang × lama sewa.
    </div>
</section>

<!-- Custom Styling for Checklist Rows in Light/Dark Theme -->
<style>
.dark .alat-row {
    background: #fafafa !important;
    border-color: #eee !important;
    color: #333 !important;
}
.dark .alat-row label {
    color: #333 !important;
}
.dark .alat-row .qty-container span {
    color: #666 !important;
}
.dark .alat-row .qty-input {
    background: #eee !important;
    border-color: #e8e8e8 !important;
    color: #333 !important;
}
</style>

@push('scripts')
<script>
    function previewPaymentImage(input) {
        const previewContainer = document.getElementById('payment-preview-container');
        const previewImage = document.getElementById('payment-preview');
        const filenameLabel = document.getElementById('payment-filename');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.style.display = 'block';
                filenameLabel.textContent = input.files[0].name;
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            previewContainer.style.display = 'none';
            previewImage.src = '#';
            filenameLabel.textContent = '';
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const checkboxes = document.querySelectorAll('.alat-cb');
        
        checkboxes.forEach(cb => {
            cb.addEventListener('change', (e) => {
                const row = e.target.closest('.alat-row');
                const qtyDiv = row.querySelector('.qty-container');
                const qtyInput = qtyDiv.querySelector('input');
                
                if (e.target.checked) {
                    row.style.borderColor = '#43a047';
                    row.style.background = 'rgba(67, 160, 71, 0.05)';
                    qtyDiv.style.opacity = '1';
                    qtyDiv.style.pointerEvents = 'auto';
                    qtyInput.disabled = false;
                    qtyInput.style.background = '#ffffff';
                } else {
                    row.style.borderColor = '#eee';
                    row.style.background = '#fdfdfd';
                    qtyDiv.style.opacity = '0.3';
                    qtyDiv.style.pointerEvents = 'none';
                    qtyInput.disabled = true;
                    qtyInput.value = '1';
                    qtyInput.style.background = '#eee';
                }
            });
        });

        // Form submission safety check: make sure at least one checkbox is selected
        const form = document.getElementById('formSewaPelanggan');
        if (form) {
            form.addEventListener('submit', (e) => {
                const checkedCount = document.querySelectorAll('.alat-cb:checked').length;
                if (checkedCount === 0) {
                    e.preventDefault();
                    showToast('error', 'Gagal', 'Silakan centang minimal satu alat untuk disewa!');
                }
            });
        }

        // Toggle Payment Fields
        const metodePembayaranSelect = document.getElementById('metode_pembayaran');
        const buktiPembayaranSection = document.getElementById('bukti_pembayaran_section');
        const codInstructionSection = document.getElementById('cod_instruction_section');

        function togglePaymentFields() {
            if (metodePembayaranSelect && buktiPembayaranSection && codInstructionSection) {
                if (metodePembayaranSelect.value === 'Transfer') {
                    buktiPembayaranSection.style.display = 'block';
                    codInstructionSection.style.display = 'none';
                } else {
                    buktiPembayaranSection.style.display = 'none';
                    codInstructionSection.style.display = 'block';
                }
            }
        }

        if (metodePembayaranSelect) {
            metodePembayaranSelect.addEventListener('change', togglePaymentFields);
            togglePaymentFields(); // Initial call
        }
    });
</script>
@endpush
@endsection
