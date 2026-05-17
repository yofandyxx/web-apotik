<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    public function __construct()
    {
        // JANGAN gunakan $this->middleware() di sini
        // Kita akan handle auth di setiap method
    }

    /**
     * Check if user is admin
     */
    private function checkAdmin()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }
    }

    public function index()
    {
        $this->checkAdmin();
        $kategoris = Kategori::all();
        return view('kategori.index', compact('kategoris'));
    }

    public function create()
    {
        $this->checkAdmin();
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $this->checkAdmin();
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris',
            'deskripsi' => 'nullable|string'
        ]);

        Kategori::create($request->all());

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show(Kategori $kategori)
    {
        $this->checkAdmin();
        return view('kategori.show', compact('kategori'));
    }

    public function edit(Kategori $kategori)
    {
        $this->checkAdmin();
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $this->checkAdmin();
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori,' . $kategori->id,
            'deskripsi' => 'nullable|string'
        ]);

        $kategori->update($request->all());

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori)
    {
        $this->checkAdmin();
        $kategori->delete();

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}