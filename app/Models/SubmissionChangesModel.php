<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmissionChangesModel extends Model
{
    use HasFactory;
    protected $table = 'pengajuaneditdatawarga';
    protected $guarded = [''];

    public function resident()
    {
        return $this->belongsTo(ResidentModel::class, 'NIK', 'NIK_pengajuan');
    }
}