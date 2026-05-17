@extends('layouts.app')

@section('title', 'Kasir')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-cash-register"></i> Transaksi Penjualan</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="search_obat" class="form-label">Cari Obat</label>
                        <select id="search_obat" class="form-control">
                            <option value="">Pilih Obat...</option>
                            @foreach($obats as $obat)
                                <option value="{{ $obat->id }}" 
                                        data-nama="{{ $obat->nama_obat }}"
                                        data-harga="{{ $obat->harga_jual }}"
                                        data-stok="{{ $obat->stok }}"
                                        data-kode="{{ $obat->kode_obat }}">
                                    {{ $obat->kode_obat }} - {{ $obat->nama_obat }} (Stok: {{ $obat->stok }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="number" id="jumlah" class="form-control" value="1" min="1">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <button type="button" id="tambah_obat" class="btn btn-success w-100">
                            <i class="fas fa-plus"></i> Tambah
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="table_keranjang">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Obat</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="keranjang_body">
                            <!-- Items akan ditambahkan di sini -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                <td colspan="2"><strong id="total_harga">Rp 0</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-money-bill-wave"></i> Pembayaran</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="total" class="form-label">Total Belanja</label>
                    <input type="text" id="total" class="form-control" readonly value="Rp 0">
                </div>
                <div class="mb-3">
                    <label for="bayar" class="form-label">Bayar</label>
                    <input type="number" id="bayar" class="form-control" min="0" value="0">
                </div>
                <div class="mb-3">
                    <label for="kembalian" class="form-label">Kembalian</label>
                    <input type="text" id="kembalian" class="form-control" readonly value="Rp 0">
                </div>
                <button type="button" id="proses_transaksi" class="btn btn-primary w-100 py-2" disabled>
                    <i class="fas fa-check"></i> Proses Transaksi
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
let keranjang = [];

$(document).ready(function() {
    // Tambah obat ke keranjang
    $('#tambah_obat').click(function() {
        const selectedObat = $('#search_obat option:selected');
        const obatId = selectedObat.val();
        const namaObat = selectedObat.data('nama');
        const harga = parseFloat(selectedObat.data('harga'));
        const stok = parseInt(selectedObat.data('stok'));
        const kodeObat = selectedObat.data('kode');
        const jumlah = parseInt($('#jumlah').val());

        if (!obatId) {
            alert('Pilih obat terlebih dahulu!');
            return;
        }

        if (jumlah < 1) {
            alert('Jumlah harus lebih dari 0!');
            return;
        }

        if (jumlah > stok) {
            alert('Stok tidak mencukupi! Stok tersedia: ' + stok);
            return;
        }

        // Cek apakah obat sudah ada di keranjang
        const existingItemIndex = keranjang.findIndex(item => item.obat_id == obatId);
        
        if (existingItemIndex !== -1) {
            // Update jumlah jika sudah ada
            keranjang[existingItemIndex].jumlah += jumlah;
            keranjang[existingItemIndex].subtotal = keranjang[existingItemIndex].jumlah * keranjang[existingItemIndex].harga_satuan;
        } else {
            // Tambah item baru
            keranjang.push({
                obat_id: obatId,
                kode_obat: kodeObat,
                nama_obat: namaObat,
                harga_satuan: harga,
                jumlah: jumlah,
                subtotal: harga * jumlah
            });
        }

        updateKeranjang();
        $('#search_obat').val('');
        $('#jumlah').val(1);
    });

    // Hapus item dari keranjang
    $(document).on('click', '.hapus-item', function() {
        const index = $(this).data('index');
        keranjang.splice(index, 1);
        updateKeranjang();
    });

    // Update kembalian saat input bayar berubah
    $('#bayar').on('input', function() {
        updateKembalian();
    });

    // Proses transaksi
    $('#proses_transaksi').click(function() {
        if (keranjang.length === 0) {
            alert('Keranjang belanja kosong!');
            return;
        }

        const bayar = parseFloat($('#bayar').val());
        const total = parseFloat($('#total').val().replace(/[^\d]/g, '')) / 100;

        if (isNaN(bayar) || bayar < total) {
            alert('Jumlah bayar kurang dari total belanja!');
            return;
        }

        if (confirm('Proses transaksi ini?')) {
            // Tampilkan loading
            $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Memproses...');

            $.ajax({
                url: '{{ route("transaksi.store") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    items: keranjang,
                    bayar: bayar
                },
                success: function(response) {
                    if (response.success) {
                        alert('Transaksi berhasil! Kode: ' + response.kode_transaksi);
                        window.location.href = '{{ route("transaksi.index") }}';
                    } else {
                        alert('Gagal: ' + response.message);
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Terjadi kesalahan';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    alert('Error: ' + errorMessage);
                },
                complete: function() {
                    $('#proses_transaksi').prop('disabled', false).html('<i class="fas fa-check"></i> Proses Transaksi');
                }
            });
        }
    });
});

function updateKeranjang() {
    const tbody = $('#keranjang_body');
    tbody.empty();

    let total = 0;

    keranjang.forEach((item, index) => {
        total += item.subtotal;
        tbody.append(`
            <tr>
                <td>${item.nama_obat}</td>
                <td>Rp ${formatRupiah(item.harga_satuan)}</td>
                <td>${item.jumlah}</td>
                <td>Rp ${formatRupiah(item.subtotal)}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger hapus-item" data-index="${index}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `);
    });

    $('#total_harga').text('Rp ' + formatRupiah(total));
    $('#total').val('Rp ' + formatRupiah(total));
    updateKembalian();
}

function updateKembalian() {
    const totalText = $('#total').val();
    const total = parseFloat(totalText.replace(/[^\d]/g, '')) || 0;
    const bayar = parseFloat($('#bayar').val()) || 0;
    const kembalian = bayar - total;

    $('#kembalian').val('Rp ' + formatRupiah(kembalian > 0 ? kembalian : 0));
    
    // Enable/disable proses transaksi button
    if (keranjang.length > 0 && bayar >= total && total > 0) {
        $('#proses_transaksi').prop('disabled', false);
    } else {
        $('#proses_transaksi').prop('disabled', true);
    }
}

function formatRupiah(angka) {
    return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
</script>
@endpush