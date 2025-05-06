<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhanQuyen extends Model
{
    protected $table = 'phanquyen';
    protected $primaryKey = 'MaPhanQuyen';
    public $timestamps = false;

    protected $fillable = [
        'TenPhanQuyen'
    ];

    public function boPhans()
    {
        return $this->belongsToMany(BoPhan::class, 'phanquyen_bophan', 'MaPhanQuyen', 'MaBoPhan');
    }
}
