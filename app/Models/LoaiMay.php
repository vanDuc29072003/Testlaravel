<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoaiMay extends Model
{
    use HasFactory;
    protected $table = 'loaimay'; 
    protected $primaryKey = 'MaLoai';

    public $timestamps = false;
    protected $fillable = [
        'TenLoai', 
        'MoTa', 
    ];
    public function mays()
    {
        return $this->hasMany(May::class, 'MaLoai', 'MaLoai');
    }
}
