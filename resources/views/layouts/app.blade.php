<!DOCTYPE html>
<html lang="id" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'innoforum') }}</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.10/dist/cdn.min.js" defer></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .bg-navy {
            background-color: #0f172a;
        }

        .text-navy {
            color: #0f172a;
        }

        .bg-navy-light {
            background-color: #334155;
        }

        .bg-blue-accent {
            background-color: #2563eb;
        }

        .text-blue-accent {
            color: #2563eb;
        }

        .bg-footer {
            background-color: #0f172a;
        }

        .footer-social a {
            color: #fff;
        }

        .footer-social a:hover {
            color: #60a5fa;
        }

        .notif-item-unread {
            background-color: rgba(59, 130, 246, 0.1) !important;
        }

        .notif-item-read {
            background-color: #374151 !important;
        }

        .notif-text {
            color: #d1d5db !important;
        }

        .notif-time {
            color: #9ca3af !important;
        }

        .notif-container {
            background-color: #1f2937 !important;
            border-color: #374151 !important;
        }

        .notif-header {
            color: #60a5fa !important;
            border-color: #374151 !important;
        }

        .notif-empty {
            color: #9ca3af !important;
        }

        .notif-border {
            border-color: #374151 !important;
        }
    </style>
</head>

<body class="bg-gray-50 dark:bg-gray-900 min-h-screen flex flex-col transition-colors duration-300">

    <!-- TOP NAVBAR -->
    <nav class="w-full bg-navy dark:bg-gray-950 text-white shadow-md fixed top-0 left-0 z-50">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-4 py-2 relative">
            <!-- Logo/text -->
            <div class="flex items-center gap-2">
                <a href="{{ route('dashboard') }}" class="hover:text-blue-300 transition">
                    <span class="font-extrabold text-2xl tracking-wide">INNOFORUM</span>
                </a>
            </div>
            <!-- Menu -->
            <div class="hidden md:flex items-center gap-6 text-base font-semibold">
                <a href="{{ route('dashboard') }}" class="hover:text-blue-300 transition">Beranda</a>
                <a href="{{ route('questions.create') }}" class="hover:text-blue-300 transition">Tanya</a>
                <a href="{{ route('contact') }}" class="hover:text-blue-300 transition">Contact Us</a>
                <a href="{{ route('pesan.index') }}" class="hover:text-blue-300 transition">Pesan</a>
            </div>
            <!-- kanan: Notif + Darkmode + Profile -->
            <div class="flex items-center gap-4">
                {{-- NOTIFIKASI - GLOBAL --}}
                @auth
                    @php
                        $notif_unread = Auth::user()->notifications()->where('is_read', false)->count();
                        $notif_list = Auth::user()->notifications()->orderByDesc('created_at')->take(10)->get();
                    @endphp
                    <div class="relative group">
                        <button id="notif-btn-navbar" class="relative focus:outline-none">
                            <span class="material-icons text-3xl text-blue-400 align-middle">notifications</span>
                            <span id="notif-badge"
                                class="hidden absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full px-1 min-w-[18px] h-4 flex items-center justify-center">
                                0
                            </span>
                            @if ($notif_unread > 0)
                                <span
                                    class="absolute top-0 right-0 w-3 h-3 bg-red-500 rounded-full border-2 border-gray-800"></span>
                            @endif
                        </button>
                        <div id="notif-dropdown-navbar"
                            class="hidden absolute right-0 mt-2 w-80 notif-container rounded-lg shadow-lg border notif-border z-50 animate-fadeIn">
                            <div class="p-4 font-bold notif-header border-b notif-border">
                                Notifikasi Terbaru
                            </div>

                            <ul class="max-h-80 overflow-y-auto">
                                @forelse($notif_list as $notif)
                                    <li
                                        class="px-4 py-3 border-b notif-border text-sm {{ !$notif->is_read ? 'notif-item-unread' : 'notif-item-read' }}">
                                        <div>
                                            @php
                                                $displayText = trim($notif->clean_message ?? '');
                                                $isAdmin = $notif->is_from_admin ?? false;
                                                $link = $notif->link ?? null;
                                                if ($isAdmin && $displayText) {
                                                    $displayText = 'Admin: ' . $displayText;
                                                }
                                                if (!$displayText) {
                                                    $displayText = 'Notifikasi baru';
                                                }
                                            @endphp

                                            @if ($link)
                                                <a href="{{ $link }}"
                                                    class="text-sm notif-text hover:text-blue-300 hover:underline inline-block">
                                                    {!! nl2br(e(\Illuminate\Support\Str::limit($displayText, 200))) !!}
                                                </a>
                                            @else
                                                <a href="{{ route('notifications.index') }}"
                                                    class="text-sm notif-text hover:text-blue-300 hover:underline inline-block">
                                                    {!! nl2br(e(\Illuminate\Support\Str::limit($displayText, 200))) !!}
                                                </a>
                                            @endif

                                            <div class="flex justify-between items-center mt-1">
                                                <span class="block text-xs notif-time">
                                                    {{ \Illuminate\Support\Carbon::parse($notif->created_at)->diffForHumans() }}
                                                </span>
                                                <span class="flex gap-1">
                                                    @if (!$notif->is_read)
                                                        <form action="{{ route('notifications.read', $notif->id) }}"
                                                            method="POST" class="inline"
                                                            onsubmit="event.stopPropagation();">
                                                            @csrf
                                                            <button title="Tandai sudah dibaca"
                                                                class="text-green-400 text-base hover:text-green-300"
                                                                onclick="event.stopPropagation()">✔</button>
                                                        </form>
                                                    @endif
                                                    <form action="{{ route('notifications.destroy', $notif->id) }}"
                                                        method="POST" class="inline" onsubmit="event.stopPropagation();">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button title="Hapus"
                                                            class="text-red-400 text-base hover:text-red-300"
                                                            onclick="event.stopPropagation()">🗑️</button>
                                                    </form>
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                @empty
                                    <li class="px-4 py-4 notif-empty text-center">Belum ada notifikasi</li>
                                @endforelse
                            </ul>

                            <div class="px-4 py-2 border-t notif-border text-right">
                                <a href="{{ route('notifications.index') }}"
                                    class="text-blue-400 hover:text-blue-300 hover:underline text-sm">Lihat semua</a>
                            </div>
                        </div>
                    </div>
                @endauth
                @auth
                    <div class="relative group">
                        <a href="{{ route('users.show', auth()->id()) }}" class="flex items-center">
                            @if (auth()->user()->photo)
                                <img src="{{ asset('storage/photo/' . auth()->user()->photo) }}" alt="Foto Profil"
                                    class="rounded-full w-10 h-10 object-cover border-2 border-blue-500">
                            @else
                                <span
                                    class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-lg border-2 border-blue-500">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                </span>
                            @endif
                        </a>
                    </div>
                @endauth
                @guest
                    <a href="{{ route('login') }}"
                        class="ml-2 px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-500 transition">Login</a>
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
            <a href="{{ route('pesan.index') }}" class="hover:text-blue-300 transition">Pesan</a>
            @auth
                <a href="{{ route('users.show', auth()->id()) }}"
                    class="py-2 block hover:text-blue-300 transition">Profil</a>
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

            // Notifikasi dropdown navbar
            document.addEventListener('DOMContentLoaded', function() {
                const btnNotif = document.getElementById('notif-btn-navbar');
                const ddNotif = document.getElementById('notif-dropdown-navbar');
                if (btnNotif && ddNotif) {
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
                        Platform tanya jawab untuk mahasiswa STTI NIIT I-Tech. Berbagi pengetahuan, memecahkan masalah,
                        dan berkolaborasi dalam teknologi.
                    </p>
                </div>

                <!-- Kolom 2: Kontak -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Hubungi Kami</h3>
                    <ul class="space-y-2 text-gray-300 text-sm">
                        <li class="flex items-start">
                            <span class="material-icons mr-2 text-blue-400">location_on</span>
                            <a href="https://maps.app.goo.gl/89NGmtueysAZA2GMA" class="hover:underline"
                                target="_blank" rel="noopener noreferrer">
                                Birkenwaldstraße 38, 63179 Obertshausen, Germany
                            </a>
                        </li>
                        <li class="flex items-center">
                            <span class="material-icons mr-2 text-blue-400">phone</span>
                            <a href="https://wa.me/6281234567890" class="hover:underline">+62 123-456-7890</a>
                        </li>
                        <li class="flex items-center">
                            <span class="material-icons mr-2 text-blue-400">email</span>
                            <a href="mailto:fortech.forumteknologi@gmail.com"
                                class="hover:underline">fortech.forumteknologi@gmail.com</a>
                        </li>
                    </ul>
                </div>

                <!-- Kolom 3: Sosial Media -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Ikuti Kami</h3>
                    <div class="flex space-x-4">
                        <a href="https://wa.me/6281234567890" target="_blank"
                            class="bg-gray-700 hover:bg-green-600 text-white p-2 rounded-full transition-colors duration-300"
                            title="WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="https://www.instagram.com/sttiniititech" target="_blank"
                            class="bg-gray-700 hover:bg-pink-600 text-white p-2 rounded-full transition-colors duration-300"
                            title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="mailto:fortech.forumteknologi@gmail.com"
                            class="bg-gray-700 hover:bg-red-600 text-white p-2 rounded-full transition-colors duration-300"
                            title="Email">
                            <i class="fas fa-envelope"></i>
                        </a>
                        <a href="https://www.youtube.com/@sttiniiti-tech2300" target="_blank"
                            class="bg-gray-700 hover:bg-red-600 text-white p-2 rounded-full transition-colors duration-300"
                            title="YouTube">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-gray-800 mt-8 pt-6 text-center text-gray-400 text-sm">
                <a href="{{ route('about') }}" class="text-sm text-gray-300 hover:text-white hover:underline">Tentang
                    & Kredit</a>
                |
                <a href="{{ route('terms') }}" class="text-sm text-gray-300 hover:text-white hover:underline">Aturan
                    Penggunaan Forum</a>
                &copy; {{ date('Y') }} INNOFORUM. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Tombol Bantuan Mengambang - Redirect ke halaman bantuan -->
    <a href="{{ url('/bantuan') }}"
        class="fixed bottom-6 right-6 bg-blue-600 hover:bg-blue-500 text-white px-5 py-3 rounded-full shadow-lg flex items-center gap-2 z-50 transition-all">
        💬 Bantuan
    </a>

    <!-- Animasi muncul -->
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.25s ease-out;
        }

        @media (prefers-color-scheme: light) {
            .notif-item-unread {
                background-color: rgba(59, 130, 246, 0.1) !important;
            }

            .notif-item-read {
                background-color: #1f2937 !important;
            }

            .notif-text {
                color: #d1d5db !important;
            }

            .notif-time {
                color: #9ca3af !important;
            }

            .notif-container {
                background-color: #1f2937 !important;
                border-color: #374151 !important;
            }

            .notif-header {
                color: #60a5fa !important;
                border-color: #374151 !important;
            }

            .notif-empty {
                color: #9ca3af !important;
            }

            .notif-border {
                border-color: #374151 !important;
            }
        }
    </style>

    <script>
        window.startConversation = async function(userId) {
            if (!userId) return;
            try {
                const meta = document.querySelector('meta[name="csrf-token"]');
                const csrf = meta ? meta.getAttribute('content') : '{{ csrf_token() }}';

                const res = await fetch("{{ route('pesan.conversations.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        user_id: userId
                    })
                });

                if (res.redirected) {
                    window.location.href = res.url;
                    return;
                }

                const data = await res.json();

                if (!res.ok) {
                    console.error('Gagal membuat/membuka percakapan', data);
                    const msg = data.message || (data.errors ? JSON.stringify(data.errors) :
                        'Gagal membuka percakapan');
                    alert(msg);
                    return;
                }

                const conv = data.conversation ?? data.data ?? data;
                const convId = conv?.id ?? data?.id ?? null;

                if (!convId) {
                    window.location.href = "{{ url('/pesan') }}";
                    return;
                }

                if (window.location.pathname === '{{ url('/pesan') }}'.replace(location.origin, '')) {
                    const payload = (conv && conv.id) ? conv : {
                        id: convId,
                        other: {
                            id: userId,
                            name: 'User'
                        }
                    };
                    window.dispatchEvent(new CustomEvent('conversation.created', {
                        detail: payload
                    }));
                    return;
                }

                window.location.href = `{{ url('/pesan') }}?conv=${convId}`;
            } catch (err) {
                console.error('startConversation error', err);
                alert('Terjadi kesalahan pada koneksi. Cek console untuk detail.');
            }
        };

        document.addEventListener('DOMContentLoaded', function() {
            if (!window.Echo) return;

            const myId = {{ auth()->id() ?? 'null' }};

            if (myId) {
                try {
                    window.Echo.private(`App.Models.User.${myId}`)
                        .notification((notification) => {
                            console.log('Got notification', notification);
                            const badge = document.querySelector('#notif-badge');
                            if (badge) {
                                let val = parseInt(badge.innerText || '0') || 0;
                                badge.innerText = val + 1;
                                badge.classList.remove('hidden');
                            }
                            if (notification?.data) {
                                const text = notification.data.text || 'Pesan baru';
                                alert('Notifikasi: ' + text);
                            }
                        });
                } catch (e) {
                    console.error('Echo listen user channel error', e);
                }
            }
        });
    </script>

</body>

</html>
