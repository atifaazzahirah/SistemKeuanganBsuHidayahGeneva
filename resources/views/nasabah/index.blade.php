@extends('layouts.app')

@section('title', 'Data Nasabah')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3">Data Nasabah</h1>
    <a href="{{ route('nasabah.create') }}" class="btn btn-primary">+ Tambah Nasabah</a>
</div>

@if ($nasabah->isEmpty())
    <div class="alert alert-info">
        Belum ada data nasabah.
    </div>
@else
    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>No Induk</th>
                    <th>Alamat</th>
                    <th>No HP</th>
                    <th>Total Saldo</th>
                    <th>Jumlah KK</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($nasabah as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->Nama }}</td>
                        <td>{{ $item->No_Induk }}</td>
                        <td>{{ $item->Alamat }}</td>
                        <td>{{ $item->No_HP }}</td>
                        <td>{{ number_format($item->Total_Saldo, 0, ',', '.') }}</td>
                        <td>{{ $item->jml_kk }}</td>
                        <td>
                            {{-- DETAIL --}}
                            <a href="{{ route('nasabah.show', ['nasabah' => $item->ID_Nasabah]) }}"
                               class="btn btn-sm btn-info">
                                Detail
                            </a>

                            {{-- EDIT --}}
                            <a href="{{ route('nasabah.edit', ['nasabah' => $item->ID_Nasabah]) }}"
                               class="btn btn-sm btn-warning">
                                Edit
                            </a>

                            {{-- DELETE --}}
                            <form action="{{ route('nasabah.destroy', ['nasabah' => $item->ID_Nasabah]) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin hapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" type="submit">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection
