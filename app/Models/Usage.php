<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usage extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    public function installation()
    {
        return $this->belongsTo(Installations::class, 'id_instalasi', 'id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }

    public function customers()
    {
        return $this->belongsTo(Customer::class, 'customer', 'id');
    }
    
    public function usersCater()
    {
        return $this->belongsTo(user::class, 'cater', 'id');
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'usage_id');
    }

    public function usage()
    {
        return $this->hasMany(Usage::class, 'id_instalasi', 'id');
    }
}
