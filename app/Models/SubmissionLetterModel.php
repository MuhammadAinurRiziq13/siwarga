<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubmissionLetterModel extends Model
{
    use HasFactory;
    protected $table = 'pengajuansuratpengantar';
    protected $guarded = [''];
    protected $primaryKey = 'id';

    public function resident(): BelongsTo
    {
        return $this->belongsTo(ResidentModel::class, 'NIK', 'NIK');
    }
}
