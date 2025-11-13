@extends('layouts.admin.admin')

@section('title', 'Activity Admin')

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-gray-900">Activity Admin</h1>
            <a href="{{ route('admin.dashboard') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                Kembali ke Dashboard
            </a>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b">
                <p class="text-sm text-gray-500">Catatan kegiatan semua admin. Gunakan filter/ pencarian jika perlu.</p>
            </div>

            <div class="px-4 py-4 sm:p-6">
                @if ($activities->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        #</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Admin</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Activity</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Target</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        IP</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Waktu</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($activities as $activity)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $loop->iteration + ($activities->currentPage() - 1) * $activities->perPage() }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ optional($activity->admin)->name ?? ($activity->admin_name ?? '—') }}
                                            @if (optional($activity->admin)->email)
                                                <div class="text-xs text-gray-500">{{ optional($activity->admin)->email }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-normal text-sm text-gray-700">
                                            {{ $activity->description ?? ($activity->action ?? '—') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            @if ($activity->target_type || $activity->target_id)
                                                {{ class_basename($activity->target_type ?? '') }}
                                                {{ $activity->target_id ? '#' . $activity->target_id : '' }}
                                            @else
                                                —
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            {{ $activity->ip_address ?? '—' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $activity->created_at ? $activity->created_at->format('Y-m-d H:i:s') : '—' }}
                                            <div class="text-xs text-gray-400">
                                                {{ $activity->created_at ? $activity->created_at->diffForHumans() : '' }}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $activities->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <p class="text-gray-500">Belum ada aktivitas admin.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
