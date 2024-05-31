<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BuktiEditModel extends Model
{
    use HasFactory;
    protected $table = 'bukti_pengajuan_edit_data_warga';
    protected $guarded = [''];

    public function editWarga(): BelongsTo
    {
        return $this->belongsTo(SubmissionChangesModel::class, 'id', 'edit');
    }
}
