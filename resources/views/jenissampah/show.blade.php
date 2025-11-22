@extends('layouts.app')

@section('title', 'Detail Jenis Sampah')

@section('content')
<h1 class="h3 mb-3">Detail Jenis Sampah</h1>

<div class="card">
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">ID Jenis</dt>
            <dd class="col-sm-9">{{ $jenis_sampah->ID_Jenis }}</dd>

            <dt class="col-sm-3">Jenis Sampah</dt>
            <dd class="col-sm-9">{{ $jenis_sampah->Jenis_Sampah }}</dd>

            <dt class="col-sm-3">Harga per Kg</dt>
            <dd class="col-sm-9">
                {{ number_format($jenis_sampah->Harga_kg, 0, ',', '.') }}
            </dd>
        </dl>
    </div>
</div>

<a href="{{ route('jenissampah.index') }}" class="btn btn-secondary mt-3">Kembali</a>
@endsection
