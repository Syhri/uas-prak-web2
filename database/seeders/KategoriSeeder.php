<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            [
                'nama' => 'Sarapan',
                'deskripsi' => 'Resep-resep untuk sarapan pagi yang lezat dan bergizi.'
            ],
            [
                'nama' => 'Makan Siang',
                'deskripsi' => 'Resep-resep untuk makan siang yang praktis dan mengenyangkan.'
            ],
            [
                'nama' => 'Makan Malam',
                'deskripsi' => 'Resep-resep untuk makan malam yang spesial dan nikmat.'
            ],
            [
                'nama' => 'Camilan',
                'deskripsi' => 'Resep-resep camilan yang cocok untuk menemani waktu santai.'
            ],
            [
                'nama' => 'Minuman',
                'deskripsi' => 'Resep-resep minuman segar dan menyehatkan untuk berbagai kesempatan.'
            ],
            [
                'nama' => 'Kue & Dessert',
                'deskripsi' => 'Resep-resep kue dan makanan penutup yang manis dan lezat.'
            ],
            [
                'nama' => 'Makanan Tradisional',
                'deskripsi' => 'Resep-resep makanan tradisional dari berbagai daerah di Indonesia.'
            ],
            [
                'nama' => 'Makanan Sehat',
                'deskripsi' => 'Resep-resep makanan sehat dan bergizi untuk gaya hidup sehat.'
            ],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create([
                'nama' => $kategori['nama'],
                'slug' => Str::slug($kategori['nama']),
                'deskripsi' => $kategori['deskripsi'],
            ]);
        }
    }
}
