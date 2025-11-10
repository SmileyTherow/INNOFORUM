@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-blue-700">Forum Diskusi</h1>
    <a href="{{ route('tanya') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow flex items-center">
        <i class="fas fa-plus mr-2"></i> Tanya
    </a>
</div>

<!-- List Pertanyaan/Forum -->
<div class="space-y-4">
    <!-- Contoh Card Pertanyaan (ulang ini untuk setiap pertanyaan) -->
    @for ($i = 0; $i < 3; $i++)
        @include('components.thread-card')
    @endfor
</div>
@endsection
