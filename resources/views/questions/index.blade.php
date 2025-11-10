@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Header and Create Pertanyaan Button -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Forum Diskusi</h2>
            <a href="{{ route('questions.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition duration-200">
                Buat Pertanyaan Baru
            </a>
        </div>

        <!-- Search Form -->
        <form action="{{ route('questions.search') }}" method="GET" class="mb-6 flex">
            <input type="text" name="q"
                class="flex-grow border border-gray-300 rounded-l-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Cari thread..." value="{{ request('q') ?? ($keyword ?? '') }}">
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-r-md transition duration-200"
                type="submit">
                Cari
            </button>
        </form>

        @if (isset($keyword) && $keyword)
            <div class="mb-4">
                <span class="font-semibold">Hasil pencarian untuk:</span>
                <span class="text-blue-600">{{ $keyword }}</span>
            </div>
        @endif

        @if (isset($filter_info))
            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-4 rounded relative">
                <div class="flex justify-between items-center">
                    <div>
                        <span class="font-semibold">Filter:</span> {{ $filter_info }}
                    </div>
                    <a href="{{ route('questions.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        Reset Filter
                    </a>
                </div>
            </div>
        @endif

        <!-- Filter Tabs -->
        <div class="flex space-x-2 mb-6">
            <a href="{{ route('questions.index', ['sort' => 'recent']) }}"
                class="px-4 py-2 rounded-md {{ ($sort ?? 'recent') == 'recent' ? 'bg-red-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Pertanyaan Terbaru
            </a>
            <a href="{{ route('questions.index', ['sort' => 'most_answered']) }}"
                class="px-4 py-2 rounded-md {{ ($sort ?? '') == 'most_answered' ? 'bg-red-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Respon Terbanyak
            </a>
            <a href="{{ route('questions.index', ['sort' => 'unanswered']) }}"
                class="px-4 py-2 rounded-md {{ ($sort ?? '') == 'unanswered' ? 'bg-red-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Belum Dijawab
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if (session('info'))
            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-6 rounded">
                {{ session('info') }}
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Main Content -->
            <div class="lg:w-2/3">
                @forelse($questions as $question)
                    <div class="bg-white rounded-lg shadow-md mb-4 overflow-hidden hover:shadow-lg transition duration-200">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold mb-2">
                                <a href="{{ route('questions.show', $question->id) }}"
                                    class="text-blue-600 hover:text-blue-800">
                                    {{ $question->title }}
                                </a>
                            </h3>

                            <div class="flex flex-wrap gap-2 mb-3">
                                <!-- Category Badge -->
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                    {{ $question->category->name ?? '-' }}
                                </span>

                                <!-- Tags -->
                                @foreach ($question->hashtags as $tag)
                                    <a href="{{ route('questions.byTag', $tag->name) }}"
                                        class="bg-gray-800 text-white text-xs font-medium px-2.5 py-0.5 rounded hover:bg-gray-700">
                                        {{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>

                            <div class="text-sm text-gray-500 mb-3">
                                Ditanya oleh:
                                <a href="{{ route('users.show', $question->user->id) }}"
                                    class="text-blue-600 hover:text-blue-800">
                                    {{ $question->user->name }}
                                </a>
                                &middot; {{ $question->created_at->diffForHumans() }}
                            </div>

                            <div class="flex items-center text-sm text-gray-600">
                                <div class="flex items-center mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    {{ $question->comments->count() }} komentar
                                </div>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                    </svg>
                                    {{ $question->likes->count() }} like
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-lg shadow-md p-6 text-center text-gray-500">
                        Tidak ada Pertanyaan yang ditemukan.
                    </div>
                @endforelse

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $questions->appends(request()->query())->links() }}
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:w-1/3 space-y-4">
                <!-- Forum Statistics -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gray-800 text-white px-4 py-3">
                        <h3 class="font-semibold">Statistik Forum</h3>
                    </div>
                    <div class="p-4 space-y-2">
                        <div class="flex justify-between">
                            <span>Total Pertanyaan:</span>
                            <span class="font-medium">{{ $stat['total_questions'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Total Komentar:</span>
                            <span class="font-medium">{{ $stat['total_comments'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Total User:</span>
                            <span class="font-medium">{{ $stat['total_users'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Total Like:</span>
                            <span class="font-medium">{{ $stat['total_likes'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- Top Askers -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gray-800 text-white px-4 py-3">
                        <h3 class="font-semibold">Top Penanya</h3>
                    </div>
                    <div class="p-4">
                        <ol class="list-decimal list-inside space-y-2">
                            @foreach ($top_users as $user)
                                <li class="hover:bg-gray-50 p-1 rounded">
                                    <span class="font-medium">{{ $user->name }}</span>
                                    <span class="text-sm text-gray-500">({{ $user->questions_count }} Pertanyaan)</span>
                                </li>
                            @endforeach
                        </ol>
                    </div>
                </div>

                <!-- Top Liked Users -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gray-800 text-white px-4 py-3">
                        <h3 class="font-semibold">Top User Berdasarkan Like</h3>
                    </div>
                    <div class="p-4">
                        <ol class="list-decimal list-inside space-y-2">
                            @foreach ($top_liked_users as $user)
                                <li class="hover:bg-gray-50 p-1 rounded">
                                    <span class="font-medium">{{ $user->name }}</span>
                                    <span class="text-sm text-gray-500">({{ $user->questions->sum('likes_count') }}
                                        like)</span>
                                </li>
                            @endforeach
                        </ol>
                    </div>
                </div>

                <!-- Popular Hashtags -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gray-800 text-white px-4 py-3">
                        <h3 class="font-semibold">Hashtag Populer</h3>
                    </div>
                    <div class="p-4 flex flex-wrap gap-2">
                        @foreach ($hashtags as $tag)
                            <a href="{{ route('questions.byTag', $tag->name) }}"
                                class="bg-gray-800 text-white text-xs font-medium px-2.5 py-1 rounded hover:bg-gray-700 transition duration-200">
                                {{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
