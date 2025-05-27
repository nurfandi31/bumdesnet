<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Utils\Tanggal;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class Customer extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function keluarga()
    {
        return $this->belongsTo(Family::class, 'hubungan', 'id');
    }

    public function installation()
    {
        return $this->hasMany(Installations::class, 'customer_id', 'id');
    }

    public function village()
    {
        return $this->belongsTo(Village::class, 'desa', 'id');
    }
}
