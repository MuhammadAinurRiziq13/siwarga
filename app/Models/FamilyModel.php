<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FamilyModel extends Model
{
    use HasFactory;
    protected $table = 'keluarga';
    protected $primaryKey = 'noKK';

    protected $guarded = [''];

    public function warga(): HasMany
    {
        return $this->hasMany(ResidentModel::class, 'noKK', 'noKK');
    }
}
