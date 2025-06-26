@extends('layouts.app')

@section('content')
{{-- HERO SECTION --}}
<div class="w-full bg-blue-accent dark:bg-blue-900 rounded-xl shadow mb-10 pt-14 pb-12 px-6 md:px-16 flex flex-col items-center justify-center text-center relative"
    style="min-height: 210px;">
    <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4 drop-shadow-lg">Contact Us</h1>
    <p class="text-white text-lg md:text-2xl font-medium max-w-3xl drop-shadow-lg">
        Untuk pertanyaan, kerjasama, atau bantuan, hubungi kami lewat form di bawah, email, atau WhatsApp.
    </p>
</div>

<div class="flex flex-col items-center w-full mb-16">
    {{-- Google Maps --}}
    <div class="w-full md:w-2/3 mb-8">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.802441625194!2d107.60607657499384!3d-6.908172493084382!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e6e1e1d8f7b9%3A0x5d2c9b252d79e1f5!2sSTTI%20NIIT%20I-TECH!5e0!3m2!1sen!2sid!4v1717431549766!5m2!1sen!2sid"
            width="100%" height="300" style="border:0; border-radius: 18px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>

    {{-- Contact Form Putih --}}
    <div class="bg-white rounded-xl shadow-lg p-8 w-full md:w-2/3 border border-gray-200">
        <h2 class="text-xl font-bold mb-6 text-blue-accent">Formulir Kontak</h2>
        {{-- Pesan sukses --}}
        @if(session('success'))
            <div class="mb-5 p-3 bg-green-100 text-green-800 rounded text-center font-semibold">
                {{ session('success') }}
            </div>
        @endif
        <form method="POST" action="{{ route('contact.send') }}">
            @csrf
            <div class="mb-5">
                <label for="name" class="block text-sm font-bold mb-2 text-gray-700">Nama<span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" required
                    class="w-full px-4 py-2 border border-blue-accent rounded focus:ring-2 focus:ring-blue-accent bg-white text-gray-800 placeholder-gray-400"
                    placeholder="Masukkan nama"/>
            </div>
            <div class="mb-5">
                <label for="email" class="block text-sm font-bold mb-2 text-gray-700">E-Mail<span class="text-red-500">*</span></label>
                <input type="email" name="email" id="email" required
                    class="w-full px-4 py-2 border border-blue-accent rounded focus:ring-2 focus:ring-blue-accent bg-white text-gray-800 placeholder-gray-400"
                    placeholder="Masukkan email"/>
            </div>
            <div class="mb-5">
                <label for="title" class="block text-sm font-bold mb-2 text-gray-700">Judul Pesan<span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" required
                    class="w-full px-4 py-2 border border-blue-accent rounded focus:ring-2 focus:ring-blue-accent bg-white text-gray-800 placeholder-gray-400"
                    placeholder="Masukkan judul pesan"/>
            </div>
            <div class="mb-7">
                <label for="message" class="block text-sm font-bold mb-2 text-gray-700">Isi Pesan<span class="text-red-500">*</span></label>
                <textarea name="message" id="message" required rows="4"
                    class="w-full px-4 py-2 border border-blue-accent rounded focus:ring-2 focus:ring-blue-accent bg-white text-gray-800 placeholder-gray-400"
                    placeholder="Tulis pesan kamu"></textarea>
            </div>
            <button type="submit" class="w-full bg-blue-accent hover:bg-blue-700 text-white font-bold py-3 rounded transition">Kirim Pesan</button>
        </form>
    </div>
</div>
@endsection