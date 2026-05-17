@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Detail Transaksi - {{ $transaksi->kode_transaksi }}</h5>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <th>Kode Transaksi</th>
                        <td>: {{ $transaksi->kode_transaksi }}</td>
                    </tr>
                    <tr>
                        <th>Kasir</th>
                        <td>: {{ $transaksi->user->name }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <td>: {{ $transaksi->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <th>Total Harga</th>
                        <td>: Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Bayar</th>
                        <td>: Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Kembalian</th>
                        <td>: Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <h6>Detail Obat:</h6>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Obat</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksi->transaksiDetails as $detail)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $detail->obat->nama_obat }}</td>
                        <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                        <td>{{ $detail->jumlah }}</td>
                        <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('transaksi.print', $transaksi) }}" target="_blank" class="btn btn-warning">
                <i class="fas fa-print"></i> Cetak
            </a>
        </div>
    </div>
</div>
@endsection