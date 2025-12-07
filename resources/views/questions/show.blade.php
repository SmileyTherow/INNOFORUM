@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <!-- Header Pertanyaan -->
        <div class="bg-gray-800 rounded-lg shadow-lg p-6 mb-6 border border-gray-700">
            <h1 class="text-3xl font-bold text-white mb-2">{{ $question->title }}</h1>
            <div class="flex items-center text-sm text-gray-300 mb-4">
                <span>
                    <span
                        class="inline-block px-2 py-1 bg-blue-500/20 text-blue-300 rounded-full font-semibold text-xs border border-blue-500/30">
                        {{ $question->category->name ?? '-' }}
                    </span>
                </span>
                <span class="mx-2">•</span>
                <span>
                    Oleh:
                    @include('components.user-mini-profile', ['user' => $question->user])
                </span>
                <span class="mx-2">•</span>
                <span>{{ $question->created_at->diffForHumans() }}</span>
            </div>

            <div class="prose max-w-none text-gray-300 mb-6">
                {{ $question->content }}
            </div>

            <!-- Tombol Aksi -->
            <div class="flex flex-wrap items-center gap-3 border-t border-gray-600 pt-4">
                <!-- Tombol Like -->
                <form action="{{ route('questions.like', $question->id) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="flex items-center px-4 py-2 bg-blue-500/20 text-blue-300 rounded-full text-sm hover:bg-blue-500/30 transition border border-blue-500/30"
                        {{ auth()->check() && $question->likes->contains(auth()->user()->id) ? 'disabled' : '' }}>
                        <span>👍</span>
                        <span class="ml-1">Like ({{ $question->likes->count() }})</span>
                    </button>
                </form>

                @if (auth()->check() && $question->likes->contains(auth()->user()->id))
                    <span class="text-sm text-green-400">✓ Kamu sudah like</span>
                @endif

                <!-- Tombol Laporkan -->
                @auth
                    <button type="button" onclick="showReportModal('question', {{ $question->id }})"
                        class="flex items-center px-4 py-2 bg-red-500/20 text-red-300 rounded-full text-sm hover:bg-red-500/30 transition border border-red-500/30">
                        <span>⚠️</span>
                        <span class="ml-1">Laporkan</span>
                    </button>
                @endauth

                <!-- Edit/Hapus (Hanya Pemilik) -->
                @if (Auth::id() == $question->user_id)
                    <div class="flex gap-2 ml-auto">
                        <a href="{{ route('questions.edit', $question->id) }}"
                            class="px-4 py-2 bg-yellow-500/20 text-yellow-300 rounded-full text-sm hover:bg-yellow-500/30 transition border border-yellow-500/30">✏️
                            Edit</a>
                        <form action="{{ route('questions.destroy', $question->id) }}" method="POST"
                            onsubmit="return confirm('Yakin hapus Pertanyaan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-4 py-2 bg-red-500/20 text-red-300 rounded-full text-sm hover:bg-red-500/30 transition border border-red-500/30">🗑️
                                Hapus</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>

        <!-- Seksi Komentar -->
        <div class="bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-700">
            <h3 class="text-2xl font-semibold text-white mb-4">💬 Komentar ({{ $question->comments->count() }})</h3>

            @foreach ($question->comments as $comment)
                <div id="comment-{{ $comment->id }}" class="comment-item">
                    <div class="border-b border-gray-600 pb-4 mb-4 last:border-0">
                        <div class="flex justify-between items-start mb-2">
                            <div class="font-medium text-white">
                                @include('components.user-mini-profile', ['user' => $comment->user])
                                <div class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</div>
                            </div>
                        </div>

                        <p class="text-gray-300 mb-3">{{ $comment->content }}</p>

                        <!-- Aksi Komentar -->
                        <div class="flex flex-wrap items-center gap-2 text-sm">
                            <!-- Like Komentar -->
                            <form action="{{ route('comments.like', $comment->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="flex items-center text-blue-400 hover:text-blue-300"
                                    {{ auth()->check() && $comment->likes->contains(auth()->user()->id) ? 'disabled' : '' }}>
                                    <span>👍</span>
                                    <span class="ml-1">({{ $comment->likes->count() }})</span>
                                </button>
                            </form>

                            @if (auth()->check() && $comment->likes->contains(auth()->user()->id))
                                <span class="text-green-400 text-xs">✓ Liked</span>
                            @endif

                            <!-- Laporkan Komentar -->
                            @auth
                                <button type="button" onclick="showReportModal('comment', {{ $comment->id }})"
                                    class="text-red-400 hover:text-red-300 flex items-center text-xs">
                                    <span>⚠️ Laporkan</span>
                                </button>
                            @endauth

                            <!-- Edit/Hapus (Hanya Pemilik) -->
                            @if (Auth::id() == $comment->user_id)
                                <div class="flex gap-2 ml-auto">
                                    <a href="{{ route('comments.edit', $comment->id) }}"
                                        class="text-yellow-400 hover:text-yellow-300">✏️ Edit</a>
                                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin hapus komentar?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300">🗑️ Hapus</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
            @endforeach

            <!-- Form Komentar Baru -->
            <div class="mt-6">
                <h4 class="text-lg font-medium text-white mb-3">✍️ Tambah Komentar</h4>

                @auth
                    @if (in_array(auth()->user()->role, ['mahasiswa', 'dosen']))
                        <form action="{{ route('comments.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="question_id" value="{{ $question->id }}">

                            <div class="mb-4">
                                <textarea name="content" rows="3"
                                    class="w-full px-4 py-2 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-700 text-white placeholder-gray-400"
                                    placeholder="Tulis komentarmu..." required></textarea>
                                @error('content')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-300 mb-1">Upload Gambar (Opsional)</label>
                                <input type="file" name="image"
                                    class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-500/20 file:text-blue-300 hover:file:bg-blue-500/30">
                                @error('image')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-3 px-4 rounded-lg transition duration-200 transform hover:scale-[1.02] shadow-lg">
                                Kirim Komentar
                            </button>
                        </form>
                    @else
                        <div class="bg-yellow-500/20 border-l-4 border-yellow-400 p-4 mb-4">
                            <div class="flex">
                                <div class="text-yellow-300">⚠️ Hanya mahasiswa/dosen yang bisa berkomentar</div>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="bg-blue-500/20 border-l-4 border-blue-400 p-4">
                        <div class="flex">
                            <div>
                                <p class="text-blue-300">🔒 Silakan <a href="{{ route('login') }}"
                                        class="font-medium underline hover:text-blue-200">login</a> untuk memberi komentar</p>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <!-- Modal Form Laporan Sidebar Modern, Selalu di Atas Navbar -->
    <div id="reportModal" class="hidden z-[9999]">
        <!-- Sidebar Modal -->
        <div class="fixed right-0 top-0 h-screen max-w-md w-full bg-gray-900 shadow-2xl border-l border-gray-700 flex flex-col overflow-y-auto"
            style="z-index:9999;">
            <!-- Sticky Header -->
            <div class="sticky top-0 z-10 bg-gray-900 border-b border-gray-700 px-6 py-5">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            Laporkan Konten
                        </h3>
                        <p class="mt-1 text-sm text-gray-400">Bantu kami menjaga komunitas tetap aman</p>
                    </div>
                    <button type="button" onclick="closeReportModal()"
                        class="rounded-lg p-2 text-gray-400 hover:bg-gray-800 hover:text-white transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <!-- Form Content -->
            <div class="p-6 flex-1">
                <form method="POST" action="{{ route('report.store') }}" id="reportForm">
                    @csrf
                    <input type="hidden" name="question_id" id="modal-question-id">
                    <input type="hidden" name="comment_id" id="modal-comment-id">

                    <!-- Reason Selection -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Alasan Laporan <span
                                class="text-red-500">*</span></label>
                        <select name="reason" id="reasonSelect" required
                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition">
                            <option value="" selected disabled>Pilih alasan pelaporan</option>
                            <option value="spam">Spam atau Iklan</option>
                            <option value="harassment">Kata-kata Kasar atau Pelecehan</option>
                            <option value="misinformation">Informasi Palsu atau Menyesatkan</option>
                            <option value="inappropriate">Konten Tidak Pantas</option>
                            <option value="copyright">Pelanggaran Hak Cipta</option>
                            <option value="other">Lainnya</option>
                        </select>
                        <p class="mt-2 text-xs text-gray-400">Pilih alasan utama untuk melaporkan konten ini</p>
                    </div>
                    <!-- Custom Reason (Hidden by default) -->
                    <div id="customReasonContainer" class="mb-6 hidden">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Jelaskan alasan Anda <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="custom_reason" id="custom_reason"
                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition"
                            placeholder="Tuliskan alasan pelaporan...">
                    </div>
                    <!-- Description -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Deskripsi Tambahan <span
                                class="text-xs text-gray-400 font-normal">(Opsional)</span></label>
                        <textarea name="description" rows="4" id="descriptionTextarea"
                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition resize-none"
                            placeholder="Jelaskan secara detail mengapa konten ini perlu dilaporkan..."></textarea>
                        <div class="flex justify-between mt-2">
                            <p class="text-xs text-gray-400">Maksimal 500 karakter</p>
                            <span id="charCount" class="text-xs text-gray-400">0/500</span>
                        </div>
                    </div>
                    <!-- Confirmation Checkbox -->
                    <div class="mb-6 p-4 rounded-lg bg-gray-800 border border-gray-700">
                        <label class="flex items-start">
                            <input type="checkbox" name="confirm_report" id="confirmCheckbox" required
                                class="mt-1 h-5 w-5 rounded border-gray-600 bg-gray-800 text-red-500 focus:ring-red-500">
                            <span class="ml-3 text-sm text-gray-300">
                                Saya yakin konten ini melanggar pedoman komunitas.
                                <span class="block text-xs text-gray-400 mt-1">Laporan yang tidak benar dapat berakibat
                                    sanksi.</span>
                            </span>
                        </label>
                    </div>
                    <!-- Footer Buttons -->
                    <div class="sticky bottom-0 bg-gray-900 pt-6 pb-4 border-t border-gray-700">
                        <div class="flex gap-3">
                            <button type="button" onclick="closeReportModal()"
                                class="flex-1 px-4 py-3 rounded-lg border border-gray-700 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors font-medium">
                                Batal
                            </button>
                            <button type="submit" id="submitReportBtn"
                                class="flex-1 px-4 py-3 rounded-lg bg-red-600 text-white hover:bg-red-700 transition-all font-medium shadow-lg shadow-red-900/30 disabled:opacity-50 disabled:cursor-not-allowed"
                                disabled>
                                <span class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                    </svg>
                                    Kirim Laporan
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        // Fungsi untuk membuka modal
        function showReportModal(type, id) {
            const modal = document.getElementById('reportModal');
            if (type === 'question') {
                document.getElementById('modal-question-id').value = id;
                document.getElementById('modal-comment-id').value = '';
            } else {
                document.getElementById('modal-question-id').value = '';
                document.getElementById('modal-comment-id').value = id;
            }
            // Reset form
            const form = document.getElementById('reportForm');
            if (form) form.reset();
            // Reset UI states
            document.getElementById('customReasonContainer').classList.add('hidden');
            document.getElementById('submitReportBtn').disabled = true;
            document.getElementById('charCount').textContent = '0/500';
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            document.addEventListener('keydown', handleEscapeKey);
        }

        function closeReportModal() {
            const modal = document.getElementById('reportModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            document.removeEventListener('keydown', handleEscapeKey);
        }

        function handleEscapeKey(event) {
            if (event.key === 'Escape') closeReportModal();
        }
        document.addEventListener('DOMContentLoaded', function() {
            const textarea = document.getElementById('descriptionTextarea');
            const charCount = document.getElementById('charCount');
            const reasonSelect = document.getElementById('reasonSelect');
            const customReasonContainer = document.getElementById('customReasonContainer');
            const customReasonInput = document.getElementById('custom_reason');
            const submitBtn = document.getElementById('submitReportBtn');
            const confirmCheckbox = document.getElementById('confirmCheckbox');
            const form = document.getElementById('reportForm');
            // Character counter
            if (textarea && charCount) {
                textarea.addEventListener('input', function() {
                    const length = this.value.length;
                    charCount.textContent = `${length}/500`;
                    if (length > 500) {
                        charCount.classList.add('text-red-500');
                        this.classList.add('border-red-500');
                    } else {
                        charCount.classList.remove('text-red-500');
                        this.classList.remove('border-red-500');
                    }
                    validateForm();
                });
            }
            // Toggle custom reason input
            if (reasonSelect) {
                reasonSelect.addEventListener('change', function() {
                    if (this.value === 'other') {
                        customReasonContainer.classList.remove('hidden');
                        customReasonInput.required = true;
                    } else {
                        customReasonContainer.classList.add('hidden');
                        customReasonInput.required = false;
                    }
                    validateForm();
                });
            }
            if (customReasonInput) customReasonInput.addEventListener('input', validateForm);

            function validateForm() {
                let isValid = !!reasonSelect.value;
                if (reasonSelect.value === 'other' && !customReasonInput.value.trim()) isValid = false;
                if (!confirmCheckbox.checked) isValid = false;
                submitBtn.disabled = !isValid;
                return isValid;
            }
            if (confirmCheckbox) confirmCheckbox.addEventListener('change', validateForm);
            if (form) form.addEventListener('submit', function(e) {
                if (!validateForm()) {
                    e.preventDefault();
                    return;
                }
                submitBtn.disabled = true;
                submitBtn.innerHTML = `<span class="flex items-center justify-center">
                <svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Mengirim...
            </span>`;
                setTimeout(() => {
                    form.submit();
                }, 300);
            });
        });
    </script>

    <script>
        function showReportModal(type, id) {
            document.getElementById('modal-question-id').value = (type === 'question') ? id : '';
            document.getElementById('modal-comment-id').value = (type === 'comment') ? id : '';
            document.getElementById('reportModal').style.display = 'block';
        }

        function closeReportModal() {
            document.getElementById('reportModal').style.display = 'none';
        }
    </script>

    <style>
        /* MEMASTIKAN BACKGROUND HALAMAN TETAP GELAP */
        body {
            background-color: #111827 !important;
            color: #e5e7eb !important;
        }

        /* Override untuk semua elemen container */
        .bg-white,
        .bg-gray-50,
        .bg-gray-100 {
            background-color: #1f2937 !important;
        }

        /* Untuk card/container spesifik */
        .bg-gray-800 {
            background-color: #1f2937 !important;
        }

        .bg-gray-700 {
            background-color: #374151 !important;
        }

        .border-gray-700 {
            border-color: #374151 !important;
        }

        .border-gray-600 {
            border-color: #4b5563 !important;
        }

        /* Text colors */
        .text-gray-900,
        .text-gray-800,
        .text-gray-700,
        .text-gray-600 {
            color: #e5e7eb !important;
        }

        .text-gray-300 {
            color: #d1d5db !important;
        }

        .text-gray-400 {
            color: #9ca3af !important;
        }

        /* Shadow adjustments */
        .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.2) !important;
        }

        /* Border colors untuk komentar */
        .border-gray-200 {
            border-color: #374151 !important;
        }

        /* File input styling */
        .file\:bg-blue-50 {
            background-color: rgba(59, 130, 246, 0.2) !important;
        }

        .file\:text-blue-700 {
            color: #93c5fd !important;
        }

        .hover\:file\:bg-blue-100:hover {
            background-color: rgba(59, 130, 246, 0.3) !important;
        }

        /* Override khusus untuk mode light */
        @media (prefers-color-scheme: light) {
            body {
                background-color: #111827 !important;
                color: #e5e7eb !important;
            }

            .bg-white {
                background-color: #1f2937 !important;
            }

            .text-gray-900,
            .text-gray-800,
            .text-gray-700 {
                color: #e5e7eb !important;
            }

            /* Memastikan input tetap gelap */
            input,
            textarea {
                background-color: #374151 !important;
                color: #e5e7eb !important;
                border-color: #4b5563 !important;
            }

            input::placeholder,
            textarea::placeholder {
                color: #9ca3af !important;
            }
        }

        /* Prose styling untuk konten pertanyaan */
        .prose {
            color: #d1d5db !important;
        }

        .prose p {
            margin-bottom: 1rem;
        }

        .prose p:last-child {
            margin-bottom: 0;
        }

        /* Transisi smooth */
        .transition {
            transition: all 0.2s ease;
        }

        .transform {
            transition: transform 0.2s ease;
        }
    </style>
@endsection
