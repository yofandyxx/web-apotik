@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <!-- Statistik Cards -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card primary">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">
                            Total Obat</div>
                        <div class="h5 mb-0 font-weight-bold">{{ $totalObat }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-pills fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card success">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">
                            Total Kategori</div>
                        <div class="h5 mb-0 font-weight-bold">{{ $totalKategori }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-tags fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card warning">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">
                            Transaksi Hari Ini</div>
                        <div class="h5 mb-0 font-weight-bold">{{ $transaksiHariIni }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-shopping-cart fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card danger">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">
                            Pendapatan Hari Ini</div>
                        <div class="h5 mb-0 font-weight-bold">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-money-bill-wave fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Obat Hampir Habis -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-exclamation-triangle"></i> Obat Hampir Habis
                </h6>
            </div>
            <div class="card-body">
                @if($obatHampirHabis->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Nama Obat</th>
                                    <th>Stok</th>
                                    <th>Stok Minimal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($obatHampirHabis as $obat)
                                <tr>
                                    <td>{{ $obat->nama_obat }}</td>
                                    <td><span class="badge bg-warning">{{ $obat->stok }}</span></td>
                                    <td>{{ $obat->stok_minimal }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center">Tidak ada obat yang hampir habis</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Obat Akan Expired -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header bg-danger text-white">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-calendar-times"></i> Obat Akan Expired (30 Hari)
                </h6>
            </div>
            <div class="card-body">
                @if($obatExpired->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Nama Obat</th>
                                    <th>Expired Date</th>
                                    <th>Sisa Hari</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($obatExpired as $obat)
                                <tr>
                                    <td>{{ $obat->nama_obat }}</td>
                                    <td>{{ $obat->expired_date->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge bg-danger">
                                            {{ now()->diffInDays($obat->expired_date) }} hari
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center">Tidak ada obat yang akan expired</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Transaksi Terbaru -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-history"></i> Transaksi Terbaru
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Kode Transaksi</th>
                                <th>Kasir</th>
                                <th>Total Harga</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksiTerbaru as $transaksi)
                            <tr>
                                <td>{{ $transaksi->kode_transaksi }}</td>
                                <td>{{ $transaksi->user->name }}</td>
                                <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                                <td>{{ $transaksi->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('transaksi.show', $transaksi) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection