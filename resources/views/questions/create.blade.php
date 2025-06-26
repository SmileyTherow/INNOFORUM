@extends('layouts.app')

@section('content')
<div class="flex">
    <div class="w-full p-4 md:p-8">
        <div class="max-w-3xl mx-auto bg-white dark:bg-gray-100 rounded-xl shadow-lg p-6 md:p-10 border border-gray-200">
            <h1 class="text-2xl font-bold text-center text-blue-600 mb-8">Buat Pertanyaan</h1>
            <form action="{{ route('questions.store') }}" method="POST">
                @csrf

                <!-- Judul Pertanyaan -->
                <div class="mb-6">
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Judul Pertanyaan</label>
                    <input type="text" name="title" id="title" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500" placeholder="Tulis judul pertanyaan Anda" required>
                    <p class="mt-1 text-xs text-gray-500">Buat judul yang spesifik dan jelas</p>
                </div>

                <!-- Kategori -->
                <div class="mb-6">
                    <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                    <select name="category_id" id="category_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="" disabled selected>Pilih Kategori</option>
                        @foreach(\App\Models\Category::all() as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Isi Pertanyaan -->
                <div class="mb-6">
                    <label for="content" class="block text-sm font-semibold text-gray-700 mb-2">Isi Pertanyaan</label>
                    <div class="flex flex-wrap items-center gap-3 mb-2 p-2 bg-gray-50 rounded-lg border border-gray-200">
                        <select class="text-sm border border-gray-300 rounded px-3 py-2 bg-white focus:ring-blue-500 focus:border-blue-500">
                            <option>Arial</option>
                            <option>Times New Roman</option>
                            <option>Courier New</option>
                        </select>
                        <select class="text-sm border border-gray-300 rounded px-3 py-2 bg-white focus:ring-blue-500 focus:border-blue-500 ml-2">
                            <option>Kecil</option>
                            <option selected>Normal</option>
                            <option>Besar</option>
                        </select>
                        <div class="flex flex-wrap items-center gap-2 ml-4">
                            <button type="button" class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded hover:bg-gray-200 px-2">
                                <i class="fas fa-bold text-lg"></i>
                            </button>
                            <button type="button" class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded hover:bg-gray-200 px-2">
                                <i class="fas fa-italic text-lg"></i>
                            </button>
                            <button type="button" class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded hover:bg-gray-200 px-2">
                                <i class="fas fa-underline text-lg"></i>
                            </button>
                            <button type="button" class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded hover:bg-gray-200 px-2">
                                <i class="fas fa-align-left text-lg"></i>
                            </button>
                            <button type="button" class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded hover:bg-gray-200 px-2">
                                <i class="fas fa-align-center text-lg"></i>
                            </button>
                            <button type="button" class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded hover:bg-gray-200 px-2">
                                <i class="fas fa-align-right text-lg"></i>
                            </button>
                            <button type="button" class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded hover:bg-gray-200 px-2">
                                <i class="fas fa-list-ul text-lg"></i>
                            </button>
                            <button type="button" class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded hover:bg-gray-200 px-2">
                                <i class="fas fa-list-ol text-lg"></i>
                            </button>
                        </div>
                    </div>
                    <textarea name="content" id="content" rows="8" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500" placeholder="Jelaskan pertanyaan Anda secara detail" required></textarea>
                    <p class="mt-1 text-xs text-gray-500">Sertakan semua informasi yang diperlukan untuk memahami pertanyaan Anda</p>
                </div>

                <!-- Hashtag -->
                <div class="mb-6">
                    <label for="tags" class="block text-sm font-semibold text-gray-700 mb-2">Hashtag</label>
                    <div class="flex flex-wrap gap-2 p-2 border border-gray-300 rounded-lg min-h-12 bg-white">
                        <div id="selectedTags" class="flex flex-wrap gap-2"></div>
                        <input type="text" id="tagInput" class="flex-grow outline-none px-2 bg-transparent" placeholder="Tambahkan hashtag (contoh: #matematika #fisika)">
                        <input type="hidden" name="tags" id="tags">
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Tekan Enter atau koma untuk menambahkan hashtag</p>
                    <div class="mt-3">
                        <p class="text-xs font-medium text-gray-700 mb-1">Hashtag Populer:</p>
                        <div class="flex flex-wrap gap-2">
                            <button type="button" class="tag-suggestion text-xs bg-blue-100 text-blue-600 px-3 py-1 rounded-full hover:bg-blue-200">#Jaringan</button>
                            <button type="button" class="tag-suggestion text-xs bg-blue-100 text-blue-600 px-3 py-1 rounded-full hover:bg-blue-200">#Kalkulus</button>
                            <button type="button" class="tag-suggestion text-xs bg-blue-100 text-blue-600 px-3 py-1 rounded-full hover:bg-blue-200">#PHP</button>
                            <button type="button" class="tag-suggestion text-xs bg-blue-100 text-blue-600 px-3 py-1 rounded-full hover:bg-blue-200">#programming</button>
                            <button type="button" class="tag-suggestion text-xs bg-blue-100 text-blue-600 px-3 py-1 rounded-full hover:bg-blue-200">#tugas</button>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-200 my-6"></div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 shadow">
                    Publikasikan Pertanyaan Anda
                </button>
            </form>
        </div>
    </div>
</div>

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
            tagElement.className = 'flex items-center bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-sm';
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