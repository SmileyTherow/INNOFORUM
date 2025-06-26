@extends('layouts.admin.admin')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mt-4 mb-2">Tables</h1>
    <ol class="mb-4 text-gray-500 flex space-x-2">
        <li><a href="{{ route('admin.dashboard') }}" class="hover:underline">Dashboard</a></li>
    </ol>
    <div class="mb-4 bg-white border border-gray-300 rounded-lg p-4">
        <p class="text-gray-700 mb-2"><b>DataTables Example</b></p>
        @livewire('admin.user-table')
    </div>
</div>
@endsection