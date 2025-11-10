@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-green-900 to-gray-800 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl mb-6 shadow-lg">
                <i class="fas fa-file-contract text-white text-3xl"></i>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                <span class="text-green-400">Syarat & Ketentuan</span>
            </h1>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                Ketentuan penggunaan platform INNOFORUM untuk seluruh pengguna
            </p>
        </div>

        <!-- Important Notice -->
        <div class="bg-yellow-500/10 rounded-2xl p-6 border border-yellow-500/30 mb-8">
            <div class="flex items-start gap-4">
                <i class="fas fa-exclamation-triangle text-yellow-400 text-2xl mt-1"></i>
                <div>
                    <h6 class="text-lg font-semibold text-yellow-400 mb-2">Penting untuk Dibaca</h6>
                    <p class="text-gray-300">Dengan mengakses atau menggunakan platform INNOFORUM, Anda menyetujui untuk terikat oleh syarat dan ketentuan yang diatur dalam dokumen ini. Harap baca dengan seksama.</p>
                </div>
            </div>
        </div>

        <!-- Meta Information -->
        <div class="bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-700 mb-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                <div class="border-r border-gray-700 pr-4">
                    <h6 class="text-gray-400 text-sm font-semibold mb-1">Versi</h6>
                    <p class="text-green-400 font-bold text-lg">{{ $data['footer']['version'] ?? '1.0' }}</p>
                </div>
                <div class="border-r border-gray-700 pr-4">
                    <h6 class="text-gray-400 text-sm font-semibold mb-1">Terakhir Diperbarui</h6>
                    <p class="text-green-400 font-bold text-lg">{{ $data['lastUpdated'] ?? now()->format('F j, Y') }}</p>
                </div>
                <div class="border-r border-gray-700 pr-4">
                    <h6 class="text-gray-400 text-sm font-semibold mb-1">Status</h6>
                    <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-semibold">Berlaku</span>
                </div>
                <div>
                    <h6 class="text-gray-400 text-sm font-semibold mb-1">Jenis Dokumen</h6>
                    <p class="text-cyan-400 font-bold text-lg">Syarat Layanan</p>
                </div>
            </div>
        </div>

        <!-- Quick Navigation -->
        <div class="bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-700 mb-8">
            <h5 class="text-lg font-semibold text-green-400 mb-4 flex items-center gap-2">
                <i class="fas fa-bookmark"></i>Navigasi Cepat
            </h5>
            <div class="grid md:grid-cols-2 gap-2">
                @foreach($data['content'] as $index => $item)
                <a href="#section-{{ $index + 1 }}" class="flex items-center gap-2 text-gray-300 hover:text-green-300 transition-colors p-2 rounded-lg hover:bg-gray-700">
                    <i class="fas fa-arrow-right text-green-400 text-sm"></i>
                    <span>{{ $item['section'] }}</span>
                </a>
                @endforeach
            </div>
        </div>

        <!-- Legal Content -->
        <div class="space-y-6">
            @foreach($data['content'] as $index => $item)
            <div class="bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-700 legal-section" id="section-{{ $index + 1 }}">
                <div class="flex items-start gap-4 mb-4">
                    <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center flex-shrink-0">
                        <span class="text-white font-bold text-lg">{{ $index + 1 }}</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-white mb-3">{{ $item['section'] }}</h3>
                        
                        @if(isset($item['subsections']))
                            @foreach($item['subsections'] as $subsection)
                                <div class="ml-4 mb-4 pl-4 border-l-2 border-green-500">
                                    <h4 class="text-lg font-semibold text-green-300 mb-2">{{ $subsection['title'] }}</h4>
                                    <p class="text-gray-300 leading-relaxed">{{ $subsection['content'] }}</p>
                                </div>
                            @endforeach
                        @else
                            <p class="text-gray-300 leading-relaxed">{{ $item['content'] }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Acceptance Section -->
        <div class="bg-green-500/10 rounded-2xl p-6 border border-green-500/30 mt-8">
            <div class="flex items-start gap-4">
                <i class="fas fa-check-circle text-green-400 text-2xl mt-1"></i>
                <div>
                    <h6 class="text-lg font-semibold text-green-400 mb-3">Persetujuan Pengguna</h6>
                    <p class="text-gray-300 mb-3">Dengan melanjutkan penggunaan platform INNOFORUM, Anda mengakui bahwa:</p>
                    <ul class="text-gray-300 space-y-2 ml-4">
                        <li class="flex items-center gap-2">
                            <i class="fas fa-check text-green-400 text-sm"></i>
                            Anda telah membaca dan memahami Syarat & Ketentuan ini
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-check text-green-400 text-sm"></i>
                            Anda setuju untuk terikat oleh semua ketentuan yang diatur
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-check text-green-400 text-sm"></i>
                            Anda memahami konsekuensi dari pelanggaran ketentuan
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Footer Meta -->
        <div class="bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-700 mt-8">
            <div class="grid md:grid-cols-2 gap-6 text-center md:text-left">
                <div>
                    <h6 class="text-gray-400 font-semibold mb-2">Dibuat oleh</h6>
                    <p class="text-gray-300">{{ $data['footer']['authors'] ?? 'Tim Pengembang INNOFORUM' }}</p>
                </div>
                <div>
                    <h6 class="text-gray-400 font-semibold mb-2">Platform</h6>
                    <p class="text-gray-300">{{ $data['footer']['institution'] ?? 'INNOFORUM Platform' }}</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="text-center mt-8 space-x-4">
            <a href="{{ route('dashboard') }}" class="bg-green-600 hover:bg-green-500 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 inline-flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>Kembali ke Beranda
            </a>
            <a href="{{ route('privacy.policy') }}" class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 inline-flex items-center gap-2">
                <i class="fas fa-user-shield"></i>Lihat Privacy Policy
            </a>
        </div>
    </div>
</div>

<style>
.legal-section {
    scroll-margin-top: 100px;
}

/* MEMASTIKAN SELURUH HALAMAN TETAP GELAP */
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
.bg-gradient-to-br.from-gray-900.via-green-900.to-gray-800 {
    background-image: linear-gradient(to bottom right, #111827, #065f46, #111827) !important;
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