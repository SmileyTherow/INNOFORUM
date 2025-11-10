@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-blue-900 to-gray-800 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl mb-6 shadow-lg">
                <i class="fas fa-user-shield text-white text-3xl"></i>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                <span class="text-blue-400">Kebijakan Privasi</span>
            </h1>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                Bagaimana kami melindungi dan mengelola data pribadi Anda di platform INNOFORUM
            </p>
        </div>

        <!-- Meta Information -->
        <div class="bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-700 mb-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                <div class="border-r border-gray-700 pr-4">
                    <h6 class="text-gray-400 text-sm font-semibold mb-1">Versi</h6>
                    <p class="text-blue-400 font-bold text-lg">{{ $data['footer']['version'] ?? '1.0' }}</p>
                </div>
                <div class="border-r border-gray-700 pr-4">
                    <h6 class="text-gray-400 text-sm font-semibold mb-1">Terakhir Diperbarui</h6>
                    <p class="text-green-400 font-bold text-lg">{{ $data['lastUpdated'] ?? now()->format('F j, Y') }}</p>
                </div>
                <div class="border-r border-gray-700 pr-4">
                    <h6 class="text-gray-400 text-sm font-semibold mb-1">Status</h6>
                    <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-semibold">Aktif</span>
                </div>
                <div>
                    <h6 class="text-gray-400 text-sm font-semibold mb-1">Dokumen</h6>
                    <p class="text-cyan-400 font-bold text-lg">Privacy Policy</p>
                </div>
            </div>
        </div>

        <!-- Table of Contents -->
        <div class="bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-700 mb-8">
            <h5 class="text-lg font-semibold text-blue-400 mb-4 flex items-center gap-2">
                <i class="fas fa-list-ul"></i>Daftar Isi
            </h5>
            <div class="grid md:grid-cols-2 gap-2">
                @foreach($data['content'] as $index => $item)
                <a href="#section-{{ $index + 1 }}" class="flex items-center gap-2 text-gray-300 hover:text-blue-300 transition-colors p-2 rounded-lg hover:bg-gray-700">
                    <i class="fas fa-chevron-right text-blue-400 text-sm"></i>
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
                    <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0">
                        <span class="text-white font-bold text-lg">{{ $index + 1 }}</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-white mb-3">{{ $item['section'] }}</h3>
                        
                        @if(isset($item['subsections']))
                            @foreach($item['subsections'] as $subsection)
                                <div class="ml-4 mb-4 pl-4 border-l-2 border-blue-500">
                                    <h4 class="text-lg font-semibold text-blue-300 mb-2">{{ $subsection['title'] }}</h4>
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

        <!-- Additional Information -->
        <div class="bg-blue-500/10 rounded-2xl p-6 border border-blue-500/30 mt-8">
            <div class="flex items-start gap-4">
                <i class="fas fa-info-circle text-blue-400 text-2xl mt-1"></i>
                <div>
                    <h6 class="text-lg font-semibold text-blue-400 mb-2">Informasi Tambahan</h6>
                    <p class="text-gray-300 mb-2">Jika Anda memiliki pertanyaan tentang Kebijakan Privasi ini, silakan hubungi tim dukungan kami melalui halaman kontak atau email resmi platform.</p>
                    <p class="text-gray-300">Kami dapat memperbarui kebijakan ini dari waktu ke waktu untuk mencerminkan perubahan dalam praktik kami atau untuk alasan operasional, hukum, atau peraturan lainnya.</p>
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
            <a href="{{ route('dashboard') }}" class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 inline-flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>Kembali ke Beranda
            </a>
            <a href="{{ route('terms.conditions') }}" class="bg-green-600 hover:bg-green-500 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 inline-flex items-center gap-2">
                <i class="fas fa-file-contract"></i>Lihat Terms & Conditions
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