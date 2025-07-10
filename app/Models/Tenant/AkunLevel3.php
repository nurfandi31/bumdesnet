<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkunLevel3 extends Model
{
    use HasFactory;
    protected $table = 'akun_level_3';

    public $timestamps = false;

    protected $primaryKey = 'kode_akun';
    protected $keyType = 'string';

    public function accounts()
    {
        return $this->hasMany(Account::class, 'parent_id', 'id')->orderBy('kode_akun', 'ASC');
    }
}
