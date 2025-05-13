<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LichVanHanh extends Model
{
    use HasFactory;
    
    
    protected $table = 'lichvanhanh';
    protected $primaryKey = 'MaLichVanHanh';
    protected $fillable = [
        'MaMay',
        'MaNhanVien',
        'MoTa',
        'NgayVanHanh',
        'MaMay',
        'CaLamViec',
        'NhatKi',
        'trangthai'
    ];
    function may()
    {
        return $this->belongsTo(May::class, 'MaMay', 'MaMay');
    }
    function nhanVien()
    {
        return $this->belongsTo(NhanVien::class, 'MaNhanVien', 'MaNhanVien');
    }
}
