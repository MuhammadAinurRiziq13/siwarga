<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmissionLetterModel extends Model
{
    use HasFactory;
    protected $table = 'pengajuansuratpengantar';
    protected $guarded = [''];

    public function resident()
    {
        return $this->hasOne(ResidentModel::class, 'NIK', 'NIK');
    }
}
