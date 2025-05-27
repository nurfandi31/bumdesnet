<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amount extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'account_id',
        'tahun',
        'bulan',
        'debit',
        'kredit'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function eb()
    {
        return $this->hasOne(Ebudgeting::class, 'id', 'kode_akun');
    }
}
