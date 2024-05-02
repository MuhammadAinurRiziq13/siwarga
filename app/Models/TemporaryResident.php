<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TemporaryResident extends Model
{
    use HasFactory;
    protected $table = 'wargasementara';
    protected $guarded = [''];

    public function resident()
    {
        return $this->hasOne(ResidentModel::class, 'NIK', 'NIK_warga_sementara');
    }
}
