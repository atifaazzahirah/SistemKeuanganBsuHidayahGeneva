<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\JenisSampah;
use App\Models\Setoran;
use Illuminate\Http\Request;

class SetoranController extends Controller
{
public function index(Request $request)
{
    $keyword       = $request->keyword;
    $tanggal_awal  = $request->tanggal_awal;
    $tanggal_akhir = $request->tanggal_akhir;

    $query = Setoran::with(['nasabah','jenis']);

    // Filter berdasarkan nama nasabah
    if ($keyword) {
        $query->whereHas('nasabah', function ($q) use ($keyword) {
            $q->where('Nama', 'LIKE', "%{$keyword}%");
        });
    }

    // Filter tanggal
    if ($tanggal_awal && $tanggal_akhir) {
        $query->whereBetween('Tgl_Penjualan', [$tanggal_awal, $tanggal_akhir]);
    } elseif ($tanggal_awal) {
        $query->whereDate('Tgl_Penjualan', '>=', $tanggal_awal);
    } elseif ($tanggal_akhir) {
        $query->whereDate('Tgl_Penjualan', '<=', $tanggal_akhir);
    }

    $setoran = $query->orderBy('group_id')->get();
    $setoranGrouped = $setoran->groupBy('group_id');
    $jenis_sampah = JenisSampah::orderBy('ID_Jenis')->get();

    return view('setoran.index', [
        'setoranGrouped' => $setoranGrouped, 
        'jenis_sampah'   => $jenis_sampah,
        'keyword'        => $keyword,
        'tanggal_awal'   => $tanggal_awal,
        'tanggal_akhir'  => $tanggal_akhir,
    ]);
}

    public function create()
    {
        $nasabah = Nasabah::orderBy('Nama')->get();
        $jenis_sampah = JenisSampah::orderBy('ID_Jenis')->get();

        return view('setoran.create', compact('nasabah', 'jenis_sampah'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Id_nasabah'    => 'required|exists:nasabah,ID_Nasabah',
            'Tgl_Penjualan' => 'required|date',
            'berat.*'       => 'nullable|numeric|min:0',
        ]);

        $groupId = time() . rand(100, 999);
        $total_harga = 0;

        foreach ($request->berat as $id_jenis => $berat) {
            $berat = (float) $berat;

            if ($berat > 0) {
                $jenis = JenisSampah::findOrFail($id_jenis);
                $subtotal = $jenis->Harga_kg * $berat;

                Setoran::create([
                    'group_id'      => $groupId,
                    'Id_nasabah'    => $request->Id_nasabah,
                    'Tgl_Penjualan' => $request->Tgl_Penjualan,
                    'id_jenis'      => $id_jenis,
                    'total_berat'   => $berat,
                    'total_harga'   => $subtotal,
                ]);

                $total_harga += $subtotal;
            }
        }

        // Tambahkan saldo nasabah
        Nasabah::where('ID_Nasabah', $request->Id_nasabah)
            ->increment('Total_Saldo', $total_harga);

        return redirect()->route('setoran.index')
            ->with('success', "Setoran berhasil ditambahkan!");
    }

    public function edit($group_id)
    {
        $group = Setoran::where('group_id', $group_id)->get();

        if ($group->isEmpty()) {
            return redirect()->route('setoran.index')->with('error', 'Data tidak ditemukan.');
        }

        $nasabah = Nasabah::orderBy('Nama')->get();
        $jenis_sampah = JenisSampah::orderBy('ID_Jenis')->get();

        $first = $group->first();

        $detail = [];
        foreach ($group as $g) {
            $detail[$g->id_jenis] = [
                'berat' => $g->total_berat,
                'harga' => $g->total_harga,
            ];
        }

        return view('setoran.edit', compact(
            'group', 'group_id', 'first',
            'nasabah', 'jenis_sampah', 'detail'
        ));
    }

    public function update(Request $request, $group_id)
    {
        $request->validate([
            'Id_nasabah'    => 'required',
            'Tgl_Penjualan' => 'required|date',
            'berat.*'       => 'nullable|numeric|min:0',
        ]);

        $oldItems = Setoran::where('group_id', $group_id)->get();

        if ($oldItems->isEmpty()) {
            return redirect()->route('setoran.index')->with('error', 'Data tidak ditemukan.');
        }

        $oldNasabahId = $oldItems->first()->Id_nasabah;

        // Kurangi saldo nasabah lama
        $totalLama = $oldItems->sum('total_harga');
        Nasabah::where('ID_Nasabah', $oldNasabahId)->decrement('Total_Saldo', $totalLama);

        // Hapus transaksi lama
        Setoran::where('group_id', $group_id)->delete();

        // Input ulang transaksi baru & hitung saldo baru
        $totalBaru = 0;

        foreach ($request->berat as $id_jenis => $berat) {
            $berat = (float) $berat;

            if ($berat > 0) {
                $jenis = JenisSampah::findOrFail($id_jenis);
                $subtotal = $jenis->Harga_kg * $berat;

                Setoran::create([
                    'group_id'      => $group_id,
                    'Id_nasabah'    => $request->Id_nasabah,
                    'Tgl_Penjualan' => $request->Tgl_Penjualan,
                    'id_jenis'      => $id_jenis,
                    'total_berat'   => $berat,
                    'total_harga'   => $subtotal,
                ]);

                $totalBaru += $subtotal;
            }
        }

        // Tambahkan saldo nasabah baru
        Nasabah::where('ID_Nasabah', $request->Id_nasabah)->increment('Total_Saldo', $totalBaru);

        return redirect()->route('setoran.index')
            ->with('success', 'Setoran berhasil diperbarui!');
    }

    public function destroy($group_id)
    {
        $items = Setoran::where('group_id', $group_id)->get();

        if ($items->isEmpty()) {
            return back()->with('error', 'Data tidak ditemukan.');
        }

        $nasabah_id = $items->first()->Id_nasabah;
        $total_rp   = $items->sum('total_harga');

        // Kurangi saldo nasabah
        Nasabah::where('ID_Nasabah', $nasabah_id)
            ->decrement('Total_Saldo', $total_rp);

        // Hapus semua transaksi dalam grup
        Setoran::where('group_id', $group_id)->delete();

        return redirect()->route('setoran.index')
            ->with('success', 'Setoran berhasil dihapus & saldo nasabah otomatis berkurang!');
    }

 
    public function exportRekapJenisPdf(Request $request)
    {
        $filter = $request->filter; // all | single | range
        $query = Setoran::with('jenis');

        if ($filter == 'all') {
            $setoran = $query->get();
            $tanggal = "Semua Tanggal";
            $fileName = "Rekap-Semua-Tanggal.pdf";
        } elseif ($filter == 'single') {
            $tanggal = $request->tanggal;
            $setoran = $query->whereDate('Tgl_Penjualan', $tanggal)->get();
            $fileName = "Rekap-Tanggal-" . str_replace('/', '-', $tanggal) . ".pdf";
        } elseif ($filter == 'range') {
            $start = $request->start_date;
            $end   = $request->end_date;
            $tanggal = $start . " s/d " . $end;
            $setoran = $query->whereBetween('Tgl_Penjualan', [$start, $end])->get();
            $fileName = "Rekap-Tanggal-" . str_replace('/', '-', $start) . "-sampai-" . str_replace('/', '-', $end) . ".pdf";
        }

        $jenis_sampah = JenisSampah::all();
        $rekap = [];

        foreach ($jenis_sampah as $jenis) {
            $total_kg = $setoran->where('id_jenis', $jenis->ID_Jenis)->sum('total_berat');
            $total_harga = $setoran->where('id_jenis', $jenis->ID_Jenis)->sum('total_harga');

            $rekap[] = [
                'jenis_sampah' => $jenis->Jenis_Sampah,
                'total_kg' => $total_kg,
                'total_harga' => $total_harga,
            ];
        }

        $totalKgAll = $setoran->sum('total_berat');
        $totalRpAll = $setoran->sum('total_harga');

        $pdf = \PDF::loadView('setoran.pdf', [
            'tanggal'    => $tanggal,
            'rekap'      => $rekap,
            'totalKgAll' => $totalKgAll,
            'totalRpAll' => $totalRpAll
        ])->setPaper('A4', 'portrait');

        return $pdf->download($fileName);
    }

}
