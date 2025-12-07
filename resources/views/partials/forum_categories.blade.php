<div class="bg-gray-800 rounded-xl shadow p-4 border border-gray-700 mt-4">
    <h3 class="text-lg font-bold mb-3 text-blue-400">Kategori</h3>

    <ul class="space-y-2" id="forum-cats-top">
        @foreach ($topCategories as $cat)
            <li>
                <a href="{{ route('dashboard', array_merge(request()->except('page'), ['category' => $cat->slug ?? $cat->id])) }}"
                    class="flex items-center justify-between text-sm px-2 py-1 rounded hover:bg-gray-700 {{ isset($selectedCategory) && $selectedCategory && $selectedCategory->id === $cat->id ? 'bg-blue-50 font-semibold text-blue-300' : 'text-gray-300' }}">
                    <span>{{ $cat->name }}</span>
                    <span class="text-gray-400">({{ $cat->questions_count ?? 0 }})</span>
                </a>
            </li>
        @endforeach
    </ul>

    @if (isset($remainingCategories) && $remainingCategories->count() > 0)
        <ul class="space-y-2 hidden mt-3" id="forum-cats-more">
            @foreach ($remainingCategories as $cat)
                <li>
                    <a href="{{ route('dashboard', array_merge(request()->except('page'), ['category' => $cat->slug ?? $cat->id])) }}"
                        class="flex items-center justify-between text-sm px-2 py-1 rounded hover:bg-gray-700 {{ isset($selectedCategory) && $selectedCategory && $selectedCategory->id === $cat->id ? 'bg-blue-50 font-semibold text-blue-300' : 'text-gray-300' }}">
                        <span>{{ $cat->name }}</span>
                        <span class="text-gray-400">({{ $cat->questions_count ?? 0 }})</span>
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="mt-3 text-right">
            <button id="forum-cats-toggle" class="text-xs text-blue-400 hover:underline">Lihat semua kategori</button>
        </div>
    @endif
</div>

<script>
    // Toggle sederhana untuk "Lihat semua kategori"
    (function() {
        var btn = document.getElementById('forum-cats-toggle');
        if (!btn) return;
        btn.addEventListener('click', function(e) {
            var more = document.getElementById('forum-cats-more');
            if (!more) return;
            if (more.classList.contains('hidden')) {
                more.classList.remove('hidden');
                btn.textContent = 'Tutup';
            } else {
                more.classList.add('hidden');
                btn.textContent = 'Lihat semua kategori';
            }
        });
    })();
</script>
