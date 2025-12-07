@extends('layouts.app')

@section('content')
{{-- HERO SECTION --}}
<div class="w-full bg-gradient-to-r from-blue-900 to-blue-700 rounded-xl shadow mb-10 pt-14 pb-12 px-6 md:px-16 flex flex-col items-center justify-center text-center relative"
    style="min-height: 210px;">
    <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4 drop-shadow-lg">Contact Us</h1>
    <p class="text-white text-lg md:text-2xl font-medium max-w-3xl drop-shadow-lg">
        Untuk pertanyaan, kerjasama, atau bantuan, hubungi kami lewat form di bawah, email, atau WhatsApp.
    </p>
</div>

<div class="flex flex-col items-center w-full mb-16">
    {{-- Google Maps - DIPERBESAR --}}
    <div class="w-full mb-8 rounded-xl overflow-hidden shadow-lg">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d640.1356841736974!2d8.872870700041018!3d50.07612463717358!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47bd14096022af2b%3A0x9b5b7e1cc76549de!2sInnoforum%20GmbH!5e0!3m2!1sen!2sid!4v1763947103289!5m2!1sen!2sid"
                width="100%"
                height="500"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>

    {{-- Contact Form - DIPERBESAR --}}
    <div class="bg-gray-800 rounded-xl shadow-lg p-10 w-full border border-gray-700">
        <h2 class="text-2xl font-bold mb-8 text-blue-400">Formulir Kontak</h2>
        {{-- Pesan sukses --}}
        @if(session('success'))
            <div class="mb-5 p-3 bg-green-500/20 text-green-300 rounded text-center font-semibold border border-green-500/30">
                {{ session('success') }}
            </div>
        @endif
        <form method="POST" action="{{ route('contact.send') }}">
            @csrf
            <div class="mb-6">
                <label for="name" class="block text-base font-bold mb-2 text-gray-300">Nama<span class="text-red-400">*</span></label>
                <input type="text" name="name" id="name" required
                    class="w-full px-4 py-3 text-lg border border-gray-600 rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-700 text-white placeholder-gray-400 transition-colors"
                    placeholder="Masukkan nama"/>
            </div>
            <div class="mb-6">
                <label for="email" class="block text-base font-bold mb-2 text-gray-300">E-Mail<span class="text-red-400">*</span></label>
                <input type="email" name="email" id="email" required
                    class="w-full px-4 py-3 text-lg border border-gray-600 rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-700 text-white placeholder-gray-400 transition-colors"
                    placeholder="Masukkan email"/>
            </div>
            <div class="mb-6">
                <label for="title" class="block text-base font-bold mb-2 text-gray-300">Judul Pesan<span class="text-red-400">*</span></label>
                <input type="text" name="title" id="title" required
                    class="w-full px-4 py-3 text-lg border border-gray-600 rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-700 text-white placeholder-gray-400 transition-colors"
                    placeholder="Masukkan judul pesan"/>
            </div>
            <div class="mb-8">
                <label for="message" class="block text-base font-bold mb-2 text-gray-300">Isi Pesan<span class="text-red-400">*</span></label>
                <textarea name="message" id="message" required rows="6"
                    class="w-full px-4 py-3 text-lg border border-gray-600 rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-700 text-white placeholder-gray-400 transition-colors resize-none"
                    placeholder="Tulis pesan kamu"></textarea>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-4 text-lg rounded transition-colors duration-300 transform hover:scale-[1.02] shadow-lg">
                Kirim Pesan
            </button>
        </form>
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

/* Input fields styling */
.bg-gray-700 {
    background-color: #374151 !important;
}

.border-gray-600 {
    border-color: #4b5563 !important;
}

/* Shadow override */
.shadow-sm, .shadow-md, .shadow-lg {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 2px 4px -1px rgba(0, 0, 0, 0.2) !important;
}

/* Focus states untuk input */
input:focus, textarea:focus {
    outline: none;
    ring: 2px;
}

/* Hero section gradient */
.bg-gradient-to-r.from-blue-900.to-blue-700 {
    background-image: linear-gradient(to right, #1e3a8a, #1d4ed8) !important;
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

    /* Memastikan input tetap gelap */
    input, textarea {
        background-color: #374151 !important;
        color: #e5e7eb !important;
        border-color: #4b5563 !important;
    }

    input::placeholder, textarea::placeholder {
        color: #9ca3af !important;
    }
}

/* Animasi untuk hover effects */
.transition-colors {
    transition: all 0.3s ease;
}

.transform {
    transition: transform 0.2s ease;
}
</style>
@endsection
