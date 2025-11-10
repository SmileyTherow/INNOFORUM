@extends('layouts.app')

@section('content')
<div class="flex">
    <div class="w-full p-4 md:p-8">
        <div class="max-w-3xl mx-auto bg-gray-800 rounded-xl shadow-lg p-6 md:p-10 border border-gray-700">
            <h1 class="text-2xl font-bold text-center text-blue-400 mb-8">Buat Pertanyaan</h1>
            <form action="{{ route('questions.store') }}" method="POST">
                @csrf

                <!-- Judul Pertanyaan -->
                <div class="mb-6">
                    <label for="title" class="block text-sm font-semibold text-gray-300 mb-2">Judul Pertanyaan</label>
                    <input type="text" name="title" id="title" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white text-gray-800 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-500 shadow-sm" placeholder="Tulis judul pertanyaan Anda" required>
                    <p class="mt-1 text-xs text-gray-400">Buat judul yang spesifik dan jelas</p>
                </div>

                <!-- Kategori -->
                <div class="mb-6">
                    <label for="category_id" class="block text-sm font-semibold text-gray-300 mb-2">Kategori</label>
                    <select name="category_id" id="category_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white text-gray-800 focus:ring-blue-500 focus:border-blue-500 shadow-sm" required>
                        <option value="" disabled selected class="text-gray-500">Pilih Kategori</option>
                        @foreach(\App\Models\Category::all() as $cat)
                            <option value="{{ $cat->id }}" class="text-gray-800">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Isi Pertanyaan -->
                <div class="mb-6">
                    <label for="content" class="block text-sm font-semibold text-gray-300 mb-2">Isi Pertanyaan</label>
                    <div class="flex flex-wrap items-center gap-3 mb-2 p-3 bg-white rounded-lg border border-gray-300 shadow-sm">
                        <select class="text-sm border border-gray-300 rounded px-3 py-2 bg-white text-gray-800 focus:ring-blue-500 focus:border-blue-500">
                            <option class="text-gray-800">Arial</option>
                            <option class="text-gray-800">Times New Roman</option>
                            <option class="text-gray-800">Courier New</option>
                        </select>
                        <select class="text-sm border border-gray-300 rounded px-3 py-2 bg-white text-gray-800 focus:ring-blue-500 focus:border-blue-500 ml-2">
                            <option class="text-gray-800">Kecil</option>
                            <option selected class="text-gray-800">Normal</option>
                            <option class="text-gray-800">Besar</option>
                        </select>
                        <div class="flex flex-wrap items-center gap-2 ml-4">
                            <button type="button" class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded hover:bg-gray-100 px-2 text-gray-600 hover:text-gray-800">
                                <i class="fas fa-bold text-lg"></i>
                            </button>
                            <button type="button" class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded hover:bg-gray-100 px-2 text-gray-600 hover:text-gray-800">
                                <i class="fas fa-italic text-lg"></i>
                            </button>
                            <button type="button" class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded hover:bg-gray-100 px-2 text-gray-600 hover:text-gray-800">
                                <i class="fas fa-underline text-lg"></i>
                            </button>
                            <button type="button" class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded hover:bg-gray-100 px-2 text-gray-600 hover:text-gray-800">
                                <i class="fas fa-align-left text-lg"></i>
                            </button>
                            <button type="button" class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded hover:bg-gray-100 px-2 text-gray-600 hover:text-gray-800">
                                <i class="fas fa-align-center text-lg"></i>
                            </button>
                            <button type="button" class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded hover:bg-gray-100 px-2 text-gray-600 hover:text-gray-800">
                                <i class="fas fa-align-right text-lg"></i>
                            </button>
                            <button type="button" class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded hover:bg-gray-100 px-2 text-gray-600 hover:text-gray-800">
                                <i class="fas fa-list-ul text-lg"></i>
                            </button>
                            <button type="button" class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded hover:bg-gray-100 px-2 text-gray-600 hover:text-gray-800">
                                <i class="fas fa-list-ol text-lg"></i>
                            </button>
                        </div>
                    </div>
                    <textarea name="content" id="content" rows="8" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white text-gray-800 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-500 shadow-sm" placeholder="Jelaskan pertanyaan Anda secara detail" required></textarea>
                    <p class="mt-1 text-xs text-gray-400">Sertakan semua informasi yang diperlukan untuk memahami pertanyaan Anda</p>
                </div>

                <!-- Hashtag -->
                <div class="mb-6">
                    <label for="tags" class="block text-sm font-semibold text-gray-300 mb-2">Hashtag</label>
                    <div class="flex flex-wrap gap-2 p-3 border border-gray-300 rounded-lg min-h-12 bg-white shadow-sm">
                        <div id="selectedTags" class="flex flex-wrap gap-2"></div>
                        <input type="text" id="tagInput" class="flex-grow outline-none px-2 bg-transparent text-gray-800 placeholder-gray-500" placeholder="Tambahkan hashtag (contoh: #matematika #fisika)">
                        <input type="hidden" name="tags" id="tags">
                    </div>
                    <p class="mt-1 text-xs text-gray-400">Tekan Enter atau koma untuk menambahkan hashtag</p>
                    <div class="mt-3">
                        <p class="text-xs font-medium text-gray-300 mb-1">Hashtag Populer:</p>
                        <div class="flex flex-wrap gap-2">
                            <button type="button" class="tag-suggestion text-xs bg-blue-100 text-blue-600 px-3 py-1 rounded-full hover:bg-blue-200 transition-colors">#Jaringan</button>
                            <button type="button" class="tag-suggestion text-xs bg-blue-100 text-blue-600 px-3 py-1 rounded-full hover:bg-blue-200 transition-colors">#Kalkulus</button>
                            <button type="button" class="tag-suggestion text-xs bg-blue-100 text-blue-600 px-3 py-1 rounded-full hover:bg-blue-200 transition-colors">#PHP</button>
                            <button type="button" class="tag-suggestion text-xs bg-blue-100 text-blue-600 px-3 py-1 rounded-full hover:bg-blue-200 transition-colors">#programming</button>
                            <button type="button" class="tag-suggestion text-xs bg-blue-100 text-blue-600 px-3 py-1 rounded-full hover:bg-blue-200 transition-colors">#tugas</button>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-600 my-6"></div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 shadow hover:shadow-lg transform hover:scale-[1.02]">
                    Publikasikan Pertanyaan Anda
                </button>
            </form>
        </div>
    </div>
