<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Kategori;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index()
    {
        $obats = Obat::with('kategori')->get();
        return view('obat.index', compact('obats'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('obat.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_obat' => 'required|string|unique:obats',
            'nama_obat' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'stok_minimal' => 'required|integer|min:0',
            'expired_date' => 'required|date',
            'satuan' => 'required|string|max:50',
            'deskripsi' => 'nullable|string'
        ]);

        Obat::create($request->all());

        return redirect()->route('obat.index')
            ->with('success', 'Obat berhasil ditambahkan.');
    }

    public function show(Obat $obat)
    {
        return view('obat.show', compact('obat'));
    }

    public function edit(Obat $obat)
    {
        $kategoris = Kategori::all();
        return view('obat.edit', compact('obat', 'kategoris'));
    }

    public function update(Request $request, Obat $obat)
    {
        $request->validate([
            'kode_obat' => 'required|string|unique:obats,kode_obat,' . $obat->id,
            'nama_obat' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'stok_minimal' => 'required|integer|min:0',
            'expired_date' => 'required|date',
            'satuan' => 'required|string|max:50',
            'deskripsi' => 'nullable|string'
        ]);

        $obat->update($request->all());

        return redirect()->route('obat.index')
            ->with('success', 'Obat berhasil diperbarui.');
    }

    public function destroy(Obat $obat)
    {
        $obat->delete();

        return redirect()->route('obat.index')
            ->with('success', 'Obat berhasil dihapus.');
    }
}