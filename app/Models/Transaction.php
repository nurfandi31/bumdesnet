<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function package()
    {
        return $this->belongsTo(Package::class);
    }
    public function village()
    {
        return $this->belongsTo(Village::class, 'desa');
    }
    public function usage()
    {
        return $this->hasOne(Usage::class, 'kode_instalasi', 'id');
    }
    public function Usages()
    {
        return $this->belongsTo(Usage::class, 'usage_id', 'id');
    }
    public function Installations()
    {
        return $this->belongsTo(Installations::class, 'installation_id', 'id');
    }
    public function Account()
    {
        return $this->belongsTo(Account::class, 'kode_akun', 'id');
    }
    public function JenisTransactions()
    {
        return $this->belongsTo(JenisTransactions::class);
    }
    public function Business()
    {
        return $this->belongsTo(Business::class);
    }
    public function Inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
    public function User()
    {
        return $this->belongsTo(User::class);
    }
    public function rek_debit()
    {
        return $this->belongsTo(Account::class, 'rekening_debit', 'id');
    }
    public function rek_kredit()
    {
        return $this->belongsTo(Account::class, 'rekening_kredit', 'id');
    }

    public function acc_debit()
    {
        return $this->belongsTo(Account::class, 'rekening_debit');
    }

    public function acc_kredit()
    {
        return $this->belongsTo(Account::class, 'rekening_kredit');
    }
    public function settings()
    {
        return $this->hasOne(Settings::class, 'business_id', 'business_id');
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'transaction_id', 'transaction_id');
    }
}
