@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="row g-4">
    <!-- Card Total Nasabah -->
    <div class="col-md-4">
        <div class="card text-center border-0 shadow-sm">
            <div class="card-body">
                <i class="fas fa-users fa-3x text-primary mb-3"></i>
                <h5>Total Nasabah</h5>
                <h2 class="text-primary">68</h2>
                <small class="text-muted">+4 Nasabah baru</small>
            </div>
        </div>
    </div>

    <!-- Card Total Sampah (Kg) -->
    <div class="col-md-4">
        <div class="card text-center border-0 shadow-sm">
            <div class="card-body">
                <i class="fas fa-weight-hanging fa-3x text-info mb-3"></i>
                <h5>Total Sampah (Kg)</h5>
                <h2 class="text-info">1.255</h2>
                <small class="text-muted">Bulan ini</small>
            </div>
        </div>
    </div>

    <!-- Card Total Nilai (Rp) -->
    <div class="col-md-4">
        <div class="card text-center border-0 shadow-sm">
            <div class="card-body">
                <i class="fas fa-money-bill-wave fa-3x text-warning mb-3"></i>
                <h5>Total Nilai (Rp)</h5>
                <h2 class="text-warning">1.882.500</h2>
                <small class="text-muted">Rp600.750 bulan ini</small>
            </div>
        </div>
    </div>
</div>

<!-- Ringkasan Jenis Sampah Bulan Ini -->
<div class="card mt-4 shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0">Ringkasan Jenis Sampah Bulan Ini</h5>
    </div>
    <div class="card-body">
        <div class="row text-center">
            <div class="col">
                <h4 class="text-success">450 kg</h4>
                <p>Kertas/Kardus</p>
            </div>
            <div class="col">
                <h4 class="text-warning">305 kg</h4>
                <p>Plastik</p>
            </div>
            <div class="col">
                <h4 class="text-info">380 kg</h4>
                <p>Kardus</p>
            </div>
            <div class="col">
                <h4 class="text-danger">120 kg</h4>
                <p>Logam</p>
            </div>
        </div>
    </div>
</div>

<!-- Aktivitas Terakhir -->
<div class="card mt-4 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between">
        <h5 class="mb-0">Aktivitas Terakhir</h5>
        <a href="/setoran" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>NASABAH</th>
                        <th>TANGGAL</th>
                        <th>TOTAL BERAT</th>
                        <th>STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Saridi</td>
                        <td>10 Nov 2024</td>
                        <td>11 Kg</td>
                        <td><span class="badge bg-success">Selesai</span></td>
                    </tr>
                    <tr>
                        <td>IPG Novo</td>
                        <td>09 Nov 2024</td>
                        <td>15 Kg</td>
                        <td><span class="badge bg-success">Selesai</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection