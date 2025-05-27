<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'kode', 'desa');
    }

    public function installations()
    {
        return $this->hasMany(Installations::class);
    }

    public function saldo()
    {
        return $this->hasOne(Amount::class);
    }
}
