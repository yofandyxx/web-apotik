@extends('layouts.app')

@section('title', 'Data Obat')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="text-white">Data Obat</h3>
    <a href="{{ route('obat.create') }}" class="btn btn-success">
        <i class="fas fa-plus"></i> Tambah Obat
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Nama Obat</th>
                        <th>Kategori</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th>Expired</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($obats as $obat)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $obat->kode_obat }}</td>
                        <td>{{ $obat->nama_obat }}</td>
                        <td>{{ $obat->kategori->nama_kategori }}</td>
                        <td>Rp {{ number_format($obat->harga_jual, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $obat->stok <= $obat->stok_minimal ? 'bg-warning' : 'bg-success' }}">
                                {{ $obat->stok }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $obat->expired_date->isPast() ? 'bg-danger' : ($obat->expired_date->diffInDays(now()) <= 30 ? 'bg-warning' : 'bg-info') }}">
                                {{ $obat->expired_date->format('d/m/Y') }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('obat.show', $obat) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('obat.edit', $obat) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('obat.destroy', $obat) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" 
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus obat ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection