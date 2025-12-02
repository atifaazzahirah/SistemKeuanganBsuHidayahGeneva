<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nasabah;
use App\Models\Setoran;
use App\Models\JenisSampah;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total nasabah
        $totalNasabah = Nasabah::count();

        // Nasabah baru hari ini
        $nasabahBaruHariIni = Nasabah::whereDate('created_at', Carbon::today())->count();

        // Total sampah bulan ini (pakai Tgl_Penjualan dan total_berat)
        $totalSampahBulanIni = Setoran::whereMonth('Tgl_Penjualan', Carbon::now()->month)
                                      ->sum('total_berat');

        // Total saldo dari kolom Total_Saldo di tabel nasabah
        $totalSaldo = Nasabah::sum('Total_Saldo');

        // Statistik sampah per jenis
        $statSampah = Setoran::selectRaw('id_jenis, COUNT(*) as transaksi, SUM(total_berat) as total_kg')
                            ->groupBy('id_jenis')
                            ->with('jenis')
                            ->get();

        // Jenis sampah
        $jenisSampah = JenisSampah::limit(3)->get();

        return view('dashboard', compact(
            'totalNasabah',
            'nasabahBaruHariIni',
            'totalSampahBulanIni',
            'totalSaldo',
            'statSampah',
            'jenisSampah'
        ));
    }
}
