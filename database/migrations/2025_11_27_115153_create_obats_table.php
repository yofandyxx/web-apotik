<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('obats', function (Blueprint $table) {
            $table->id();
            $table->string('kode_obat')->unique();
            $table->string('nama_obat');
            $table->unsignedBigInteger('kategori_id'); // Hanya kolom, tanpa foreign key
            $table->decimal('harga_beli', 10, 2);
            $table->decimal('harga_jual', 10, 2);
            $table->integer('stok');
            $table->integer('stok_minimal');
            $table->date('expired_date');
            $table->text('deskripsi')->nullable();
            $table->string('satuan');
            $table->timestamps();

            // Hanya index, TANPA foreign key constraint
            $table->index('kategori_id');
        });

        // TAMBAHKAN foreign key manual SETELAH semua table dibuat
        // Ini akan dijalankan manual via seeder atau command
    }

    public function down(): void
    {
        Schema::dropIfExists('obats');
    }
};