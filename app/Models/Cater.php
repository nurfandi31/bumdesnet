<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cater extends Model
{
    use HasFactory;
    // protected $fillable = ['nama', 'jabatan', 'alamat','telpon','jenis_kelamin'];
    protected $guarded = ['id']; //kebalikan $fillable

    public function position()
    {
        return $this->belongsTo(Position::class, 'jabatan', 'id');
    }
}
