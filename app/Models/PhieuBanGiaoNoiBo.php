<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhieuBanGiaoNoiBo extends Model
{
    use HasFactory;

    protected $table = 'phieubangiaonoibo';
    protected $primaryKey = 'MaPhieuBanGiaoNoiBo';
    public $timestamps = true;
    protected $fillable = [
        'MaNhanVien',
        'MaLichSuaChua',
        'ThoiGianBanGiao',
        'BienPhapXuLy',   
        'GhiChu',   
    ];
    public function nhanVien()
    {
        return $this->belongsTo(NhanVien::class, 'MaNhanVien', 'MaNhanVien');
    }

    // Quan hệ đến bảng lịch sửa chữa
    public function lichSuaChua()
    {
        return $this->belongsTo(LichSuaChua::class, 'MaLichSuaChua', 'MaLichSuaChua');
    }
}
