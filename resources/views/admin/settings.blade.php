@extends('layouts.admin.admin')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Pengaturan Profil Admin</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3 text-center">
                            @if($admin->photo)
                                <img src="{{ asset('storage/photo/' . $admin->photo) }}"
                                    class="img-thumbnail rounded-circle mb-2"
                                    style="width: 110px; height: 110px; object-fit: cover;">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($admin->name) }}&size=110"
                                    class="img-thumbnail rounded-circle mb-2"
                                    style="width: 110px; height: 110px; object-fit: cover;">
                            @endif
                            <div>
                                <input type="file" class="form-control mt-2" name="photo" accept="image/*">
                                <small class="text-muted">Maksimal 2MB, format: jpg, jpeg, png</small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name', $admin->name) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="{{ old('email', $admin->email) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Bio</label>
                            <textarea class="form-control" name="bio" rows="3">{{ old('bio', $admin->bio) }}</textarea>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <a href="{{ route('admin.reset-password.show') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-key"></i> Reset Password
                            </a>
                        </div>
                    </form>
                </div>
            </div> <!-- card -->
        </div>
    </div>
</div>
@endsection