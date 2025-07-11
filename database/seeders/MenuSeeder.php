<?php

namespace Database\Seeders;

use App\Models\Tenant\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = public_path('seeder/menu.json');
        $menu = json_decode(file_get_contents($path), true);

        Menu::insert($menu);
    }
}
