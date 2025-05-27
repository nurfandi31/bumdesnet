<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Awobaz\Compoships\Compoships;

class Account extends Model
{
    use HasFactory, Compoships;
    protected $guarded = ['id'];

    public function amount()
    {
        return $this->hasMany(Amount::class, 'account_id');
    }

    public function oneAmount()
    {
        return $this->hasOne(Amount::class, 'account_id');
    }

    public function trx_debit()
    {
        return $this->hasMany(Transaction::class, 'rekening_debit', 'id');
    }

    public function trx_kredit()
    {
        return $this->hasMany(Transaction::class, 'rekening_kredit', 'id');
    }

    public function rek_debit()
    {
        return $this->hasMany(Transaction::class, 'rekening_debit');
    }

    public function rek_kredit()
    {
        return $this->hasMany(Transaction::class, 'rekening_kredit');
    }

    public function saldo()
    {
        return $this->hasOne(Amount::class, 'id', 'kode_akun');
    }

    public function inventory()
    {
        return $this->hasMany(Inventory::class, ['jenis', 'kategori'], ['lev3', 'lev4']);
    }

    public function eb()
    {
        return $this->hasOne(Ebudgeting::class, 'account_id');
    }
}
