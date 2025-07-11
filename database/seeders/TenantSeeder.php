<?php

namespace Database\Seeders;

use App\Models\Tenant\Account;
use App\Models\Tenant\AkunLevel1;
use App\Models\Tenant\AkunLevel2;
use App\Models\Tenant\AkunLevel3;
use App\Models\Tenant\Business;
use App\Models\Tenant\JenisLaporan;
use App\Models\Tenant\MasterArusKas;
use App\Models\Tenant\Menu;
use App\Models\Tenant\Position;
use App\Models\Tenant\Region;
use App\Models\Tenant\Settings;
use App\Models\Tenant\Tombol;
use App\Models\Tenant\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->account();
        $this->akun_level_1();
        $this->akun_level_2();
        $this->akun_level_3();
        $this->jenis_laporan();
        $this->master_arus_kas();
        $this->menu();
        $this->position();
        $this->region();
        $this->tombol();

        // BUSINESS
        Business::create([
            'nama' => 'Bumdes.NET',
            'describe' => 'Unit Internet Service',
            'desa' => '-',
            'alamat' => '-',
            'telpon' => '628',
            'nomor_bh' => '-',
            'email' => 'example@gmail.com',
            'domain' => json_encode(["https://example.com"]),
            'tgl_pakai' => date('Y-m-d'),
            'logo' => 'default.png',
            'token' => '-',
        ]);

        // SETTING
        Settings::create([
            'business_id' => '1',
            'swit_tombol' => '1',
            'swit_tombol_trx' => '1',
            'block' => '0',
            'abodemen' => '10000',
            'pasang_baru' => '150000',
            'denda' => '20000',
            'tanggal_toleransi' => '1',
            'tanggal_hitung' => '1',
            'batas_tagihan' => '31',
            'pesan_tagihan' => '-',
            'pesan_pembayaran' => '-',
        ]);

        // USER
        User::create([
            'business_id' => '1',
            'nama' => 'Direktur',
            'jenis_kelamin' => 'L',
            'alamat' => '-',
            'telpon' => '628',
            'jabatan' => '1',
            'foto' => 'direktur.png',
            'username' => 'direktur',
            'password' => Hash::make('direktur'),
            'remember_token' => '-',
            'auth_token' => md5('direktur'),
            'akses_menu' => json_encode([]),
            'akses_tombol' => json_encode([]),
        ]);
    }

    public function account()
    {
        $path = public_path('seeder/accounts.json');
        $accounts = json_decode(file_get_contents($path), true);

        $nomor = 1;
        $account = [];
        foreach ($accounts as $acc) {
            $rowAccount = $acc;
            $rowAccount['id'] = $nomor;
            $rowAccount['tgl_nonaktif'] = ($acc['tgl_nonaktif']) ? $acc['tgl_nonaktif'] : date('Y-m-d');

            $account[] = $rowAccount;
            $nomor++;
        }

        Account::insert($account);
    }

    public function akun_level_1()
    {
        $path = public_path('seeder/akun_level_1.json');
        $akun_level_1 = json_decode(file_get_contents($path), true);

        AkunLevel1::insert($akun_level_1);
    }

    public function akun_level_2()
    {
        $path = public_path('seeder/akun_level_2.json');
        $akun_level_2 = json_decode(file_get_contents($path), true);

        AkunLevel2::insert($akun_level_2);
    }

    public function akun_level_3()
    {
        $path = public_path('seeder/akun_level_3.json');
        $akun_level_3 = json_decode(file_get_contents($path), true);

        AkunLevel3::insert($akun_level_3);
    }

    public function jenis_laporan()
    {
        $path = public_path('seeder/jenis_laporan.json');
        $jenis_laporan = json_decode(file_get_contents($path), true);

        JenisLaporan::insert($jenis_laporan);
    }

    public function master_arus_kas()
    {
        $path = public_path('seeder/master_arus_kas.json');
        $master_arus_kas = json_decode(file_get_contents($path), true);

        MasterArusKas::insert($master_arus_kas);
    }

    public function menu()
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

    public function position()
    {
        $path = public_path('seeder/positions.json');
        $position = json_decode(file_get_contents($path), true);

        Position::insert($position);
    }

    public function region()
    {
        $path = public_path('seeder/regions.json');
        $region = json_decode(file_get_contents($path), true);

        $chunks = array_chunk($region, 500);
        foreach ($chunks as $chunk) {
            Region::insert($chunk);
        }
    }

    public function tombol()
    {
        $path = public_path('seeder/tombol.json');
        $tombol = json_decode(file_get_contents($path), true);

        Tombol::insert($tombol);
    }
}
