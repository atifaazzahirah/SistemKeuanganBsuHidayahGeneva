@extends('layouts.app')

@section('title', 'Tambah Jenis Sampah')

@section('content')
<h1 class="h3 mb-3">Tambah Jenis Sampah</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('jenissampah.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="jenis_sampah" class="form-label">
            Jenis Sampah <span class="text-danger">*</span>
        </label>
        <input type="text"
               name="jenis_sampah"
               id="jenis_sampah"
               class="form-control @error('jenis_sampah') is-invalid @enderror"
               value="{{ old('jenis_sampah') }}"
               placeholder="Contoh: Plastik, Kertas, Logam"
               required>
    </div>

    <div class="mb-3">
        <label for="harga_kg" class="form-label">
            Harga per Kg <span class="text-danger">*</span>
        </label>
        <input type="number"
               step="0.01"
               min="0"
               name="harga_kg"
               id="harga_kg"
               class="form-control @error('harga_kg') is-invalid @enderror"
               value="{{ old('harga_kg') }}"
               placeholder="Contoh: 2500"
               required>
</div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('jenissampah.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
