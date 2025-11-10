<form action="{{ route('threads.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label>Kategori</label>
        <select name="category_id" class="form-control" required>
            <option value="" disabled selected>Pilih Kategori</option>
            @foreach(\App\Models\Category::all() as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>
    <!-- input judul dan body Pertanyaan -->
    <button type="submit" class="btn btn-primary">Kirim Pertanyaan</button>
</form>
