@extends('layouts.app')

@section('title', $event->title ?? 'Detail Kegiatan')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-2">{{ $event->title }}</h1>
        <div class="text-sm text-gray-600 mb-4">
            {{ $event->start_date?->toDateString() }}{{ $event->end_date && $event->end_date != $event->start_date ? ' - ' . $event->end_date->toDateString() : '' }}
        </div>
        @if($event->description)
            <p class="text-gray-700 leading-relaxed">{{ $event->description }}</p>
        @else
            <p class="text-gray-500">Tidak ada deskripsi.</p>
        @endif
        <div class="mt-4">
            <a href="{{ route('calendar.index') }}" class="text-blue-600 hover:underline">Kembali ke Kalender</a>
        </div>
    </div>
</div>
@endsection
