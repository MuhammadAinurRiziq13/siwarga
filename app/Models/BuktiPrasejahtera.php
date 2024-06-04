<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BuktiPrasejahtera extends Model
{
    use HasFactory;
    protected $table = 'bukti_prasejahtera';
    protected $guarded = [''];

    public function Prasejahtera(): BelongsTo
    {
        return $this->belongsTo(PoorFamilyModel::class, 'id', 'bukti');
    }
}