<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhieuBanGiaoNoiBo extends Model
{
    use HasFactory;

    protected $table = 'phieubangiaonoibo';
    protected $primaryKey = 'MaPhieuBanGiaoNoiBo';
    public $timestamps = false;
    protected $fillable = [
        'MaPhieuBanGiaoNoiBo',
        'MaLichSuaChua',
        'ThoiGianBanGiao',
        'BienPhapXuLy',   
        'GhiChu',   
        'MaNhanVienTao'
    ];
    public function chiTietPhieuBanGiaoNoiBo()
    {
        return $this->hasMany(ChiTietPhieuBanGiaoNoiBo::class, 'MaPhieuBanGiaoNoiBo', 'MaPhieuBanGiaoNoiBo');
    }

    // Quan hệ đến bảng lịch sửa chữa
    public function lichSuaChua()
    {
        return $this->belongsTo(LichSuaChua::class, 'MaLichSuaChua', 'MaLichSuaChua');
    }
    public function nhanVienTao()
    {
        return $this->belongsTo(NhanVien::class, 'MaNhanVienTao', 'MaNhanVien');
    }
}
