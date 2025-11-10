<!-- Tombol buka form kontak -->
<div class="contact-support">
    <h3><span>📞</span> Butuh Bantuan Lebih Lanjut?</h3>
    <p>Hubungi tim support kami di: <a href="mailto:fortech.forumteknologi@gmail.com">fortech.forumteknologi@gmail.com</a></p>
    <p>atau kirim pesan langsung ke admin melalui form berikut:</p>
    <div style="margin-top:15px;">
        <button class="contact-btn-primary" onclick="openContactModal()">
            <span>📩</span> Kirim Pesan ke Admin
        </button>
    </div>
</div>

<!-- Modal Contact -->
<div id="contactModal" class="help-modal" style="display:none;">
    <div class="modal-content" role="dialog" aria-modal="true" style="max-width: 600px;">
        <div class="modal-header">
            <h3 class="modal-title">
                <span>📩</span> Kirim Pesan ke Admin
            </h3>
            <button class="close-modal" onclick="closeContactModal()">&times;</button>
        </div>

        {{-- Tampilkan feedback sukses/gagal --}}
        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('guest.message.send') }}">
            @csrf
            <div class="help-content">
                <div class="form-section">
                    <label>Nama <span style="color:#ef4444">*</span></label>
                    <input type="text" name="name" required value="{{ old('name') }}" class="contact-form-control" placeholder="Masukkan nama lengkap Anda">
                </div>

                <div class="form-section">
                    <label>Email <span style="color:#ef4444">*</span></label>
                    <input type="email" name="email" required value="{{ old('email') }}" class="contact-form-control" placeholder="Masukkan alamat email aktif">
                </div>

                <div class="form-section">
                    <label>Topik <span style="color:#ef4444">*</span></label>
                    <select name="context" required class="contact-form-select">
                        <option value="" disabled selected>Pilih topik pesan</option>
                        <option value="verify-nim" {{ old('context') == 'verify-nim' ? 'selected' : '' }}>Verifikasi NIM / NIDN</option>
                        <option value="register-help" {{ old('context') == 'register-help' ? 'selected' : '' }}>Registrasi / Pendaftaran</option>
                        <option value="login-help" {{ old('context') == 'login-help' ? 'selected' : '' }}>Masalah Login (Lupa email/password)</option>
                        <option value="other" {{ old('context') == 'other' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <div class="form-section">
                    <label>Referensi (opsional)</label>
                    <input type="text" name="reference" placeholder="Isi NIM/NIDN atau detail lain jika relevan"
                        value="{{ old('reference') }}" class="contact-form-control">
                </div>

                <div class="form-section">
                    <label>Pesan <span style="color:#ef4444">*</span></label>
                    <textarea name="message" rows="5" required class="contact-form-control contact-textarea" placeholder="Jelaskan masalah atau pertanyaan Anda secara detail">{{ old('message') }}</textarea>
                </div>

                <div class="contact-form-actions">
                    <button type="button" class="contact-btn-secondary" onclick="closeContactModal()">Batal</button>
                    <button type="submit" class="contact-btn-primary">
                        <span>📤</span> Kirim Pesan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    /* CSS khusus untuk form kontak untuk menghindari konflik */
    .contact-btn-primary {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 10px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .contact-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.6);
        background: linear-gradient(135deg, #1d4ed8, #1e40af);
    }

    .contact-btn-secondary {
        background: #f3f4f6;
        color: #374151;
        border: 1px solid #d1d5db;
        padding: 12px 24px;
        border-radius: 10px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .contact-btn-secondary:hover {
        background: #e5e7eb;
    }

    .contact-form-control, .contact-form-select {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.3s ease;
        background-color: white;
        box-sizing: border-box;
        font-family: inherit;
    }

    .contact-form-control:focus, .contact-form-select:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .contact-form-control::placeholder {
        color: #9ca3af;
    }

    .contact-textarea {
        resize: vertical;
        min-height: 120px;
    }

    .contact-form-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 16px;
        padding-right: 40px;
    }

    .form-section {
        margin-bottom: 20px;
    }

    .form-section label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #374151;
        font-size: 14px;
    }

    .contact-form-actions {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 20px;
    }

    .alert-success {
        background: #ecfdf5;
        border-left: 4px solid #10b981;
        padding: 12px 15px;
        border-radius: 6px;
        margin-bottom: 20px;
        color: #065f46;
    }

    .alert-error {
        background: #fff5f5;
        border-left: 4px solid #f43f5e;
        padding: 12px 15px;
        border-radius: 6px;
        margin-bottom: 20px;
        color: #7f1d1d;
    }

    .contact-support {
        background: #f0f9ff;
        padding: 15px;
        border-radius: 10px;
        margin-top: 20px;
        border-left: 4px solid #3b82f6;
    }

    .contact-support h3 {
        color: #1f2937;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .contact-support p {
        margin: 8px 0;
        color: #4b5563;
    }

    .contact-support a {
        color: #3b82f6;
        text-decoration: none;
        font-weight: 600;
    }

    .contact-support a:hover {
        text-decoration: underline;
    }
</style>

<script>
    function openContactModal() {
        document.getElementById('contactModal').style.display = 'block';
    }

    function closeContactModal() {
        document.getElementById('contactModal').style.display = 'none';
    }

    // Tutup modal ketika klik di luar konten
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('contactModal');
        if (event.target === modal) {
            closeContactModal();
        }
    });

    // Tutup modal dengan tombol ESC
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeContactModal();
        }
    });
</script>
