<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

    use HasFactory;
    protected $table = 'menu';

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    // Relasi ke child menu
    public function child()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }

    public function subchild()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }
}
