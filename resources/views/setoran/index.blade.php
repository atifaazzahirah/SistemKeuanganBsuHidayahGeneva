@extends('layouts.app')
@section('title', 'Data Setoran Sampah')

{{-- Load CSS --}}
<link rel="stylesheet" href="{{ asset('css/setoran_index.css') }}">

@section('content')
<div class="setoran-index-container">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="setoran-header-title">
                <i class="fas fa-recycle me-3"></i>Data Setoran Sampah
            </h1>
            <a href="{{ route('setoran.create') }}" class="btn btn-success btn-lg shadow-lg">
                <i class="fas fa-plus-circle me-2"></i> Input Setoran Baru
            </a>
        </div>
<div class="card shadow-sm p-4 mb-4">
    <form method="GET" action="{{ route('setoran.index') }}" class="row g-3">
        
        <div class="col-md-4">
            <label class="form-label fw-bold">Cari Nama Nasabah</label>
            <input type="text" name="keyword" class="form-control"
                   placeholder="Masukkan nama..."
                   value="{{ request('keyword') }}">
        </div>

        <div class="col-md-3">
            <label class="form-label fw-bold">Tanggal Awal</label>
            <input type="date" name="tanggal_awal" class="form-control"
                   value="{{ request('tanggal_awal') }}">
        </div>

        <div class="col-md-3">
            <label class="form-label fw-bold">Tanggal Akhir</label>
            <input type="date" name="tanggal_akhir" class="form-control"
                   value="{{ request('tanggal_akhir') }}">
        </div>

        <div class="col-md-2 d-flex align-items-end">
            <button class="btn btn-success w-100">
                <i class="fas fa-search me-2"></i> Cari
            </button>
        </div>

        <div class="col-md-3 d-flex align-items-end">
            <a href="{{ route('setoran.index') }}" class="btn btn-secondary w-100">
                Reset
            </a>
        </div>
    </form>

    <hr>

    <!-- EXPORT PDF -->
<form method="GET" action="{{ route('setoran.export.pdf') }}" class="row g-3">
    <div class="row">

        <!-- PILIH FILTER -->
        <div class="col-md-3">
            <label>Pilih Filter</label>
            <select name="filter" id="filter" class="form-control" required>
                <option value="all">Semua Data</option>
                <option value="single">1 Tanggal</option>
                <option value="range">Range Tanggal</option>
            </select>
        </div>

        <!-- SINGLE DATE -->
        <div class="col-md-3" id="single-date" style="display:none;">
            <label>Pilih Tanggal</label>
            <input type="date" name="tanggal" class="form-control">
        </div>

        <!-- RANGE DATE -->
        <div class="col-md-3" id="range-start" style="display:none;">
            <label>Tanggal Mulai</label>
            <input type="date" name="start_date" class="form-control">
        </div>

        <div class="col-md-3" id="range-end" style="display:none;">
            <label>Tanggal Sampai</label>
            <input type="date" name="end_date" class="form-control">
        </div>

        <div class="col-md-3">
            <label>&nbsp;</label>
            <button type="submit" class="btn btn-danger form-control">
                Export PDF
            </button>
        </div>

    </div>
</form>

<script>
    document.getElementById('filter').addEventListener('change', function () {
        let val = this.value;

        document.getElementById('single-date').style.display = 'none';
        document.getElementById('range-start').style.display = 'none';
        document.getElementById('range-end').style.display = 'none';

        if (val === 'single') {
            document.getElementById('single-date').style.display = 'block';
        }

        if (val === 'range') {
            document.getElementById('range-start').style.display = 'block';
            document.getElementById('range-end').style.display = 'block';
        }
    });
</script>

</div>
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">

                    <table class="table table-hover mb-0 table-setoran">
                        <thead>
                            <tr>
                                <th rowspan="2" class="text-center align-middle">NO</th>
                                <th rowspan="2" class="align-middle">NAMA NASABAH</th>
                                <th rowspan="2" class="text-center align-middle">TANGGAL</th>

                                @foreach ($jenis_sampah as $j)
                                    <th colspan="2" class="text-center">{{ strtoupper($j->Jenis_Sampah) }}</th>
                                @endforeach

                                <th colspan="2" class="text-center bg-total">TOTAL AKHIR</th>
                                <th rowspan="2" class="text-center align-middle">AKSI</th>
                            </tr>

                            <tr>
                                @foreach ($jenis_sampah as $j)
                                    <th class="text-center">KG</th>
                                    <th class="text-center">RP</th>
                                @endforeach

                                <th class="text-center">KG</th>
                                <th class="text-center">RP</th>
                            </tr>
                        </thead>
                            <tbody>
                                @forelse ($setoranGrouped as $group)
                                    @php
                                        $first = $group->first(); 
                                        $total_kg = $group->sum('total_berat');
                                        $total_rp = $group->sum('total_harga');
                                    @endphp
                                    <tr>
                                        <td class="text-center fw-bold">{{ $loop->iteration }}</td>

                                        <td>
                                            <div class="nama-nasabah">{{ $first->nasabah->Nama }}</div>
                                            <div class="no-induk">{{ $first->nasabah->No_Induk }}</div>
                                        </td>

                                        <td class="text-center">
                                            {{ \Carbon\Carbon::parse($first->Tgl_Penjualan)->format('d/m/Y') }}
                                        </td>

                                        @foreach($jenis_sampah as $j)
                                            @php $t = $group->where('id_jenis', $j->ID_Jenis)->first(); @endphp
                                            <td class="text-center kg-cell">{{ $t ? number_format($t->total_berat, 2) : '-' }}</td>
                                            <td class="text-end rp-cell">{{ $t ? 'Rp '.number_format($t->total_harga) : '-' }}</td>
                                        @endforeach

                                        <td class="text-center total-kg">{{ number_format($total_kg, 2) }}</td>
                                        <td class="text-end total-rp">Rp {{ number_format($total_rp) }}</td>

                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('setoran.edit', $first->group_id) }}" class="btn btn-warning btn-sm px-3 d-flex align-items-center">
                                                    <i class="fas fa-edit me-1"></i> Edit
                                                </a>

                                                <form action="{{ route('setoran.destroy', $first->group_id) }}" method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus seluruh transaksi ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm px-3 d-flex align-items-center">
                                                        <i class="fas fa-trash me-1"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ $jenis_sampah->count() * 2 + 6 }}" class="empty-state text-center">
                                            <i class="fas fa-trash-alt fa-4x text-success mb-4"></i>
                                            <h4>Belum Ada Data Setoran</h4>
                                            <p class="text-muted">Mulai catat setoran sampah nasabah sekarang!</p>
                                            <a href="{{ route('setoran.create') }}" class="btn btn-tambah-pertama mt-3">
                                                <i class="fas fa-plus me-2"></i> Input Setoran Pertama
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                    </table>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
