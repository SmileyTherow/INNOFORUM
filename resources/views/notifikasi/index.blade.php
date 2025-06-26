@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-8 px-4">
    <h2 class="text-2xl font-bold mb-6 text-blue-700">Notifikasi</h2>

    <div class="flex gap-3 mb-4">
        <a href="{{ route('notifications.index', ['tab' => 'unread']) }}"
            class="px-4 py-2 rounded {{ $tab === 'unread' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-blue-700' }}">
            Belum Dibaca
            @if($count_unread > 0)
                <span class="ml-2 inline-block bg-red-600 text-white text-xs px-2 rounded-full">{{ $count_unread }}</span>
            @endif
        </a>
        <a href="{{ route('notifications.index', ['tab' => 'read']) }}"
            class="px-4 py-2 rounded {{ $tab === 'read' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-blue-700' }}">
            Sudah Dibaca
        </a>
        @if($tab === 'unread' && $notifications->count())
        <form action="{{ route('notifications.readAll') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="ml-6 px-3 py-2 rounded bg-green-600 text-white text-sm hover:bg-green-700">Tandai semua sudah dibaca</button>
        </form>
        @endif
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
    @endif

    @forelse($notifications as $notif)
        <div class="mb-4 p-4 rounded-lg shadow bg-white flex justify-between items-center {{ !$notif->is_read ? 'border-l-4 border-blue-600' : '' }}">
            <div>
                <div>
                    @if($notif->type === 'announcement' && isset($notif->data['title']))
                        <span class="material-icons text-yellow-600 align-middle mr-1">campaign</span>
                        <b>Pengumuman:</b> {{ $notif->data['title'] }}
                        @if(isset($notif->data['content']))
                            <div class="text-xs text-gray-700 mt-1">{{ $notif->data['content'] }}</div>
                        @endif
                    @elseif(isset($notif->data['message']))
                        {{ $notif->data['message'] }}
                    @elseif(is_array($notif->data))
                        {{ json_encode($notif->data) }}
                    @else
                        {{ $notif->data }}
                    @endif
                </div>
                <div class="text-xs text-gray-500">{{ $notif->created_at->diffForHumans() }}</div>
            </div>
            <div class="flex gap-2">
                @if(!$notif->is_read)
                <form action="{{ route('notifications.read', $notif->id) }}" method="POST">
                    @csrf
                    <button class="text-green-700 bg-green-100 hover:bg-green-200 px-2 py-1 rounded" title="Tandai sudah dibaca">✔</button>
                </form>
                @endif
                <form action="{{ route('notifications.destroy', $notif->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-700 bg-red-100 hover:bg-red-200 px-2 py-1 rounded" title="Hapus">🗑️</button>
                </form>
            </div>
        </div>
    @empty
        <div class="p-4 text-center text-gray-500 bg-gray-100 rounded">Tidak ada notifikasi.</div>
    @endforelse

    <div class="mt-6">
        {{ $notifications->appends(request()->query())->links() }}
    </div>
</div>
@endsection