<?php

namespace Database\Seeders;

use App\Models\Tenant\Tombol;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TombolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = public_path('seeder/tombol.json');
        $tombol = json_decode(file_get_contents($path), true);

        Tombol::insert($tombol);
    }
}
