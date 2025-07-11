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

        $nomor = 1;
        $menuInsert = [];
        foreach ($menu as $m) {
            $menuInsert[] = [
                "id" => $nomor,
                "parent_id" => "0",
                "urutan_menu" => $m['urutan_menu'],
                "title" => $m['title'],
                "icon" => $m['icon'],
                "link" => $m['link'],
                "status" => $m['status'],
            ];

            $parent_id = $nomor;
            $nomor++;
            if (isset($m['child'])) {
                foreach ($m['child'] as $child) {
                    $menuInsert[] = [
                        "id" => $nomor,
                        "parent_id" => $parent_id,
                        "urutan_menu" => $child['urutan_menu'],
                        "title" => $child['title'],
                        "icon" => $child['icon'],
                        "link" => $child['link'],
                        "status" => $child['status'],
                    ];

                    $sub_parent_id = $nomor;
                    $nomor++;
                    if (isset($child['child'])) {
                        foreach ($child['child'] as $sub_child) {
                            $menuInsert[] = [
                                "id" => $nomor,
                                "parent_id" => $sub_parent_id,
                                "urutan_menu" => $sub_child['urutan_menu'],
                                "title" => $sub_child['title'],
                                "icon" => $sub_child['icon'],
                                "link" => $sub_child['link'],
                                "status" => $sub_child['status'],
                            ];
                            $nomor++;
                        }
                    }
                }
            }
        }

        Menu::insert($menuInsert);
    }
}
