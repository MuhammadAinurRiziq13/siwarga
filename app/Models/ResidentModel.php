<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ResidentModel extends Model
{
    use HasFactory;
    protected $table = 'warga';
    protected $primaryKey = 'NIK';

    protected $guarded = [''];

    protected $casts = [
        'NIK' => 'string',
    ];

    public function family(): BelongsTo
    {
        return $this->belongsTo(FamilyModel::class, 'noKK', 'noKK');
    }

    public function temporaryResident()
    {
        return $this->hasOne(TemporaryResident::class, 'NIK_warga_sementara', 'NIK');
    }

    public function submissionChanges(): HasMany
    {
        return $this->hasMany(SubmissionChangesModel::class, 'NIK', 'NIK');
    }

    public function submissionLetter(): HasOne
    {
        return $this->hasOne(SubmissionLetterModel::class, 'NIK', 'NIK');
    }
}
