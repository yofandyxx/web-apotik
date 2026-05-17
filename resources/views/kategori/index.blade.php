@extends('layouts.app')

@section('title', 'Kategori Obat')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="text-white">Data Kategori Obat</h3>
    <a href="{{ route('kategori.create') }}" class="btn btn-success">
        <i class="fas fa-plus"></i> Tambah Kategori
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kategoris as $kategori)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $kategori->nama_kategori }}</td>
                        <td>{{ $kategori->deskripsi ?? '-' }}</td>
                        <td>{{ $kategori->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('kategori.edit', $kategori) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('kategori.destroy', $kategori) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" 
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
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