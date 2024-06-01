<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BuktiAddModel extends Model
{
    use HasFactory;
    protected $table = 'bukti_pengajuan_prasejahtera';
    protected $guarded = [''];

    public function addPrasejahtera(): BelongsTo
    {
        return $this->belongsTo(SubmissionAddModel::class, 'id', 'add');
    }
}