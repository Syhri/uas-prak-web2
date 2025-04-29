<?php

namespace Database\Seeders;

use App\Models\Daerah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DaerahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $daerahs = [
            [
                'nama' => 'Jawa',
                'deskripsi' => 'Masakan khas dari pulau Jawa yang kaya akan rempah dan cita rasa.'
            ],
            [
                'nama' => 'Sumatera',
                'deskripsi' => 'Masakan khas dari pulau Sumatera yang terkenal dengan rasa pedas dan gurihnya.'
            ],
            [
                'nama' => 'Kalimantan',
                'deskripsi' => 'Masakan khas dari pulau Kalimantan yang unik dan kaya akan rasa.'
            ],
            [
                'nama' => 'Sulawesi',
                'deskripsi' => 'Masakan khas dari pulau Sulawesi yang terkenal dengan seafood dan rempahnya.'
            ],
            [
                'nama' => 'Bali',
                'deskripsi' => 'Masakan khas dari pulau Bali yang kaya akan rempah dan cita rasa yang khas.'
            ],
            [
                'nama' => 'Papua',
                'deskripsi' => 'Masakan khas dari Papua yang unik dan kaya akan rasa lokal.'
            ],
        ];

        foreach ($daerahs as $daerah) {
            Daerah::create([
                'nama' => $daerah['nama'],
                'slug' => Str::slug($daerah['nama']),
                'deskripsi' => $daerah['deskripsi'],
            ]);
        }
    }
}
