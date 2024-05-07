<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmissionAddModel extends Model
{
    use HasFactory;
    protected $table = 'pengajuankeluargakurangmampu';
    protected $guarded = [''];

    public function Family()
    {
        return $this->hasOne(FamilyModel::class, 'noKK', 'noKK_pengajuan');
    }
}