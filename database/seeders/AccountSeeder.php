<?php

namespace Database\Seeders;

use App\Models\Tenant\Account;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
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
}
