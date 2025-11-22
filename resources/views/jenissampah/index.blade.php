@extends('layouts.app')

@section('title', 'Jenis Sampah')

@section('content')
<div class="container-fluid">   {{-- INI KUNCI AGAR LEBAR PENUH --}}
    <h1 class="h3 mb-3">Jenis Sampah</h1>

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('jenissampah.create') }}" class="btn btn-primary">
            + Tambah Jenis Sampah
        </a>
    </div>

    <div class="card w-100">   {{-- PAKSA FULL WIDTH --}}
        <div class="card-body p-0">
            @if ($jenis_sampah->isEmpty())
                <div class="alert alert-info m-3">
                    Belum ada jenis sampah.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Jenis Sampah</th>
                                <th>Harga per Kg</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($jenis_sampah as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->Jenis_Sampah }}</td>
                                    <td>{{ number_format($item->Harga_kg, 0, ',', '.') }}</td>
                                    <td>
                                        <a href="{{ route('jenissampah.show', $item->ID_Jenis) }}"
                                           class="btn btn-info btn-sm">Detail</a>

                                        <a href="{{ route('jenissampah.edit', $item->ID_Jenis) }}"
                                           class="btn btn-warning btn-sm">Edit</a>

                                        <form action="{{ route('jenissampah.destroy', $item->ID_Jenis) }}"
                                              method="POST"
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Yakin ingin menghapus?')">
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
        </div>
    </div>
</div>
@endsection
