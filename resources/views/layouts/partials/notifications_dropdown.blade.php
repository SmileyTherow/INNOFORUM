@php use Illuminate\Support\Str; @endphp

@php
    $notifs = auth()->check() ? auth()->user()->notifications()->latest()->take(10)->get() : collect();
@endphp

<ul class="max-h-80 overflow-y-auto">
    @forelse($notifs as $n)
        @php
            $isUnread = is_null($n->read_at);

            $raw = $n->data['excerpt'] ?? $n->data['message'] ?? $n->data['title'] ?? null;

            if (is_array($raw) || is_object($raw)) {
                $text = Str::limit(json_encode($raw, JSON_UNESCAPED_UNICODE), 180);
            } else {
                $text = Str::limit((string) $raw, 180);
            }

            $messageId = $n->data['message_id'] ?? null;
            $questionId = $n->data['question_id'] ?? null;
            $commentId = $n->data['comment_id'] ?? null;
            $type = $n->data['type'] ?? null;
            $url = route('notifications.index');

            if ($messageId && auth()->check() && auth()->user()->role === 'admin') {
                $url = route('admin.messages.show', $messageId);
            } elseif ($questionId) {
                $url = route('questions.show', $questionId);
                if ($commentId) {
                    $url .= '#comment-' . $commentId;
                }
            } elseif ($type === 'message') {
                $url = route('pesan.index');
            }
        @endphp

        <li class="px-4 py-3 border-b border-gray-600 text-sm {{ $isUnread ? 'bg-blue-500/10' : 'bg-gray-700' }}">
            <div class="flex justify-between items-start gap-2">
                <div class="flex-1">
                    @if($text)
                        <a href="{{ $url }}" class="text-sm text-gray-200 hover:text-blue-300 hover:underline inline-block max-w-full">
                            {!! nl2br(e($text)) !!}
                        </a>
                    @else
                        <div class="text-sm text-gray-200">{!! nl2br(e(Str::limit(json_encode($n->data, JSON_UNESCAPED_UNICODE), 180))) !!}</div>
                    @endif

                    <div class="text-xs mt-1 text-gray-400">{{ $n->created_at->diffForHumans() }}</div>
                </div>

                <div class="flex flex-col items-end gap-1">
                    @if($isUnread)
                        <form action="{{ route('notifications.read', $n->id) }}" method="POST" class="inline">
                            @csrf
                            <button class="text-green-400 hover:text-green-300 text-base transition-colors" title="Tandai sudah dibaca">✔</button>
                        </form>
                    @endif

                    <form action="{{ route('notifications.destroy', $n->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-400 hover:text-red-300 text-base transition-colors" title="Hapus">🗑️</button>
                    </form>
                </div>
            </div>
        </li>
    @empty
        <li class="px-4 py-4 text-gray-400 text-center">Belum ada notifikasi</li>
    @endforelse
</ul>

<style>
@media (prefers-color-scheme: light) {
    .max-h-80 { background-color: #1f2937 !important; }
    .border-gray-600 { border-color: #4b5563 !important; }
    .bg-blue-500\/10 { background-color: rgba(59, 130, 246, 0.1) !important; }
    .bg-gray-700 { background-color: #374151 !important; }
    .text-gray-200 { color: #e5e7eb !important; }
    .text-gray-400 { color: #9ca3af !important; }
    .hover\:text-blue-300:hover { color: #93c5fd !important; }
    .text-green-400 { color: #34d399 !important; }
    .hover\:text-green-300:hover { color: #6ee7b7 !important; }
    .text-red-400 { color: #f87171 !important; }
    .hover\:text-red-300:hover { color: #fca5a5 !important; }
}
</style>
