<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResidentModel extends Model
{
    use HasFactory;
    protected $table = 'warga';
    protected $primaryKey = 'NIK';

    protected $guarded = [''];

    public function family(): BelongsTo
    {
        return $this->belongsTo(FamilyModel::class, 'noKK', 'noKK');
    }

    public function temporaryResident()
    {
        return $this->hasOne(TemporaryResident::class, 'NIK_warga_sementara', 'NIK');
    }
}