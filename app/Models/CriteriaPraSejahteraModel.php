<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriteriaPraSejahteraModel extends Model
{
    use HasFactory;

    protected $table = 'criteriaprasejahtera'; // Sesuaikan dengan nama tabel yang Anda gunakan
    protected $primaryKey = 'id';
    protected $guarded = [];

    // Relationship with KeluargaPraSejahtera model
    // public function keluargaPraSejahtera()
    // {
    //     return $this->belongsTo(KeluargaPraSejahtera::class, 'noKK', 'noKK');
    // }
}
