<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubmissionChangesModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'pengajuaneditdatawarga';
    protected $guarded = [''];

    public function resident(): BelongsTo
    {
        return $this->belongsTo(ResidentModel::class, 'NIK', 'NIK');
    }
}
