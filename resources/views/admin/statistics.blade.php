@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Statistik Forum</h1>
    <p>Total Pengguna: {{ $userCount }}</p>
    <p>Total Diskusi: {{ $discussionCount }}</p>
    <p>Total Komentar: {{ $commentCount }}</p>
    <h2>Hashtag Populer</h2>
    <ul>
        @foreach ($popularHashtags as $hashtag)
            <li>{{ $hashtag->name }} ({{ $hashtag->discussions_count }} diskusi)</li>
        @endforeach
    </ul>
</div>
@endsection