@extends('layouts.app')

@section('title', 'Detail Nasabah')

@section('content')
<h1 class="h3 mb-3">Detail Nasabah</h1>

<div class="card">
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Nama</dt>
            <dd class="col-sm-9">{{ $nasabah->Nama }}</dd>

            <dt class="col-sm-3">No Induk</dt>
            <dd class="col-sm-9">{{ $nasabah->No_Induk }}</dd>

            <dt class="col-sm-3">Alamat</dt>
            <dd class="col-sm-9">{{ $nasabah->Alamat }}</dd>

            <dt class="col-sm-3">No HP</dt>
            <dd class="col-sm-9">{{ $nasabah->No_HP }}</dd>

            <dt class="col-sm-3">Total Saldo</dt>
            <dd class="col-sm-9">{{ number_format($nasabah->Total_Saldo, 0, ',', '.') }}</dd>

            <dt class="col-sm-3">Jumlah KK</dt>
            <dd class="col-sm-9">{{ $nasabah->jml_kk }}</dd>
        </dl>
    </div>
</div>

<a href="{{ route('nasabah.index') }}" class="btn btn-secondary mt-3">Kembali</a>
@endsection
