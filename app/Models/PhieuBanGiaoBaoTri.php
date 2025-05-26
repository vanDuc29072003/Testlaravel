<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhieuBanGiaoBaoTri extends Model
{
    use HasFactory;

    protected $table = 'phieubangiaobaotri';
    protected $primaryKey = 'MaPhieuBanGiaoBaoTri';
    public $timestamps = false;
    protected $fillable = [
        'MaPhieuBanGiaoBaoTri',
        'MaLichBaoTri',     
        'ThoiGianBanGiao',
        'MaNhanVien',
        'TongTien',
        'LuuY',   
        
    ];
  

    // Quan hệ đến bảng lịch sửa chữa
    public function lichBaoTri()
    {
        return $this->belongsTo(LichBaoTri::class, 'MaLichBaoTri'); // Đảm bảo rằng 'MaLichSuaChua' là khóa ngoại trong bảng PhieuBanGiaoSuaChuaNCC
    }
    public function nhanVien()
    {
        return $this->belongsTo(NhanVien::class, 'MaNhanVien', 'MaNhanVien');
    }

    public function chiTietPhieuBanGiaoBaoTri()
    {
        return $this->hasMany(ChiTietPhieuBanGiaoBaoTri::class, 'MaPhieuBanGiaoBaoTri', 'MaPhieuBanGiaoBaoTri');
    }
}
