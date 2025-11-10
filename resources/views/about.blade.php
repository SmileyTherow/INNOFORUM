@extends('layouts.app')

@section('content')
<div class="bg-gray-900 text-white min-h-screen overflow-hidden">

    {{-- Hero Section --}}
    <section class="relative text-center py-20 bg-gradient-to-br from-gray-900 via-blue-900 to-gray-800 animate-gradient">
        <div class="max-w-3xl mx-auto px-4">
            <h1 class="text-5xl font-extrabold mb-6 tracking-tight">
                Tentang <span class="text-blue-400">INNOFORUM</span>
            </h1>
            <p class="text-gray-300 text-lg leading-relaxed">
                INNOFORUM adalah platform diskusi digital kampus STTI NIIT I-TECH yang dirancang sebagai wadah kolaborasi,
                berbagi pengetahuan, dan berdiskusi secara intelektual antara mahasiswa, dosen, serta alumni.
            </p>
        </div>
    </section>

    <div class="h-1 bg-gradient-to-r from-blue-500 via-cyan-400 to-blue-500 rounded-full my-10"></div>

    {{-- Visi & Misi --}}
    <section class="max-w-5xl mx-auto px-6 py-10 bg-gray-800 rounded-2xl shadow-lg transition transform hover:scale-[1.01]" data-aos="fade-up">
        <h2 class="text-2xl font-bold mb-4">🎯 Visi & Misi</h2>
        <p class="text-gray-300 mb-2"><strong>Visi:</strong> Menjadi pusat diskusi digital yang terbuka, cerdas, dan inspiratif bagi seluruh civitas akademika.</p>
        <p class="text-gray-300 mb-4"><strong>Misi:</strong></p>
        <ul class="list-disc ml-6 text-gray-400 space-y-1">
            <li>Menjadi ruang aman dan inklusif untuk berdiskusi secara bermartabat.</li>
            <li>Mendorong lahirnya ide-ide segar melalui diskusi berbasis data dan logika.</li>
            <li>Menumbuhkan budaya berpikir kritis dan toleransi terhadap perbedaan.</li>
            <li>Memfasilitasi kolaborasi lintas jurusan dan minat akademik.</li>
        </ul>
    </section>

    <div class="h-1 bg-gradient-to-r from-cyan-400 via-blue-500 to-cyan-400 rounded-full my-10"></div>

    {{-- Tujuan & Latar Belakang --}}
    <section class="max-w-5xl mx-auto px-6 py-10 bg-gray-800 rounded-2xl shadow-lg transition transform hover:scale-[1.01]" data-aos="fade-up">
        <h2 class="text-2xl font-bold mb-4">💡 Tujuan & Latar Belakang</h2>
        <p class="text-gray-300 leading-relaxed">
            INNOFORUM hadir untuk menjawab kebutuhan ruang diskusi digital yang sehat dan produktif di lingkungan kampus.
            Dengan semangat keterbukaan, forum ini menjadi tempat bagi civitas akademika untuk saling berbagi pandangan,
            mengasah kemampuan berpikir kritis, dan menumbuhkan jejaring kolaboratif antar generasi akademisi.
        </p>
    </section>

    <div class="h-1 bg-gradient-to-r from-blue-500 via-indigo-500 to-blue-500 rounded-full my-10"></div>

    {{-- Nilai & Prinsip --}}
    <section class="max-w-5xl mx-auto px-6 py-10 bg-gray-800 rounded-2xl shadow-lg transition transform hover:scale-[1.01]" data-aos="fade-up">
        <h2 class="text-2xl font-bold mb-4">🧭 Nilai & Prinsip Pengembangan</h2>
        <ul class="list-disc ml-6 text-gray-400 space-y-2">
            <li>💬 Keterbukaan dalam berbagi ide dan pendapat.</li>
            <li>🤝 Kolaborasi lintas jurusan sebagai kekuatan utama.</li>
            <li>💡 Inovasi berkelanjutan untuk kemajuan kampus.</li>
            <li>🔒 Keamanan dan kenyamanan pengguna sebagai prioritas.</li>
        </ul>
    </section>

    <div class="h-1 bg-gradient-to-r from-cyan-400 via-blue-500 to-cyan-400 rounded-full my-10"></div>

    {{-- Pengembang --}}
    <section class="max-w-5xl mx-auto px-6 py-10 bg-gray-800 rounded-2xl shadow-lg transition transform hover:scale-[1.01]" data-aos="fade-up">
        <h2 class="text-2xl font-bold mb-4">👨‍💻 Pengembang</h2>
        <ul class="text-gray-300 space-y-2">
            <li><strong>Dikembangkan oleh:</strong></li>
            <ul class="ml-6 text-gray-400">
                <li>- Ahmad Zidan Tamimy</li>
                <li>- Agni Fatya Kholila</li>
            </ul>
            <li><strong>Dosen Pembimbing:</strong></li>
            <ul class="ml-6 text-gray-400">
                <li>- Anjeng Puspita Ningrum, S.Kom</li>
                <li>- Desi Sihamita, S.Kom</li>
            </ul>
            <li><strong>Teknologi:</strong> HTML, CSS, PHP, MySQL, JavaScript, Laravel, Tailwind CSS</li>
        </ul>
    </section>

    <div class="h-1 bg-gradient-to-r from-blue-500 via-cyan-400 to-blue-500 rounded-full my-10"></div>

    {{-- Tools & Teknologi --}}
    <section class="max-w-5xl mx-auto px-6 py-10 bg-gray-800 rounded-2xl shadow-lg transition transform hover:scale-[1.01]" data-aos="fade-up">
        <h2 class="text-2xl font-bold mb-4">🧰 Tools & Teknologi Pendukung</h2>
        <ul class="list-disc ml-6 text-gray-400 space-y-1">
            <li>XAMPP untuk server lokal</li>
            <li>GitHub untuk version control</li>
            <li>Laravel Breeze untuk autentikasi</li>
        </ul>
    </section>

    <div class="h-1 bg-gradient-to-r from-cyan-400 via-blue-500 to-cyan-400 rounded-full my-10"></div>

    {{-- Fitur --}}
    <section class="max-w-5xl mx-auto px-6 py-10 bg-gray-800 rounded-2xl shadow-lg transition transform hover:scale-[1.01]" data-aos="fade-up">
        <h2 class="text-2xl font-bold mb-4">⚙️ Fitur Utama</h2>
        <ul class="list-disc ml-6 text-gray-400 space-y-1">
            <li>Forum diskusi terbuka untuk mahasiswa dan dosen</li>
            <li>Komentar, balasan, dan sistem edit komentar</li>
            <li>Gamifikasi: poin, badge, dan leaderboard</li>
            <li>Pencarian topik dan kategori dengan hashtag</li>
            <li>Panel admin untuk moderasi konten</li>
        </ul>
    </section>

    <div class="h-1 bg-gradient-to-r from-blue-500 via-cyan-400 to-blue-500 rounded-full my-10"></div>

    {{-- Ucapan Terima Kasih --}}
    <section class="max-w-5xl mx-auto px-6 py-10 bg-gray-800 rounded-2xl shadow-lg text-center transition transform hover:scale-[1.01]" data-aos="fade-up">
        <h2 class="text-2xl font-bold mb-4">🙏 Ucapan Terima Kasih</h2>
        <p class="text-gray-400">
            Terima kasih kepada seluruh pihak yang telah mendukung pengembangan INNOFORUM,
            terutama civitas akademika STTI NIIT I-TECH, dosen pembimbing, rekan mahasiswa,
            serta komunitas teknologi yang menginspirasi proyek ini.
        </p>
    </section>

    <div class="h-1 bg-gradient-to-r from-cyan-400 via-blue-500 to-cyan-400 rounded-full my-10"></div>

    {{-- Kredit --}}
    <section class="max-w-5xl mx-auto px-6 py-10 bg-gray-800 rounded-2xl shadow-lg text-center transition transform hover:scale-[1.01]" data-aos="fade-up">
        <h2 class="text-2xl font-bold mb-4">📜 Kredit & Lisensi</h2>
        <p class="text-gray-400">
            Proyek ini dikembangkan sebagai bagian dari eksplorasi teknologi web modern oleh mahasiswa STTI NIIT I-TECH.<br>
        </p>
    </section>

    {{-- Legal Documents Section --}}
    <section class="max-w-5xl mx-auto px-6 py-10 bg-gray-800 rounded-2xl shadow-lg transition transform hover:scale-[1.01]" data-aos="fade-up">
        <h2 class="text-2xl font-bold mb-6 text-center">📜 Dokumen Legal</h2>
        <div class="grid md:grid-cols-2 gap-6">
            <div class="text-center p-6 border border-blue-500/30 rounded-xl hover:border-blue-400 transition-all duration-300">
                <div class="w-16 h-16 bg-blue-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user-shield text-blue-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-white mb-3">Kebijakan Privasi</h3>
                <p class="text-gray-400 text-sm mb-4">Bagaimana kami melindungi dan mengelola data pribadi Anda</p>
                <a href="{{ route('privacy.policy') }}" class="inline-block bg-blue-600 hover:bg-blue-500 text-white px-6 py-2 rounded-lg transition transform hover:scale-105">
                    Baca Selengkapnya
                </a>
            </div>
            
            <div class="text-center p-6 border border-green-500/30 rounded-xl hover:border-green-400 transition-all duration-300">
                <div class="w-16 h-16 bg-green-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-file-contract text-green-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-white mb-3">Syarat & Ketentuan</h3>
                <p class="text-gray-400 text-sm mb-4">Ketentuan penggunaan platform INNOFORUM</p>
                <a href="{{ route('terms.conditions') }}" class="inline-block bg-green-600 hover:bg-green-500 text-white px-6 py-2 rounded-lg transition transform hover:scale-105">
                    Baca Selengkapnya
                </a>
            </div>
        </div>
    </section>

    <div class="h-1 bg-gradient-to-r from-blue-500 via-cyan-400 to-blue-500 rounded-full my-10"></div>

    {{-- Tombol Kembali --}}
    <div class="text-center pb-12 mt-6">
        <a href="{{ route('dashboard') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition transform hover:scale-105 shadow-lg">
            ← Kembali ke Beranda
        </a>
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

/* Gradient lines tetap terlihat */
.bg-gradient-to-r {
    opacity: 0.8;
}

/* Shadow override */
.shadow-sm, .shadow-md, .shadow-lg {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 2px 4px -1px rgba(0, 0, 0, 0.2) !important;
}

/* Untuk memastikan layout app tetap gelap */
.min-h-screen {
    background-color: #111827 !important;
}

/* Animasi gradient */
@keyframes gradient {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}
.animate-gradient {
    background-size: 200% 200%;
    animation: gradient 10s ease infinite;
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

    /* Memastikan section yang tidak memiliki bg class tetap gelap */
    section:not([class*="bg-"]) {
        background-color: #111827 !important;
    }
}

/* Memastikan semua section memiliki background gelap */
section {
    background-color: #1f2937 !important;
}

/* Exception untuk hero section yang sudah memiliki gradient */
.animate-gradient {
    background-image: linear-gradient(to bottom right, #111827, #1e3a8a, #111827) !important;
}
</style>
@endsection
