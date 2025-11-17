@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-8 px-4">
        <h2 class="text-2xl font-bold mb-6 text-blue-400">Notifikasi</h2>

        <div class="flex gap-3 mb-6 flex-wrap">
            <a href="{{ route('notifications.index', ['tab' => 'unread']) }}"
                class="px-4 py-2 rounded-lg transition-colors {{ $tab === 'unread' ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600' }}">
                Belum Dibaca
                @if ($count_unread > 0)
                    <span
                        class="ml-2 inline-block bg-red-500 text-white text-xs px-2 py-1 rounded-full">{{ $count_unread }}</span>
                @endif
            </a>
            <a href="{{ route('notifications.index', ['tab' => 'read']) }}"
                class="px-4 py-2 rounded-lg transition-colors {{ $tab === 'read' ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600' }}">
                Sudah Dibaca
            </a>

            @if ($tab === 'unread' && $count_unread > 0)
                <form action="{{ route('notifications.markAllAsRead') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-green-600 hover:bg-green-500 text-white text-sm transition-colors">
                        Tandai semua sudah dibaca
                    </button>
                </form>
            @endif
        </div>

        @if (session('success'))
            <div class="mb-6 p-3 bg-green-500/20 text-green-300 rounded border border-green-500/30">
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-4">
            @forelse($notifications as $notif)
                <div
                    class="p-4 rounded-lg shadow bg-gray-800 border border-gray-700 {{ !$notif->is_read ? 'border-l-4 border-blue-500' : '' }}">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            @php
                                $url = $notif->link ?? route('notifications.index');
                                $text = $notif->safe_message ?? ($notif->clean_message ?? 'Notifikasi baru');
                                $text = is_string($text) ? $text : json_encode($text);
                            @endphp
                            <a href="{{ $url }}"
                                class="text-gray-200 hover:text-blue-300 hover:underline block mb-2">
                                {!! nl2br(e($text)) !!}
                            </a>
                            <div class="text-xs text-gray-400">
                                {{ $notif->created_at->diffForHumans() }}
                            </div>
                        </div>

                        <div class="flex gap-2 ml-4">
                            @if (!$notif->is_read)
                                <form action="{{ route('notifications.read', $notif->id) }}" method="POST">
                                    @csrf
                                    <button
                                        class="text-green-400 bg-green-500/20 hover:bg-green-500/30 px-3 py-1 rounded transition-colors border border-green-500/30 text-sm">
                                        ✔
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('notifications.destroy', $notif->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button
                                    class="text-red-400 bg-red-500/20 hover:bg-red-500/30 px-3 py-1 rounded transition-colors border border-red-500/30 text-sm">
                                    🗑️
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-gray-400 bg-gray-800 rounded-lg border border-gray-700">
                    <span class="material-icons text-4xl mb-3 text-gray-500">notifications_off</span>
                    <p class="text-lg">Tidak ada notifikasi
                        {{ $tab === 'read' ? 'yang sudah dibaca' : 'yang belum dibaca' }}.</p>
                </div>
            @endforelse
        </div>

        @if ($notifications->hasPages())
            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>

    <style>
        /* Pastikan styling konsisten */
        body {
            background-color: #111827 !important;
        }

        .bg-gray-800 {
            background-color: #1f2937 !important;
        }

        .border-gray-700 {
            border-color: #374151 !important;
        }

        .text-gray-200 {
            color: #e5e7eb !important;
        }

        .text-gray-400 {
            color: #9ca3af !important;
        }

        /* Pagination dark mode */
        .pagination .page-item .page-link {
            background-color: #374151;
            border-color: #4b5563;
            color: #d1d5db;
        }

        .pagination .page-item.active .page-link {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }
    </style>
@endsection
