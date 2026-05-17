@extends('layouts.app')

@section('title', isset($kategori) ? 'Edit Kategori' : 'Tambah Kategori')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title">{{ isset($kategori) ? 'Edit' : 'Tambah' }} Kategori Obat</h5>
    </div>
    <div class="card-body">
        <form action="{{ isset($kategori) ? route('kategori.update', $kategori) : route('kategori.store') }}" method="POST">
            @csrf
            @if(isset($kategori))
                @method('PUT')
            @endif
            
            <div class="mb-3">
                <label for="nama_kategori" class="form-label">Nama Kategori</label>
                <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror" 
                       id="nama_kategori" name="nama_kategori" 
                       value="{{ old('nama_kategori', $kategori->nama_kategori ?? '') }}" required>
                @error('nama_kategori')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                          id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $kategori->deskripsi ?? '') }}</textarea>
                @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('kategori.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection