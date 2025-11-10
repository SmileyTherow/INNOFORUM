@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 mt-10 text-gray-200">
    <h1 class="text-3xl font-extrabold text-center mb-3">
        <span class="text-blue-400">📜 Aturan Penggunaan INNOFORUM</span>
    </h1>
    <p class="text-center text-gray-400 mb-10">
        Selamat datang di <strong>INNOFORUM</strong> — ruang diskusi kampus tempat mahasiswa, dosen, dan alumni berkolaborasi serta berbagi ide.
        Demi menciptakan suasana diskusi yang positif, aman, dan nyaman untuk semua, silakan baca dan pahami aturan berikut sebelum berpartisipasi.
    </p>
    <p class="text-center text-gray-400 mb-10">
        Panduan untuk menciptakan lingkungan diskusi yang <span class="text-blue-300">positif, aman, dan produktif</span>
        bagi seluruh civitas akademika
    </p>

    <!-- Progress Indicator -->
    <div class="flex justify-center mb-8">
        <div class="flex items-center space-x-2 text-sm text-gray-400">
            <div class="flex items-center">
                <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                <span class="ml-2">Baca dengan seksama</span>
            </div>
            <span>•</span>
            <div class="flex items-center">
                <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse animation-delay-1000"></div>
                <span class="ml-2">Pahami ketentuan</span>
            </div>
            <span>•</span>
            <div class="flex items-center">
                <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse animation-delay-2000"></div>
                <span class="ml-2">Terapkan dengan baik</span>
            </div>
        </div>
    </div>

    {{-- Etika Berdiskusi --}}
    <div class="bg-gray-800 p-6 rounded-2xl shadow-lg mb-6 border border-gray-700">
        <h2 class="text-xl font-bold text-blue-400 mb-3 flex items-center gap-2">
            💬 Etika Berdiskusi
            <span class="text-sm bg-blue-500/20 px-2 py-1 rounded-full text-blue-300">Wajib</span>
        </h2>
        <ul class="list-disc ml-6 space-y-1 text-gray-300">
            <li>Gunakan bahasa yang sopan dan mudah dimengerti oleh semua pihak.</li>
            <li>Hargai pendapat orang lain meskipun berbeda pandangan.</li>
            <li>Hindari topik yang menyinggung <strong>SARA</strong>, politik ekstrem, atau ujaran kebencian.</li>
            <li>Fokus pada diskusi yang membangun dan berbasis pengetahuan.</li>
        </ul>
    </div>

    {{-- Larangan --}}
    <div class="bg-gray-800 p-6 rounded-2xl shadow-lg mb-6 border border-gray-700">
        <h2 class="text-xl font-semibold mb-3 text-blue-400">🚫 Larangan</h2>
        <ul class="list-disc ml-6 space-y-1 text-gray-300">
            <li>Spam, promosi, atau iklan tanpa izin dari admin forum.</li>
            <li>Penyebaran informasi palsu (<em>hoaks</em>) atau berita tanpa sumber valid.</li>
            <li>Mengunggah konten berhak cipta tanpa izin pemilik aslinya.</li>
            <li>Membagikan tautan berbahaya seperti <em>phishing</em> atau <em>malware</em>.</li>
        </ul>
    </div>

    {{-- Hak & Tanggung Jawab --}}
    <div class="bg-gray-800 p-6 rounded-2xl shadow-lg mb-6 border border-gray-700">
        <h2 class="text-xl font-semibold mb-3 text-blue-400">🧩 Hak & Tanggung Jawab Pengguna</h2>
        <ul class="list-disc ml-6 space-y-1 text-gray-300">
            <li>Setiap pengguna bertanggung jawab atas isi posting dan komentar yang dibuat.</li>
            <li>Admin berhak menghapus, memblokir, atau menonaktifkan akun yang melanggar aturan.</li>
            <li>Forum tidak bertanggung jawab atas kesalahan informasi dari pengguna lain.</li>
        </ul>
    </div>

    {{-- Keamanan Akun --}}
    <div class="bg-gray-800 p-6 rounded-2xl shadow-lg mb-6 border border-gray-700">
        <h2 class="text-xl font-semibold mb-3 text-blue-400">🔐 Keamanan Akun</h2>
        <ul class="list-disc ml-6 space-y-1 text-gray-300">
            <li>Gunakan kata sandi yang kuat dan rahasiakan kredensial Anda.</li>
            <li>Jangan pernah membagikan informasi login kepada pihak lain.</li>
            <li>Jika akun Anda disalahgunakan, segera laporkan ke admin.</li>
        </ul>
    </div>

    {{-- Ketentuan Tambahan --}}
    <div class="bg-gray-800 p-6 rounded-2xl shadow-lg mb-8 border border-gray-700">
        <h2 class="text-xl font-semibold mb-3 text-blue-400">📘 Ketentuan Tambahan</h2>
        <ul class="list-disc ml-6 space-y-1 text-gray-300">
            <li>Aturan dapat diperbarui sewaktu-waktu tanpa pemberitahuan terlebih dahulu.</li>
            <li>Dengan menggunakan forum ini, pengguna dianggap telah membaca dan menyetujui seluruh ketentuan.</li>
            <li>Forum ini menjunjung nilai integritas, kolaborasi, dan inovasi akademik.</li>
        </ul>
    </div>

    <div class="bg-gray-800 border border-blue-700 text-center p-4 rounded-xl text-sm text-gray-300">
        💡 <em>"Diskusi yang baik dimulai dari rasa hormat dan niat untuk saling memahami."</em>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mt-8">
        <a href="{{ route('dashboard') }}"
            class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-500 hover:to-blue-600 text-white px-8 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg shadow-blue-500/25">
            👍 Saya Setuju & Memahami
        </a>
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
.text-gray-800, .text-gray-900, .text-gray-700 {
    color: #e5e7eb !important;
}

/* Untuk card/container spesifik */
.bg-gray-800 {
    background-color: #1f2937 !important;
}

.border-gray-300, .border-gray-200 {
    border-color: #374151 !important;
}

/* Progress indicator */
.text-gray-500, .text-gray-600 {
    color: #9ca3af !important;
}

/* Shadow override */
.shadow-sm, .shadow-md, .shadow-lg {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 2px 4px -1px rgba(0, 0, 0, 0.2) !important;
}

/* Untuk memastikan layout app tetap gelap */
.min-h-screen {
    background-color: #111827 !important;
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

    .text-gray-900 {
        color: #e5e7eb !important;
    }

    .border-gray-200 {
        border-color: #374151 !important;
    }
}
</style>
@endsection
