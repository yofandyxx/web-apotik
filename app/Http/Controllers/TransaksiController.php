<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with('user')->latest()->get();
        return view('transaksi.index', compact('transaksis'));
    }

    public function kasir()
    {
        $obats = Obat::where('stok', '>', 0)->get();
        return view('transaksi.kasir', compact('obats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.obat_id' => 'required|exists:obats,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'bayar' => 'required|numeric|min:0'
        ]);
    
        $kodeTransaksi = '';
    
        DB::transaction(function () use ($request, &$kodeTransaksi) {
            $kodeTransaksi = 'TRX-' . Str::upper(Str::random(8));
            $totalHarga = 0;
    
            $transaksi = Transaksi::create([
                'kode_transaksi' => $kodeTransaksi,
                'user_id' => Auth::id(),
                'total_harga' => 0,
                'bayar' => $request->bayar,
                'kembalian' => 0,
                'status' => 'selesai'
            ]);
    
            foreach ($request->items as $item) {
                $obat = Obat::find($item['obat_id']);
                $hargaSatuan = $obat->harga_jual;
                $subtotal = $hargaSatuan * $item['jumlah'];
    
                TransaksiDetail::create([
                    'transaksi_id' => $transaksi->id,
                    'obat_id' => $obat->id,
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $hargaSatuan,
                    'subtotal' => $subtotal
                ]);
    
                $obat->decrement('stok', $item['jumlah']);
                $totalHarga += $subtotal;
            }
    
            $kembalian = $request->bayar - $totalHarga;
            $transaksi->update([
                'total_harga' => $totalHarga,
                'kembalian' => $kembalian
            ]);
        });
    
        return response()->json([
            'success' => true, 
            'message' => 'Transaksi berhasil disimpan',
            'kode_transaksi' => $kodeTransaksi
        ]);
    }
    public function show(Transaksi $transaksi)
    {
        $transaksi->load('transaksiDetails.obat', 'user');
        return view('transaksi.show', compact('transaksi'));
    }

    public function print(Transaksi $transaksi)
    {
        $transaksi->load('transaksiDetails.obat', 'user');
        return view('transaksi.print', compact('transaksi'));
    }
}