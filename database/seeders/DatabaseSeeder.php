<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Obat;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Users
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@tokoobat.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Kasir',
            'email' => 'user@tokoobat.com', 
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Kategoris
        $kategoris = [
            ['nama_kategori' => 'Analgesik', 'deskripsi' => 'Obat pereda nyeri'],
            ['nama_kategori' => 'Antibiotik', 'deskripsi' => 'Obat pembunuh bakteri'],
            ['nama_kategori' => 'Vitamin', 'deskripsi' => 'Suplemen vitamin'],
            ['nama_kategori' => 'Antasida', 'deskripsi' => 'Obat maag dan lambung'],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }

        // Obats
        $obats = [
            [
                'kode_obat' => 'OBT001',
                'nama_obat' => 'Paracetamol 500mg',
                'kategori_id' => 1,
                'harga_beli' => 5000,
                'harga_jual' => 8000,
                'stok' => 100,
                'stok_minimal' => 10,
                'expired_date' => now()->addYear(),
                'satuan' => 'Tablet',
                'deskripsi' => 'Obat pereda demam dan nyeri'
            ],
            // ... tambahkan data lainnya
        ];

        foreach ($obats as $obat) {
            Obat::create($obat);
        }
    }
}