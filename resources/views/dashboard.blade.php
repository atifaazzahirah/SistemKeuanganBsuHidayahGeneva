@extends('layouts.app')
@section('title', 'Dashboard Overview')

@section('content')
<div class="container py-4">

    <h4 class="fw-bold mb-4">Dashboard Overview</h4>
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card p-4 shadow-sm dashboard-card">
                <small class="text-muted">Total Nasabah</small>
                <h2 class="fw-bold mt-2">{{ $totalNasabah }}</h2>
                <div class="text-muted mt-2">
                    <i class="bi bi-person-add"></i> + {{ $nasabahBaruHariIni }} Nasabah baru
                </div>

            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 shadow-sm dashboard-card border-primary">
                <small class="text-muted">Total Sampah (Kg)</small>
                <h2 class="fw-bold mt-2">{{ number_format($totalSampahBulanIni, 0) }}</h2>
                <div class="text-muted mt-2">
                    <i class="bi bi-calendar-week"></i> Bulan ini
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 shadow-sm dashboard-card border-warning">
                <small class="text-muted">Total Nilai (Rp)</small>
                <h2 class="fw-bold mt-2">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</h2>
                <div class="text-muted mt-2">
                    <i class="bi bi-coin"></i> Saldo Tersedia
                </div>
            </div>
        </div>

    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card p-4 shadow-sm">
                <h6 class="fw-bold">Sampah Masuk (Kg)</h6>

                @foreach($statSampah as $s)
                    <div class="d-flex justify-content-between mt-3 border-bottom pb-2">
                        <div>
                            <strong>{{ $s->jenis->Jenis_Sampah }}</strong>  
                            <small class="text-muted d-block">{{ $s->transaksi }} transaksi</small>
                        </div>
                        <strong>{{ number_format($s->total_kg, 0) }} Kg</strong>
                    </div>
                @endforeach

            </div>
        </div>
        <div class="col-md-8">
            <div class="card p-4 shadow-sm">
                <h6 class="fw-bold">Informasi Harga & Jenis Sampah</h6>
                <small class="text-muted">Harga berlaku mulai: 1 November 2025</small>

                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th>Jenis Sampah</th>
                            <th>Harga / Kg</th>
                            <th>Terima</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jenisSampah as $j)
                        <tr>
                            <td>{{ $j->Jenis_Sampah }}</td>
                            <td>Rp {{ number_format($j->Harga_kg, 0, ',', '.') }}</td>
                            <td><i class="bi bi-check-circle text-success">&#10004</i></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="text-end">
                    <a href="{{ route('jenissampah.index') }}" class="text-primary">
                        Lihat Semua Kategori Sampah →
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