</div>

<style>
/* MEMASTIKAN BACKGROUND HALAMAN TETAP GELAP */
body {
    background-color: #111827 !important;
    color: #e5e7eb !important;
}

/* Container utama tetap gelap */
.bg-gray-800 {
    background-color: #1f2937 !important;
}

/* Text colors untuk label dan helper text */
.text-gray-300 {
    color: #d1d5db !important;
}

.text-gray-400 {
    color: #9ca3af !important;
}

/* Shadow untuk container utama */
.shadow-lg {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.2) !important;
}

/* Shadow untuk input fields */
.shadow-sm {
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
}

/* Override khusus untuk mode light - pastikan background tetap gelap */
@media (prefers-color-scheme: light) {
    body {
        background-color: #111827 !important;
        color: #e5e7eb !important;
    }

    .bg-gray-800 {
        background-color: #1f2937 !important;
    }
}

/* Styling untuk tag yang dipilih */
#selectedTags div {
    background-color: #dbeafe !important;
    color: #1e40af !important;
}

/* Hover effects untuk tombol toolbar */
.hover\:bg-gray-100:hover {
    background-color: #f3f4f6 !important;
}

/* Transition smooth */
.transition-colors {
    transition: background-color 0.2s ease, color 0.2s ease;
}
</style>

@push('scripts')
<script>
    // Fungsi untuk hashtag
    const tagInput = document.getElementById('tagInput');
    const selectedTags = document.getElementById('selectedTags');
    const hiddenTagsInput = document.getElementById('tags');
    let tagsArray = [];

    tagInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ',') {
            e.preventDefault();
            const tagText = this.value.trim();
            if (tagText) {
                const formattedTag = tagText.startsWith('#') ? tagText : '#' + tagText;
                addTag(formattedTag);
                this.value = '';
                updateHiddenTags();
            }
        }
    });

    document.querySelectorAll('.tag-suggestion').forEach(button => {
        button.addEventListener('click', function() {
            const tagText = this.textContent;
            if (!tagExists(tagText)) {
                addTag(tagText);
                updateHiddenTags();
            }
        });
    });

    function addTag(tagText) {
        if (tagText && !tagExists(tagText)) {
            tagsArray.push(tagText);
            const tagElement = document.createElement('div');
            tagElement.className = 'flex items-center bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-sm transition-colors';
            tagElement.innerHTML = `
                ${tagText}
                <button type="button" class="ml-2 text-blue-400 hover:text-blue-600">
                    <i class="fas fa-times text-xs"></i>
                </button>
            `;
            tagElement.querySelector('button').addEventListener('click', function() {
                tagsArray = tagsArray.filter(tag => tag !== tagText);
                tagElement.remove();
                updateHiddenTags();
            });
            selectedTags.appendChild(tagElement);
        }
    }

    function tagExists(tagText) {
        return tagsArray.includes(tagText);
    }

    function updateHiddenTags() {
        hiddenTagsInput.value = tagsArray.join(',');
    }
</script>
@endpush
@endsection
