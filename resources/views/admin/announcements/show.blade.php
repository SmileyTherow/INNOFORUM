@extends('layouts.admin.admin')

@section('content')
    <h2>{{ $announcement->title }}</h2>
    <div class="mb-3">
        {!! nl2br(e($announcement->content)) !!}
    </div>
    @if($announcement->file ?? false)
        @php
            $ext = pathinfo($announcement->file, PATHINFO_EXTENSION);
        @endphp
        @if(in_array($ext, ['jpg', 'jpeg', 'png', 'gif']))
            <img src="{{ asset('storage/'.$announcement->file) }}" class="mb-3 w-full max-w-md" alt="File Pengumuman">
        @else
            <a href="{{ asset('storage/'.$announcement->file) }}" target="_blank" class="btn btn-info">
                Download File
            </a>
        @endif
    @endif
    <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary mt-3">Kembali</a>
@endsection