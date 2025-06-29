<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'innoforum') }}</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.10/dist/cdn.min.js" defer></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .bg-navy { background-color: #1e293b; }
        .text-navy { color: #1e293b; }
        .bg-navy-light { background-color: #334155; }
        .bg-blue-accent { background-color: #2563eb; }
        .text-blue-accent { color: #2563eb; }
        .bg-footer { background-color: #0f172a; }
        .footer-social a { color: #fff; }
        .footer-social a:hover { color: #60a5fa; }
    </style>
    <script>
        // Simple dark mode toggle (with localStorage)
        document.addEventListener('DOMContentLoaded', function () {
            const html = document.documentElement;
            // Initial state
            if(localStorage.getItem('mode') === 'dark'){
                html.classList.add('dark');
            }
            // Toggle function
            window.toggleDarkMode = function(){
                html.classList.toggle('dark');
                if(html.classList.contains('dark')){
                    localStorage.setItem('mode', 'dark');
                } else {
                    localStorage.setItem('mode', 'light');
                }
            }
        });
    </script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 min-h-screen flex flex-col transition-colors duration-300">

    <!-- TOP NAVBAR -->
    <nav class="w-full bg-navy dark:bg-gray-950 text-white shadow-md fixed top-0 left-0 z-50">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-4 py-2 relative">
            <!-- Logo/text -->
            <div class="flex items-center gap-2">
                <span class="font-extrabold text-2xl tracking-wide">INNOFORUM</span>
            </div>
            <!-- Menu -->
            <div class="hidden md:flex items-center gap-6 text-base font-semibold">
                <a href="{{ route('dashboard') }}" class="hover:text-blue-300 transition">Beranda</a>
                <a href="{{ route('questions.create') }}" class="hover:text-blue-300 transition">Tanya</a>
                <a href="{{ route('contact') }}" class="hover:text-blue-300 transition">Contact Us</a>
            </div>
            <!-- Right: Notif + Darkmode + Profile -->
            <div class="flex items-center gap-4">
                {{-- NOTIFIKASI - GLOBAL --}}
                @auth
                @php
                    $notif_unread = Auth::user()->notifications()->where('is_read', false)->count();
                    $notif_list = Auth::user()->notifications()->orderByDesc('created_at')->take(10)->get();
                @endphp
                <div class="relative group">
                    <button id="notif-btn-navbar" class="relative focus:outline-none">
                        <span class="material-icons text-3xl text-blue-accent align-middle">notifications</span>
                        @if($notif_unread > 0)
                            <span class="absolute top-0 right-0 w-3 h-3 bg-red-500 rounded-full border-2 border-white"></span>
                        @endif
                    </button>
                    <div id="notif-dropdown-navbar" class="hidden absolute right-0 mt-2 w-80 bg-white dark:bg-gray-900 rounded-lg shadow-lg border border-gray-200 z-50">
                        <div class="p-4 font-bold text-blue-accent border-b border-gray-100 dark:border-gray-700">Notifikasi Terbaru</div>
                        <ul class="max-h-80 overflow-y-auto">
                            @forelse($notif_list as $notif)
                                <li class="px-4 py-3 border-b border-gray-100 dark:border-gray-700 text-sm {{ !$notif->is_read ? 'bg-blue-50 dark:bg-gray-800' : '' }}">
                                    <div>
                                        @if($notif->type === 'answer' && isset($notif->data['message']))
                                            <span class="material-icons text-blue-600 align-middle mr-1">question_answer</span>
                                            <b>{{ $notif->data['message'] }}</b>
                                            @if(isset($notif->data['question_id']))
                                                <a href="{{ route('questions.show', $notif->data['question_id']) }}" class="text-blue-500 hover:underline">Lihat</a>
                                            @endif
                                        @elseif($notif->type === 'like' && isset($notif->data['message']))
                                            <span class="material-icons text-pink-600 align-middle mr-1">thumb_up</span>
                                            {{ $notif->data['message'] }}
                                        @elseif($notif->type === 'mention' && isset($notif->data['message']))
                                            <span class="material-icons text-yellow-600 align-middle mr-1">alternate_email</span>
                                            {{ $notif->data['message'] }}
                                        @elseif($notif->type === 'comment_like' && isset($notif->data['message']))
                                            <span class="material-icons text-green-600 align-middle mr-1">favorite</span>
                                            {{ $notif->data['message'] }}
                                        @elseif($notif->type === 'announcement' && isset($notif->data['title']))
                                            <span class="material-icons text-yellow-600 align-middle mr-1">campaign</span>
                                            <b>Pengumuman:</b> {{ $notif->data['title'] }}
                                            @if(isset($notif->data['content']))
                                                <div class="text-xs text-gray-300 mt-1">{{ Str::limit($notif->data['content'], 100) }}</div>
                                            @elseif(isset($notif->data['message']))
                                                <div class="text-xs text-gray-300 mt-1">{{ Str::limit($notif->data['message'], 100) }}</div>
                                            @endif
                                        @elseif(isset($notif->data['message']))
                                            {{ $notif->data['message'] }}
                                        @elseif(is_array($notif->data))
                                            {{ json_encode($notif->data) }}
                                        @else
                                            {{ $notif->data }}
                                        @endif

                                        <div class="flex justify-between items-center mt-1">
                                            <span class="block text-xs text-gray-400">
                                                {{ \Illuminate\Support\Carbon::parse($notif->created_at)->diffForHumans() }}
                                            </span>
                                            <span class="flex gap-1">
                                                @if(!$notif->is_read)
                                                    <form action="{{ route('notifications.read', $notif->id) }}" method="POST" class="inline" onsubmit="event.stopPropagation();">
                                                        @csrf
                                                        <button title="Tandai sudah dibaca" class="text-green-600 text-base" onclick="event.stopPropagation()">✔</button>
                                                    </form>
                                                @endif
                                                <form action="{{ route('notifications.destroy', $notif->id) }}" method="POST" class="inline" onsubmit="event.stopPropagation();">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button title="Hapus" class="text-red-600 text-base" onclick="event.stopPropagation()">🗑️</button>
                                                </form>
                                            </span>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="px-4 py-4 text-gray-400 text-center">Belum ada notifikasi</li>
                            @endforelse
                        </ul>
                        <div class="px-4 py-2 border-t border-gray-100 dark:border-gray-700 text-right">
                            <a href="{{ route('notifications.index') }}" class="text-blue-500 hover:underline text-sm">Lihat semua</a>
                        </div>
                    </div>
                </div>
                <a href="{{ route('logout.animasi') }}" class="ml-2 px-4 py-2 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition flex items-center">
                    <span class="material-icons align-middle text-base mr-1">logout</span> Logout
                </a>
                @endauth
                @auth
                <div class="relative group">
                    <a href="{{ route('users.show', auth()->id()) }}" class="flex items-center">
                        @if(auth()->user()->photo)
                            <img src="{{ asset('storage/photo/' . auth()->user()->photo) }}" alt="Foto Profil" class="rounded-full w-10 h-10 object-cover border-2 border-blue-500">
                        @else
                            <span class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-lg border-2 border-blue-500">
                                {{ strtoupper(substr(auth()->user()->name,0,2)) }}
                            </span>
                        @endif
                    </a>
                </div>
                @endauth
                @guest
                <a href="{{ route('login') }}" class="ml-2 px-4 py-2 bg-blue-accent text-white rounded-lg font-semibold hover:bg-blue-700 transition">Login</a>
                @endguest
                <!-- Hamburger (mobile) -->
                <button id="navbar-toggle" class="ml-4 md:hidden focus:outline-none">
                    <span class="material-icons text-3xl">menu</span>
                </button>
            </div>
        </div>
        <!-- Mobile menu -->
        <div id="mobile-menu" class="md:hidden hidden flex-col gap-2 px-4 pb-3 bg-navy dark:bg-gray-950 text-white">
            <a href="{{ route('dashboard') }}" class="py-2 block hover:text-blue-300 transition">Beranda</a>
            <a href="{{ route('questions.index') }}" class="py-2 block hover:text-blue-300 transition">Forum</a>
            <a href="{{ route('questions.create') }}" class="py-2 block hover:text-blue-300 transition">Tanya</a>
            <a href="{{ route('contact') }}" class="py-2 block hover:text-blue-300 transition">Contact Us</a>
            @auth
            <a href="{{ route('users.show', auth()->id()) }}" class="py-2 block hover:text-blue-300 transition">Profil</a>
            @endauth
            @guest
            <a href="{{ route('login') }}" class="py-2 block hover:text-blue-300 transition">Login</a>
            @endguest
        </div>
        <script>
            document.getElementById('navbar-toggle').onclick = function() {
                var menu = document.getElementById('mobile-menu');
                menu.classList.toggle('hidden');
            }
            // Icon change
            document.addEventListener('DOMContentLoaded', function () {
                function setIcon() {
                    var html = document.documentElement;
                    var icon = document.getElementById('darkmode-icon');
                    if(icon) icon.textContent = html.classList.contains('dark') ? 'wb_sunny' : 'dark_mode';
                }
                setIcon();
                var darkBtn = document.querySelector('[onclick="toggleDarkMode()"]');
                if(darkBtn) darkBtn.addEventListener('click', function(){
                    setTimeout(setIcon, 150);
                });
                // Notifikasi dropdown navbar
                const btnNotif = document.getElementById('notif-btn-navbar');
                const ddNotif = document.getElementById('notif-dropdown-navbar');
                if(btnNotif && ddNotif) {
                    btnNotif.addEventListener('click', function(e) {
                        e.stopPropagation();
                        ddNotif.classList.toggle('hidden');
                    });
                    // Prevent close when clicking inside dropdown (including forms/buttons)
                    ddNotif.addEventListener('click', function(e) {
                        e.stopPropagation();
                    });
                    document.addEventListener('click', function() {
                        ddNotif.classList.add('hidden');
                    });
                }
            });
        </script>
    </nav>

    <!-- Main Content -->
    <main class="flex-1 w-full max-w-7xl mx-auto pt-36 md:pt-40 px-2 md:px-8 pb-8 flex flex-col">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-white py-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Kolom 1: Tentang -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Tentang INNOFORUM</h3>
                    <p class="text-gray-300 text-sm">
                        Platform tanya jawab untuk mahasiswa STTI NIIT I-Tech. Berbagi pengetahuan, memecahkan masalah, dan berkolaborasi dalam teknologi.
                    </p>
                </div>
                
                <!-- Kolom 2: Kontak -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Hubungi Kami</h3>
                    <ul class="space-y-2 text-gray-300 text-sm">
                        <li class="flex items-start">
                            <span class="material-icons mr-2 text-blue-400">location_on</span>
                            STTI NIIT I-TECH, Jl. Asem II No.22, Cipete Selatan, Jakarta Selatan
                        </li>
                        <li class="flex items-center">
                            <span class="material-icons mr-2 text-blue-400">phone</span>
                            <a href="https://wa.me/6281234567890" class="hover:underline">+62 123-456-7890</a>
                        </li>
                        <li class="flex items-center">
                            <span class="material-icons mr-2 text-blue-400">email</span>
                            <a href="mailto:fortech.forumteknologi@gmail.com" class="hover:underline">fortech.forumteknologi@gmail.com</a>
                        </li>
                    </ul>
                </div>
                
                <!-- Kolom 3: Sosial Media -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Ikuti Kami</h3>
                    <div class="flex space-x-4">
                        <a href="https://wa.me/6281234567890" target="_blank" class="bg-gray-700 hover:bg-green-600 text-white p-2 rounded-full transition-colors duration-300" title="WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="https://www.instagram.com/sttiniititech" target="_blank" class="bg-gray-700 hover:bg-pink-600 text-white p-2 rounded-full transition-colors duration-300" title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="mailto:fortech.forumteknologi@gmail.com" class="bg-gray-700 hover:bg-red-600 text-white p-2 rounded-full transition-colors duration-300" title="Email">
                            <i class="fas fa-envelope"></i>
                        </a>
                        <a href="https://www.youtube.com/@sttiniiti-tech2300" target="_blank" class="bg-gray-700 hover:bg-red-600 text-white p-2 rounded-full transition-colors duration-300" title="YouTube">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Copyright -->
            <div class="border-t border-gray-800 mt-8 pt-6 text-center text-gray-400 text-sm">
                &copy; {{ date('Y') }} INNOFORUM. All rights reserved.
            </div>
        </div>
    </footer>
</body>
</html>