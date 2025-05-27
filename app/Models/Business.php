<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function amount()
    {
        return $this->hasMany(Amount::class);
    }

    public function setting()
    {
        return $this->hasOne(Settings::class);
    }
}
