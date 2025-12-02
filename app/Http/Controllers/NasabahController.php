<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use Illuminate\Http\Request;

class NasabahController extends Controller
{
    // GET /nasabah → tampilkan list nasabah (view)
    public function index()
    {
        $nasabah = Nasabah::all();   // ambil semua data
        return view('nasabah.index', compact('nasabah'));
    }

    // GET /nasabah/create → form tambah nasabah
    public function create()
    {
        return view('nasabah.create');
    }

    // POST /nasabah → simpan nasabah baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'        => 'required|string|max:255',
            'no_induk'    => 'required|string|max:50|unique:nasabah,No_Induk',
            'alamat'      => 'nullable|string',
            'no_hp'       => 'nullable|string|max:20',
            'jml_kk'      => 'nullable|integer',
        ]);

        Nasabah::create([
            'Nama'        => $validated['nama'],
            'No_Induk'    => $validated['no_induk'],
            'Alamat'      => $validated['alamat']      ?? null,
            'No_HP'       => $validated['no_hp']       ?? null,
            'jml_kk'      => $validated['jml_kk']      ?? null,
        ]);

        return redirect()->route('nasabah.index')
            ->with('success', 'Data nasabah berhasil ditambahkan.');
    }

    // GET /nasabah/{id} → detail nasabah
public function show(Nasabah $nasabah)
{
    return view('nasabah.show', compact('nasabah'));
}


    // GET /nasabah/{id}/edit → form edit
    public function edit($id)
    {
        $nasabah = Nasabah::findOrFail($id);
        return view('nasabah.edit', compact('nasabah'));
    }

    // PUT/PATCH /nasabah/{id} → update data
    public function update(Request $request, $id)
    {
        $nasabah = Nasabah::findOrFail($id);

        $validated = $request->validate([
            'nama'        => 'sometimes|required|string|max:255',
            'no_induk'    => 'sometimes|required|string|max:50|unique:nasabah,No_Induk,' . $id . ',ID_Nasabah',
            // kalau PK di tabel nasabah BUKAN 'id', ganti 'id' di atas dengan nama PK yang benar
            'alamat'      => 'nullable|string',
            'no_hp'       => 'nullable|string|max:20',
            'jml_kk'      => 'nullable|integer',
        ]);

        $dataUpdate = [];

        if (array_key_exists('nama', $validated)) {
            $dataUpdate['Nama'] = $validated['nama'];
        }
        if (array_key_exists('no_induk', $validated)) {
            $dataUpdate['No_Induk'] = $validated['no_induk'];
        }
        if (array_key_exists('alamat', $validated)) {
            $dataUpdate['Alamat'] = $validated['alamat'];
        }
        if (array_key_exists('no_hp', $validated)) {
            $dataUpdate['No_HP'] = $validated['no_hp'];
        }
        if (array_key_exists('jml_kk', $validated)) {
            $dataUpdate['jml_kk'] = $validated['jml_kk'];
        }

        $nasabah->update($dataUpdate);

        return redirect()->route('nasabah.index')
            ->with('success', 'Data nasabah berhasil diperbarui.');
    }

    // DELETE /nasabah/{id} → hapus data
    public function destroy($id)
    {
        $nasabah = Nasabah::findOrFail($id);
        $nasabah->delete();

        return redirect()->route('nasabah.index')
            ->with('success', 'Data nasabah berhasil dihapus.');
    }
}
