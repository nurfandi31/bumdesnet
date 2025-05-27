<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Awobaz\Compoships\Compoships;

class Inventory extends Model
{
    use HasFactory, Compoships;
    protected $guarded = ['id'];
}
