<?php

namespace Database\Seeders;

use App\Models\Tenant\JenisLaporan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisLaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = public_path('seeder/jenis_laporan.json');
        $jenis_laporan = json_decode(file_get_contents($path), true);

        JenisLaporan::insert($jenis_laporan);
    }
}
