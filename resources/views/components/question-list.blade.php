<div class="grid gap-6">
    @foreach($questions as $q)
    <div class="bg-white/80 dark:bg-gray-800/80 rounded-xl shadow-md p-6 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold">
                {{ strtoupper(substr($q->user->name,0,2)) }}
            </div>
            <div class="font-semibold text-gray-700 dark:text-gray-100">{{ $q->user->name }}</div>
            <span class="text-xs text-gray-400 ml-2">{{ $q->created_at->diffForHumans() }}</span>
        </div>
        <a href="{{ route('questions.show', $q->id) }}" class="block text-lg md:text-xl font-bold text-blue-700 dark:text-blue-300 hover:underline mt-1">
            {{ $q->title }}
        </a>
        <div class="my-2 text-gray-700 dark:text-gray-200">
            {{ \Illuminate\Support\Str::limit($q->content, 180) }}
        </div>
        <div class="flex flex-wrap items-center gap-2 mt-3">
            {{-- Tag --}}
            @if(isset($q->hashtags) && count($q->hashtags))
                @foreach($q->hashtags as $tag)
                    <span class="bg-blue-100 dark:bg-blue-700 text-blue-700 dark:text-blue-100 px-2 py-0.5 rounded text-xs font-medium">#{{ is_object($tag) ? $tag->name : $tag }}</span>
                @endforeach
            @endif
            <div class="flex items-center gap-3 ml-auto">
                <span class="flex items-center gap-1 text-gray-500 dark:text-gray-400">
                    <span class="material-symbols-outlined text-[20px]">thumb_up</span> {{ $q->likes_count ?? 0 }}
                </span>
                <span class="flex items-center gap-1 text-gray-500 dark:text-gray-400">
                    <span class="material-symbols-outlined text-[20px]">comment</span> {{ $q->comments_count ?? 0 }}
                </span>
                @if(auth()->id() == $q->user->id)
                    <a href="{{ route('questions.edit', $q->id) }}" class="ml-2 text-xs text-yellow-600 hover:underline"><span class="material-symbols-outlined text-[20px]">edit</span></a>
                    <form action="{{ route('questions.destroy', $q->id) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-xs text-red-600 hover:underline ml-2" onclick="return confirm('Hapus pertanyaan?')">
                            <span class="material-symbols-outlined text-[20px]">delete</span>
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
