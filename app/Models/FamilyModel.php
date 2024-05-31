<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class FamilyModel extends Model
{
    use HasFactory;
    protected $table = 'keluarga';
    protected $primaryKey = 'noKK';

    protected $guarded = [''];

    protected $casts = [
        'noKK' => 'string',
    ];

    public function warga(): HasMany
    {
        return $this->hasMany(ResidentModel::class, 'noKK', 'noKK');
    }

    public function poorFamily(): HasOne
    {
        return $this->hasOne(PoorFamilyModel::class, 'noKK', 'noKK');
    }
}
