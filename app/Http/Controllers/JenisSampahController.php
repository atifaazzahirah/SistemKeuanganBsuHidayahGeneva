<?php

namespace App\Http\Controllers;

use App\Models\JenisSampah;
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

        if (array_key_exists('jenis_sampah', $validated)) {
            $dataUpdate['Jenis_Sampah'] = $validated['jenis_sampah'];
        }

        if (array_key_exists('harga_kg', $validated)) {
            $dataUpdate['Harga_kg'] = $validated['harga_kg'];
        }

        $jenisSampah->update($dataUpdate);

        return redirect()->route('jenissampah.index')
            ->with('success', 'Data jenis sampah berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jenis_sampah = JenisSampah::findOrFail($id);
        $jenis_sampah->delete();

        return redirect()->route('jenissampah.index')
            ->with('success', 'Data jenis sampah berhasil dihapus.');
    }
}
