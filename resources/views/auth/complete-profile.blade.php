<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lengkapi Profil - INNOFORUM</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #1f2937;
            color: #e5e7eb;
            line-height: 1.6;
            padding: 20px;
            min-height: 100vh;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 28px;
            font-weight: bold;
            color: #f9fafb;
            margin-bottom: 8px;
        }
        .header p {
            color: #d1d5db;
        }
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-weight: 500;
            margin-bottom: 8px;
            color: #374151;
        }
        input, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
            background: white;
            color: #374151;
        }
        input:focus, textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        input::placeholder, textarea::placeholder {
            color: #9ca3af;
        }
        .social-link {
            background: #f9fafb;
            padding: 15px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        .btn-primary {
            background: #2563eb;
            color: white;
            border: none;
            padding: 14px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            width: 100%;
            cursor: pointer;
            transition: background 0.3s;
            margin-bottom: 10px;
        }
        .btn-primary:hover {
            background: #1d4ed8;
        }
        .btn-skip {
            display: block;
            text-align: center;
            color: #6b7280;
            text-decoration: none;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            transition: all 0.3s;
            background: white;
        }
        .btn-skip:hover {
            color: #374151;
            border-color: #9ca3af;
            background: #f9fafb;
        }
        .error {
            color: #dc2626;
            font-size: 14px;
            margin-top: 5px;
        }
        .success {
            background: #dcfce7;
            border: 1px solid #bbf7d0;
            color: #166534;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .footer {
            text-align: center;
            color: #d1d5db;
            font-size: 14px;
        }

        /* Text dalam form tetap hitam */
        .form-container,
        .form-container *:not(.btn-skip) {
            color: #374151;
        }

        /* Judul section dalam form */
        .form-container h3 {
            color: #111827;
            margin-bottom: 15px;
            font-size: 18px;
            font-weight: 600;
        }

        /* Deskripsi dalam form */
        .form-container p {
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Lengkapi Profil Anda</h1>
            <p>Sempurnakan profil Anda untuk pengalaman yang lebih baik</p>
        </div>

        @if (session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form Container -->
        <div class="form-container">
            <form method="POST" action="{{ route('profile.complete.submit', $user->id) }}">
                @csrf

                @if ($user->role === 'mahasiswa')
                    <!-- Angkatan Input -->
                    <div class="form-group">
                        <label>Angkatan / Tahun Masuk</label>
                        <input type="text" name="angkatan"
                            value="{{ old('angkatan', $user->profile->angkatan ?? '') }}"
                            placeholder="Contoh: 2022">
                        @error('angkatan')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>
                @endif

                <!-- Bio Input -->
                <div class="form-group">
                    <label>Bio Singkat (opsional)</label>
                    <textarea name="bio" rows="4" placeholder="Ceritakan sedikit tentang dirimu...">{{ old('bio', $user->profile->bio ?? '') }}</textarea>
                    @error('bio')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Social Media Links -->
                <div class="form-group">
                    <h3>Media Sosial & Links</h3>
                    <p>Opsional - maksimal 3 link. Contoh: github.com/username atau @username</p>

                    @php
                        $existing = ($user->socialLinks ?? collect())->values();
                        for ($i = 0; $i < 3; $i++) {
                            $rows[$i] = $existing->get($i)
                                ? $existing->get($i)->toArray()
                                : ['url' => '', 'label' => '', 'order' => $i, 'visible' => true];
                        }
                    @endphp

                    @for ($i = 0; $i < 3; $i++)
                        @php $row = old("links.$i", $rows[$i]); @endphp
                        <div class="social-link">
                            <input type="text" name="links[{{ $i }}][url]" value="{{ $row['url'] ?? '' }}"
                                placeholder="URL atau username" style="margin-bottom: 10px;">
                            <input type="text" name="links[{{ $i }}][label]" value="{{ $row['label'] ?? '' }}"
                                placeholder="Label (opsional)">
                        </div>
                    @endfor

                    @error('links')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <button type="submit" class="btn-primary">
                    💾 Simpan Profil
                </button>

                <a href="{{ route('login') }}" class="btn-skip">
                    Lewati dulu
                </a>
            </form>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Anda dapat mengubah informasi ini nanti melalui pengaturan profil</p>
        </div>
    </div>
</body>
</html>
