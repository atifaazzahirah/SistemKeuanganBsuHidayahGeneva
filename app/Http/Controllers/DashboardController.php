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
        $totalNasabah = Nasabah::count();
        $nasabahBaruHariIni = Nasabah::whereDate('created_at', Carbon::today())->count();
        $totalSampahBulanIni = Setoran::whereMonth('Tgl_Penjualan', Carbon::now()->month)
                                      ->sum('total_berat');
        $totalSaldo = Nasabah::sum('Total_Saldo');
        $statSampah = Setoran::selectRaw('id_jenis, COUNT(*) as transaksi, SUM(total_berat) as total_kg')
                            ->groupBy('id_jenis')
                            ->with('jenis')
                            ->get();
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
