<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LichBaoTri extends Model
{
    use HasFactory;
    protected $table = 'lichbaotri';
    protected $fillable = [
        'MaLichBaoTri',
        'MoTa',
        'NgayBaoTri',
        'MaMay'
    ];
    function may()
    {
        return $this->belongsTo(May::class, 'MaMay', 'MaMay');
    }
}
