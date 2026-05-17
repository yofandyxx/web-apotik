@extends('layouts.app')

@section('title', isset($obat) ? 'Edit Obat' : 'Tambah Obat')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title">{{ isset($obat) ? 'Edit' : 'Tambah' }} Data Obat</h5>
    </div>
    <div class="card-body">
        <form action="{{ isset($obat) ? route('obat.update', $obat) : route('obat.store') }}" method="POST">
            @csrf
            @if(isset($obat))
                @method('PUT')
            @endif
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="kode_obat" class="form-label">Kode Obat</label>
                        <input type="text" class="form-control @error('kode_obat') is-invalid @enderror" 
                               id="kode_obat" name="kode_obat" 
                               value="{{ old('kode_obat', $obat->kode_obat ?? '') }}" required>
                        @error('kode_obat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nama_obat" class="form-label">Nama Obat</label>
                        <input type="text" class="form-control @error('nama_obat') is-invalid @enderror" 
                               id="nama_obat" name="nama_obat" 
                               value="{{ old('nama_obat', $obat->nama_obat ?? '') }}" required>
                        @error('nama_obat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="kategori_id" class="form-label">Kategori</label>
                        <select class="form-control @error('kategori_id') is-invalid @enderror" 
                                id="kategori_id" name="kategori_id" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" 
                                    {{ old('kategori_id', $obat->kategori_id ?? '') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="satuan" class="form-label">Satuan</label>
                        <input type="text" class="form-control @error('satuan') is-invalid @enderror" 
                               id="satuan" name="satuan" 
                               value="{{ old('satuan', $obat->satuan ?? '') }}" required>
                        @error('satuan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="harga_beli" class="form-label">Harga Beli</label>
                        <input type="number" class="form-control @error('harga_beli') is-invalid @enderror" 
                               id="harga_beli" name="harga_beli" 
                               value="{{ old('harga_beli', $obat->harga_beli ?? '') }}" required>
                        @error('harga_beli')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="harga_jual" class="form-label">Harga Jual</label>
                        <input type="number" class="form-control @error('harga_jual') is-invalid @enderror" 
                               id="harga_jual" name="harga_jual" 
                               value="{{ old('harga_jual', $obat->harga_jual ?? '') }}" required>
                        @error('harga_jual')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="stok" class="form-label">Stok</label>
                        <input type="number" class="form-control @error('stok') is-invalid @enderror" 
                               id="stok" name="stok" 
                               value="{{ old('stok', $obat->stok ?? '') }}" required>
                        @error('stok')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="stok_minimal" class="form-label">Stok Minimal</label>
                        <input type="number" class="form-control @error('stok_minimal') is-invalid @enderror" 
                               id="stok_minimal" name="stok_minimal" 
                               value="{{ old('stok_minimal', $obat->stok_minimal ?? '') }}" required>
                        @error('stok_minimal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="expired_date" class="form-label">Expired Date</label>
                        <input type="date" class="form-control @error('expired_date') is-invalid @enderror" 
                               id="expired_date" name="expired_date" 
                               value="{{ old('expired_date', isset($obat) ? $obat->expired_date->format('Y-m-d') : '') }}" required>
                        @error('expired_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                          id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $obat->deskripsi ?? '') }}</textarea>
                @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('obat.index') }}" class="btn btn-secondary">
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