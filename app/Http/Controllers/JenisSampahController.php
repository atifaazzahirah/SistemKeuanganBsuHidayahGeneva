<?php

namespace App\Http\Controllers;

use App\Models\JenisSampah;
use App\Models\Setoran;
use App\Models\Nasabah;
use Illuminate\Http\Request;

class JenisSampahController extends Controller
{
    public function index()
    {
        $jenis_sampah = JenisSampah::all();
        return view('jenissampah.index', compact('jenis_sampah'));
    }

    public function create()
    {
        return view('jenissampah.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_sampah' => 'required|string|max:255|unique:jenis_sampah,Jenis_Sampah',
            'harga_kg'     => 'required|numeric|min:0',
        ]);

        JenisSampah::create([
            'Jenis_Sampah' => $validated['jenis_sampah'],
            'Harga_kg'     => $validated['harga_kg'],
        ]);

        return redirect()->route('jenissampah.index')
            ->with('success', 'Data jenis sampah berhasil ditambahkan.');
    }

    public function show(JenisSampah $jenissampah)
    {
        return view('jenissampah.show', [
            'jenis_sampah' => $jenissampah
        ]);
    }

    public function edit($id)
    {
        $jenis_sampah = JenisSampah::findOrFail($id);
        return view('jenissampah.edit', compact('jenis_sampah'));
    }

    public function update(Request $request, $id)
    {
        $jenisSampah = JenisSampah::findOrFail($id);

        $validated = $request->validate([
            'jenis_sampah' => 'sometimes|required|string|max:255|unique:jenis_sampah,Jenis_Sampah,' . $id . ',ID_Jenis',
            'harga_kg'     => 'sometimes|required|numeric|min:0',
        ]);

        $dataUpdate = [];

        // Update nama jenis
        if (array_key_exists('jenis_sampah', $validated)) {
            $dataUpdate['Jenis_Sampah'] = $validated['jenis_sampah'];
        }

        // Update harga dan saldo nasabah
        if (array_key_exists('harga_kg', $validated)) {
            $oldHarga = $jenisSampah->Harga_kg;
            $newHarga = $validated['harga_kg'];

            // Ambil semua setoran terkait
            $setoranTerkait = Setoran::where('id_jenis', $id)->get();

            foreach ($setoranTerkait as $s) {
                $oldTotal = $s->total_harga;
                $newTotal = $s->total_berat * $newHarga;
                $selisih  = $newTotal - $oldTotal;

                // Update saldo nasabah sesuai selisih
                Nasabah::where('ID_Nasabah', $s->Id_nasabah)
                    ->increment('Total_Saldo', $selisih);

                // Update total_harga setoran
                $s->update(['total_harga' => $newTotal]);
            }

            $dataUpdate['Harga_kg'] = $newHarga;
        }

        $jenisSampah->update($dataUpdate);

        return redirect()->route('jenissampah.index')
            ->with('success', 'Data jenis sampah berhasil diperbarui, saldo nasabah otomatis diperbarui.');
    }

    public function destroy($id)
    {
        $jenisSampah = JenisSampah::findOrFail($id);

        // Ambil semua setoran terkait sebelum dihapus
        $setoranTerkait = Setoran::where('id_jenis', $id)->get();

        foreach ($setoranTerkait as $s) {
            // Kurangi saldo nasabah
            Nasabah::where('ID_Nasabah', $s->Id_nasabah)
                ->decrement('Total_Saldo', $s->total_harga);
            
            // Hapus setoran
            $s->delete();
        }

        // Hapus jenis sampah
        $jenisSampah->delete();

        return redirect()->route('jenissampah.index')
            ->with('success', 'Data jenis sampah berhasil dihapus, saldo nasabah otomatis diperbarui.');
    }
}
