@extends('layouts.app')

@section('title', 'Riwayat Transaksi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="text-white">Riwayat Transaksi</h3>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Transaksi</th>
                        <th>Kasir</th>
                        <th>Total Harga</th>
                        <th>Bayar</th>
                        <th>Kembalian</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksis as $transaksi)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $transaksi->kode_transaksi }}</td>
                        <td>{{ $transaksi->user->name }}</td>
                        <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</td>
                        <td>{{ $transaksi->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('transaksi.show', $transaksi) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('transaksi.print', $transaksi) }}" target="_blank" class="btn btn-sm btn-warning">
                                <i class="fas fa-print"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection