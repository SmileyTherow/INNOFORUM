<div class="bg-white rounded-lg shadow p-6 mb-4">
    <div class="flex items-center mb-2">
        <!-- Avatar user mengarah ke profil -->
        <a href="{{ route('users.show', $question->user->id) }}">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($question->user->name ?? 'Anonim') }}" alt="avatar" class="w-10 h-10 rounded-full mr-3">
        </a>
        <div>
            <a href="{{ route('users.show', $question->user->id) }}" class="font-bold text-gray-800 hover:underline">
                {{ $question->user->name ?? 'Anonim' }}
            </a>
            <span class="text-sm text-gray-500 ml-2">{{ $question->created_at->diffForHumans() }}</span>
        </div>
    </div>
    <a href="{{ route('questions.show', $question->id) }}" class="block">
        <h3 class="text-lg font-semibold text-blue-700 mb-1 hover:underline">{{ $question->title }}</h3>
        <p class="text-gray-700 mb-2">{{ \Illuminate\Support\Str::limit($question->content, 100) }}</p>
    </a>
    <div class="flex items-center text-sm text-gray-500 mt-2 flex-wrap gap-2">
        <span class="mr-4"><i class="fas fa-comment mr-1"></i> {{ $question->comments->count() }} Jawaban</span>
        <span class="mr-4"><i class="fas fa-heart mr-1"></i> {{ $question->likes->count() }}</span>
        @foreach($question->hashtags as $tag)
            <a href="{{ route('questions.byHashtag', $tag->id) }}" class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">#{{ $tag->name }}</a>
        @endforeach
    </div>
    {{-- Tombol Edit dan Hapus, hanya muncul untuk pemilik pertanyaan --}}
    @if(auth()->check() && auth()->id() === $question->user_id)
        <div class="mt-3 flex gap-2">
            <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-warning btn-sm">Edit</a>
            <form action="{{ route('questions.destroy', $question->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus pertanyaan ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
            </form>
        </div>
    @endif
</div>
