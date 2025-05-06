<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhanQuyen_Bophan extends Model
{
    protected $table = 'phanquyen_bophan';
    public $timestamps = false;

    protected $fillable = [
        'MaPhanQuyen',
        'MaBoPhan'
    ];

    public function phanQuyen()
    {
        return $this->belongsTo(PhanQuyen::class, 'MaPhanQuyen', 'MaPhanQuyen');
    }

    public function boPhan()
    {
        return $this->belongsTo(BoPhan::class, 'MaBoPhan', 'MaBoPhan');
    }
}
