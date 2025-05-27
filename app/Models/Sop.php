<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sop extends Model
{
    use HasFactory;

    public function settings()
    {
        return $this->belongsTo(Settings::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
