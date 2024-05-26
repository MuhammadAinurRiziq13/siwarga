<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmissionAddModel extends Model
{
    use HasFactory;
    protected $table = 'pengajuanprasejahtera';
    protected $guarded = [''];

    public function family()
    {
        return $this->belongsTo(FamilyModel::class, 'noKK', 'noKK');
    }
}
