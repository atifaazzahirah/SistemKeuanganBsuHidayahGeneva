@extends('layouts.app')

@section('title', 'Tambah Nasabah')

@section('content')
<h1 class="h3 mb-3">Tambah Nasabah</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('nasabah.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="nama" class="form-label">Nama</label>
        <input type="text"
               name="nama"
               id="nama"
               class="form-control @error('nama') is-invalid @enderror"
               value="{{ old('nama') }}"
               required>
    </div>

    <div class="mb-3">
        <label for="no_induk" class="form-label">No Induk</label>
        <input type="text"
               name="no_induk"
               id="no_induk"
               class="form-control @error('no_induk') is-invalid @enderror"
               value="{{ old('no_induk') }}"
               required>
    </div>

    <div class="mb-3">
        <label for="alamat" class="form-label">Alamat</label>
        <textarea name="alamat"
                  id="alamat"
                  rows="3"
                  class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat') }}</textarea>
    </div>

    <div class="mb-3">
        <label for="no_hp" class="form-label">No HP</label>
        <input type="text"
               name="no_hp"
               id="no_hp"
               class="form-control @error('no_hp') is-invalid @enderror"
               value="{{ old('no_hp') }}">
    </div>

    <div class="mb-3">
        <label for="total_saldo" class="form-label">Total Saldo</label>
        <input type="number"
               step="0.01"
               name="total_saldo"
               id="total_saldo"
               class="form-control @error('total_saldo') is-invalid @enderror"
               value="{{ old('total_saldo', 0) }}">
    </div>

    <div class="mb-3">
        <label for="jml_kk" class="form-label">Jumlah KK</label>
        <input type="number"
               name="jml_kk"
               id="jml_kk"
               class="form-control @error('jml_kk') is-invalid @enderror"
               value="{{ old('jml_kk') }}">
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('nasabah.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
