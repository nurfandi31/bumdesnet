<?php

namespace Database\Seeders;

use App\Models\Tenant\MasterArusKas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterArusKasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = public_path('seeder/master_arus_kas.json');
        $master_arus_kas = json_decode(file_get_contents($path), true);

        MasterArusKas::insert($master_arus_kas);
    }
}
