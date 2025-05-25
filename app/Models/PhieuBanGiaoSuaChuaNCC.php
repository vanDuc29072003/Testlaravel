<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhieuBanGiaoSuaChuaNCC extends Model
{
    use HasFactory;

    protected $table = 'phieubangiaosuachuanhacungcap';
    protected $primaryKey = 'MaPhieuBanGiaoSuaChua';
    public $timestamps = false;
    protected $fillable = [
        'MaPhieuBanGiaoSuaChua',
        'MaNhaCungCap',
        'MaLichSuaChua',
        'ThoiGianBanGiao',
        'BienPhapXuLy',
        'TongTien',  
        'GhiChu',
        'MaNhanVienTao'
    ];
    public function nhaCungCap()
    {
        return $this->belongsTo(NhaCungCap::class, 'MaNhaCungCap', 'MaNhaCungCap');
    }

    // Quan hệ đến bảng lịch sửa chữa
    public function lichSuaChua()
    {
        return $this->belongsTo(LichSuaChua::class, 'MaLichSuaChua'); // Đảm bảo rằng 'MaLichSuaChua' là khóa ngoại trong bảng PhieuBanGiaoSuaChuaNCC
    }

    // Quan hệ với YeuCauSuaChua thông qua LichSuaChua
    public function yeuCauSuaChua()
    {
        return $this->hasOneThrough(YeuCauSuaChua::class, LichSuaChua::class, 'MaLichSuaChua', 'MaYeuCauSuaChua', 'MaLichSuaChua', 'MaYeuCauSuaChua');
    }
    public function chiTietPhieuBanGiaoSuaChuaNCC()
    {
        return $this->hasMany(ChiTietPhieuSuaNCC::class, 'MaPhieuBanGiaoSuaChua', 'MaPhieuBanGiaoSuaChua');
    }
    public function nhanVienTao()
    {
        return $this->belongsTo(NhanVien::class, 'MaNhanVienTao', 'MaNhanVien');
    }
}
