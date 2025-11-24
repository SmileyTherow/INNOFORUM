@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-blue-900 to-gray-800 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl mb-6 shadow-lg">
                <span class="text-3xl text-white">📚</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                <span class="text-blue-400">Panduan Penggunaan INNOFORUM</span>
            </h1>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                Panduan lengkap untuk memaksimalkan pengalaman Anda dalam platform diskusi kampus kami.
            </p>
        </div>

        <!-- Guide Steps -->
        <div class="space-y-6">
            <!-- Step 1 -->
            <div class="group">
                <div class="bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-700 hover:shadow-md hover:border-blue-400 transition-all duration-300">
                    <div class="flex items-start gap-6">
                        <div style="width: 48px; height: 48px; background: #3b82f6; color: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 18px;">
                            1
                        </div>
                        <div class="flex-1">
                            <h2 class="text-xl font-semibold text-white mb-3 flex items-center gap-2">
                                Registrasi Akun
                                <span class="text-xs bg-blue-500/20 text-blue-300 px-2 py-1 rounded-full">Langkah Awal</span>
                            </h2>
                            <p class="text-gray-300 leading-relaxed">
                                Klik tombol <span class="bg-blue-500/20 text-blue-300 px-2 py-1 rounded-md font-medium">Daftar</span>
                                di pojok kanan atas, isi formulir pendaftaran dengan data yang valid,
                                dan lakukan verifikasi email jika diperlukan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="group">
                <div class="bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-700 hover:shadow-md hover:border-green-400 transition-all duration-300">
                    <div class="flex items-start gap-6">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-green-500 text-white rounded-xl flex items-center justify-center font-bold text-lg group-hover:scale-110 transition-transform duration-300">
                                2
                            </div>
                        </div>
                        <div class="flex-1">
                            <h2 class="text-xl font-semibold text-white mb-3 flex items-center gap-2">
                                Login ke Akun
                                <span class="text-xs bg-green-500/20 text-green-300 px-2 py-1 rounded-full">Akses Sistem</span>
                            </h2>
                            <p class="text-gray-300 leading-relaxed">
                                Masukkan <span class="text-green-300 font-medium">NIM/Email</span> dan
                                <span class="text-green-300 font-medium">Password</span> yang sudah Anda daftarkan
                                pada form login untuk mengakses platform.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="group">
                <div class="bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-700 hover:shadow-md hover:border-purple-400 transition-all duration-300">
                    <div class="flex items-start gap-6">
                        <div style="width: 48px; height: 48px; background: #8b5cf6; color: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 18px;">
                            3
                        </div>
                        <div class="flex-1">
                            <h2 class="text-xl font-semibold text-white mb-3 flex items-center gap-2">
                                Buat Diskusi Baru
                                <span class="text-xs bg-purple-500/20 text-purple-300 px-2 py-1 rounded-full">Memulai Topik</span>
                            </h2>
                            <p class="text-gray-300 leading-relaxed">
                                Klik tombol <span class="bg-purple-500/20 text-purple-300 px-2 py-1 rounded-md font-medium">Tanya</span>
                                di halaman utama, tulis judul dan konten yang jelas,
                                lalu pilih kategori yang sesuai sebelum submit.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 4 -->
            <div class="group">
                <div class="bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-700 hover:shadow-md hover:border-orange-400 transition-all duration-300">
                    <div class="flex items-start gap-6">
                        <div style="width: 48px; height: 48px; background: #f97316; color: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 18px;">
                            4
                        </div>
                        <div class="flex-1">
                            <h2 class="text-xl font-semibold text-white mb-3 flex items-center gap-2">
                                Menjawab/Menanggapi Diskusi
                                <span class="text-xs bg-orange-500/20 text-orange-300 px-2 py-1 rounded-full">Berpartisipasi</span>
                            </h2>
                            <p class="text-gray-300 leading-relaxed">
                                Pilih diskusi yang ingin Anda tanggapi, klik tombol
                                <span class="bg-orange-500/20 text-orange-300 px-2 py-1 rounded-md font-medium">Balas</span> atau
                                <span class="bg-orange-500/20 text-orange-300 px-2 py-1 rounded-md font-medium">Komentar</span>,
                                kemudian tulis tanggapan yang konstruktif dan relevan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 5 -->
            <div class="group">
                <div class="bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-700 hover:shadow-md hover:border-red-400 transition-all duration-300">
                    <div class="flex items-start gap-6">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-red-500 text-white rounded-xl flex items-center justify-center font-bold text-lg group-hover:scale-110 transition-transform duration-300">
                                5
                            </div>
                        </div>
                        <div class="flex-1">
                            <h2 class="text-xl font-semibold text-white mb-3 flex items-center gap-2">
                                Mengatur Profil
                                <span class="text-xs bg-red-500/20 text-red-300 px-2 py-1 rounded-full">Personalisasi</span>
                            </h2>
                            <p class="text-gray-300 leading-relaxed">
                                Klik nama Anda di pojok kanan atas > pilih
                                <span class="bg-red-500/20 text-red-300 px-2 py-1 rounded-md font-medium">Profil Saya</span>,
                                lalu Anda dapat mengubah foto profil, bio, informasi kontak, dan preferensi lainnya.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 6 -->
            <div class="group">
                <div class="bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-700 hover:shadow-md hover:border-indigo-400 transition-all duration-300">
                    <div class="flex items-start gap-6">
                        <div style="width: 48px; height: 48px; background: #6366f1; color: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 18px;">
                            6
                        </div>
                        <div class="flex-1">
                            <h2 class="text-xl font-semibold text-white mb-3 flex items-center gap-2">
                                Keamanan & Etika
                                <span class="text-xs bg-indigo-500/20 text-indigo-300 px-2 py-1 rounded-full">Kode Etik</span>
                            </h2>
                            <p class="text-gray-300 leading-relaxed">
                                Selalu jaga <span class="text-indigo-300 font-medium">sopan santun</span> dan
                                ikuti <a href="{{ route('terms') }}" class="text-indigo-400 hover:text-indigo-200 underline font-medium">Aturan Forum</a>.
                                Hormati perbedaan pendapat dan jaga kualitas diskusi akademik.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 7 -->
            <div class="group">
                <div class="bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-700 hover:shadow-md hover:border-teal-400 transition-all duration-300">
                    <div class="flex items-start gap-6">
                        <div style="width: 48px; height: 48px; background: #14b8a6; color: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 18px;">
                            7
                        </div>
                        <div class="flex-1">
                            <h2 class="text-xl font-semibold text-white mb-3 flex items-center gap-2">
                                Bantuan Lebih Lanjut
                                <span class="text-xs bg-teal-500/20 text-teal-300 px-2 py-1 rounded-full">Support</span>
                            </h2>
                            <p class="text-gray-300 leading-relaxed">
                                Jika membutuhkan bantuan teknis atau memiliki pertanyaan, hubungi admin melalui
                                <span class="text-teal-300 font-medium">fortech.forumteknologi@gmail.com</span> atau
                                kirim pesan langsung ke admin melalui fitur Contact us di forum.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="mt-16">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-blue-400 mb-3">❓ Tanya Jawab Cepat</h2>
                <p class="text-gray-300">Solusi instan untuk masalah yang sering muncul</p>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                @php
                    $faqItems = [
                        [
                            'icon' => '🔑',
                            'color' => 'red',
                            'question' => 'Lupa password?',
                            'answer' => 'Klik "Lupa Password" di halaman login. Instruksi reset akan dikirim ke email Anda dalam 5 menit.'
                        ],
                        [
                            'icon' => '🚨',
                            'color' => 'orange',
                            'question' => 'Laporkan konten melanggar?',
                            'answer' => 'Gunakan tombol "Lapor" di postingan tersebut. Tim moderator akan menindaklanjuti dalam 24 jam.'
                        ],
                        [
                            'icon' => '👥',
                            'color' => 'purple',
                            'question' => 'Siapa bisa bergabung?',
                            'answer' => 'Hanya mahasiswa, dosen, dan staff kampus terverifikasi. Data akademik dicek otomatis.'
                        ],
                        [
                            'icon' => '💬',
                            'color' => 'green',
                            'question' => 'Hapus diskusi?',
                            'answer' => 'Pemilik bisa hapus diskusi selama belum ada balasan. Sudah ada tanggapan? Hubungi admin.'
                        ]
                    ];
                @endphp

                @foreach($faqItems as $item)
                <div class="bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-700 hover:shadow-md hover:border-{{ $item['color'] }}-400 transition-all duration-300 group">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-{{ $item['color'] }}-500/20 rounded-xl flex items-center justify-center group-hover:bg-{{ $item['color'] }}-500 group-hover:scale-110 transition-all duration-300">
                            <span class="text-{{ $item['color'] }}-300 group-hover:text-white text-lg">{{ $item['icon'] }}</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-white mb-2">{{ $item['question'] }}</h3>
                            <p class="text-gray-300 text-sm leading-relaxed">{{ $item['answer'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Tips Menulis Section -->
        <div class="mt-16">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-blue-400 mb-3">🎨 Seni Menulis yang Berpengaruh</h2>
                <p class="text-gray-300">Tingkatkan engagement dengan teknik menulis yang tepat</p>
            </div>

            <div class="grid lg:grid-cols-2 gap-8">
                <!-- Do's -->
                <div class="bg-gray-800 rounded-2xl p-6 shadow-sm border border-green-500/30 hover:shadow-md hover:border-green-400 transition-all duration-300">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center">
                            <span class="text-white text-xl">✨</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Rahasia Sukses</h3>
                            <p class="text-green-300 text-sm">Tips menghasilkan konten berkualitas</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @php
                            $successTips = [
                                ['icon' => '🎯', 'tip' => 'Judul yang spesifik dan menarik perhatian'],
                                ['icon' => '📝', 'tip' => 'Gunakan paragraf pendek untuk keterbacaan'],
                                ['icon' => '🔍', 'tip' => 'Sertakan data dan referensi yang valid'],
                                ['icon' => '💡', 'tip' => 'Awali dengan pertanyaan provokatif'],
                                ['icon' => '📂', 'tip' => 'Pilih kategori yang paling relevan']
                            ];
                        @endphp

                        @foreach($successTips as $success)
                        <div class="flex items-center gap-3 p-3 bg-green-500/10 rounded-lg">
                            <span class="text-lg">{{ $success['icon'] }}</span>
                            <span class="text-gray-300 text-sm">{{ $success['tip'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Don'ts -->
                <div class="bg-gray-800 rounded-2xl p-6 shadow-sm border border-red-500/30 hover:shadow-md hover:border-red-400 transition-all duration-300">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center">
                            <span class="text-white text-xl">⚡</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Jebakan Umum</h3>
                            <p class="text-red-300 text-sm">Kesalahan yang sering dilakukan</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @php
                            $mistakeTips = [
                                ['icon' => '❌', 'tip' => 'Judul terlalu umum atau clickbait'],
                                ['icon' => '📏', 'tip' => 'Paragraf panjang tanpa jeda visual'],
                                ['icon' => '🔇', 'tip' => 'Tidak menyertakan sumber referensi'],
                                ['icon' => '📮', 'tip' => 'Posting di kategori yang salah'],
                                ['icon' => '⏰', 'tip' => 'Tidak merespons komentar dengan cepat']
                            ];
                        @endphp

                        @foreach($mistakeTips as $mistake)
                        <div class="flex items-center gap-3 p-3 bg-red-500/10 rounded-lg">
                            <span class="text-lg">{{ $mistake['icon'] }}</span>
                            <span class="text-gray-300 text-sm">{{ $mistake['tip'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Tips Section -->
        <div class="mt-12 bg-gray-800 rounded-2xl p-8 shadow-sm border border-gray-700">
            <div class="text-center mb-6">
                <div class="text-4xl mb-4">💡</div>
                <h2 class="text-2xl font-bold text-white mb-4">Tips & Trik Cerdas</h2>
            </div>
            <div class="grid md:grid-cols-2 gap-6">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                        <span class="text-blue-300">✓</span>
                    </div>
                    <p class="text-gray-300">Gunakan hashtag yang relevan untuk memudahkan pencarian</p>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                        <span class="text-blue-300">✓</span>
                    </div>
                    <p class="text-gray-300">Lampirkan gambar atau dokumen untuk penjelasan yang lebih jelas</p>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                        <span class="text-blue-300">✓</span>
                    </div>
                    <p class="text-gray-300">Beri like pada konten yang bermanfaat untuk apresiasi</p>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                        <span class="text-blue-300">✓</span>
                    </div>
                    <p class="text-gray-300">Gunakan fitur pencarian sebelum membuat diskusi baru</p>
                </div>
            </div>
        </div>

        <!-- Support Section -->
        <div class="mt-12 bg-gray-800 rounded-2xl p-8 shadow-sm border border-gray-700">
            <div class="text-center mb-6">
                <div class="text-4xl mb-4">🚀</div>
                <h2 class="text-2xl font-bold text-white mb-4">Butuh Bantuan Personal?</h2>
                <p class="text-gray-300 mb-6">Tim support kami siap membantu Anda 1-on-1</p>
            </div>

            <div class="space-y-4 max-w-md mx-auto">
                <div class="bg-blue-500/10 rounded-xl p-4">
                    <h3 class="font-semibold text-white mb-2">📧 Email Prioritas</h3>
                    <a href="mailto:fortech.forumteknologi@gmail.com" class="text-blue-400 hover:text-blue-300 font-medium text-lg">
                        fortech.forumteknologi@gmail.com
                    </a>
                </div>
            </div>

            <div class="mt-8 flex flex-col sm:flex-row gap-4 text-center">
                <a href="{{ route('dashboard') }}"
                    class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105">
                    🎯 Mulai Berdiskusi
                </a>
                <a href="mailto:fortech.forumteknologi@gmail.com"
                    class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105">
                    💬 Hubungi Sekarang
                </a>
            </div>
        </div>

        <!-- Footer Info -->
        <div class="text-center mt-8 text-sm text-gray-400">
            INNOFORUM Community •
            <span class="text-blue-400">Dukung kolaborasi akademik yang berkualitas</span>
        </div>
    </div>
</div>

<style>
/* MEMASTIKAN SELURUH HALAMAN TETAP GELAP MESKIPUN MODE LIGHT */
body {
    background-color: #111827 !important;
    color: #e5e7eb !important;
}

/* Override untuk semua elemen container */
.bg-white, .bg-gray-50, .bg-gray-100 {
    background-color: #1f2937 !important;
}

/* Memastikan text tetap terang */
.text-gray-800, .text-gray-900, .text-gray-700, .text-gray-600 {
    color: #e5e7eb !important;
}

/* Untuk card/container spesifik */
.bg-gray-800 {
    background-color: #1f2937 !important;
}

.bg-gray-900 {
    background-color: #111827 !important;
}

.border-gray-300, .border-gray-200 {
    border-color: #374151 !important;
}

/* Shadow override */
.shadow-sm, .shadow-md, .shadow-lg {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 2px 4px -1px rgba(0, 0, 0, 0.2) !important;
}

/* Untuk memastikan layout app tetap gelap */
.min-h-screen {
    background-color: #111827 !important;
}

/* Background gradient untuk halaman ini */
.bg-gradient-to-br.from-gray-900.via-blue-900.to-gray-800 {
    background-image: linear-gradient(to bottom right, #111827, #1e3a8a, #111827) !important;
}

/* Override khusus untuk mode light */
@media (prefers-color-scheme: light) {
    body {
        background-color: #111827 !important;
        color: #e5e7eb !important;
    }

    .bg-white {
        background-color: #1f2937 !important;
    }

    .text-gray-900, .text-gray-800, .text-gray-700 {
        color: #e5e7eb !important;
    }

    .border-gray-200 {
        border-color: #374151 !important;
    }
}
</style>
@endsection
