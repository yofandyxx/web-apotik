<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obat;
use App\Models\Transaksi;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalObat = Obat::count();
        $totalKategori = Kategori::count();
        
        $today = Carbon::today();
        $transaksiHariIni = Transaksi::whereDate('created_at', $today)->count();
        $pendapatanHariIni = Transaksi::whereDate('created_at', $today)->sum('total_harga');
        
        $obatHampirHabis = Obat::where('stok', '<=', DB::raw('stok_minimal'))->get();
        $obatExpired = Obat::where('expired_date', '<=', $today->addDays(30))->get();
        
        $transaksiTerbaru = Transaksi::with('user')->latest()->take(5)->get();

        return view('dashboard.index', compact(
            'totalObat', 
            'totalKategori', 
            'transaksiHariIni', 
            'pendapatanHariIni',
            'obatHampirHabis',
            'obatExpired',
            'transaksiTerbaru'
        ));
    }
}