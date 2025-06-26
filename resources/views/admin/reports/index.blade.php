@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Daftar Laporan User</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Reporter</th>
                <th>Target</th>
                <th>Alasan</th>
                <th>Deskripsi</th>
                <th>Status</th>
                <th>Pesan Admin</th>
                <th>Update</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($reports) && count($reports))
                @foreach($reports as $rp)
                <tr>
                    <td>{{ $rp->reporter->name }}</td>
                    <td>
                        @if($rp->question)
                            [Pertanyaan] {{ $rp->question->title }}
                        @elseif($rp->comment)
                            [Komentar] {{ Str::limit($rp->comment->content, 40) }}
                        @endif
                    </td>
                    <td>{{ $rp->reason }}</td>
                    <td>{{ $rp->description }}</td>
                    <td>{{ $rp->status }}</td>
                    <td>
                        @if($rp->admin_message)
                            <span class="text-danger">{{ $rp->admin_message }}</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('admin.reports.update', $rp->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="form-select form-select-sm" required>
                                <option value="pending" {{ $rp->status=='pending'?'selected':'' }}>Pending</option>
                                <option value="reviewed" {{ $rp->status=='reviewed'?'selected':'' }}>Reviewed (Peringatan)</option>
                                <option value="ignored" {{ $rp->status=='ignored'?'selected':'' }}>Ignored</option>
                                <option value="resolved" {{ $rp->status=='resolved'?'selected':'' }}>Resolved</option>
                            </select>
                            <textarea name="admin_message" class="form-control form-control-sm mt-1" placeholder="Pesan peringatan untuk user (opsional)">{{ old('admin_message', $rp->admin_message) }}</textarea>
                            <button class="btn btn-sm btn-primary mt-1">Update</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7" class="text-center">Tidak ada laporan.</td>
                </tr>
            @endif
        </tbody>
    </table>
    {{ $reports->links() }}
</div>
@endsection