<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YeuCauSuaChua extends Model
{
    use HasFactory;
    protected  $table = 'yeucausuachua'; 
    protected $fillable = [
        'MaMay',
        'MaNhanVienYeuCau',
        'ThoiGianYeuCau',
        'MoTa',
        'TrangThai',
    ];
    function may()
    {
        return $this->belongsTo(May::class, 'MaMay', 'MaMay');
    }
    function nhanvienyeucau()
    {
        return $this->belongsTo(NhanVien::class, 'MaNhanVienYeuCau', 'MaNhanVien');
    }
}
