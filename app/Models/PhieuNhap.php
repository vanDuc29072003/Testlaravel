<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PhieuNhap extends Model
{
    use HasFactory;

    protected $table = 'phieunhapkho'; // Tên bảng trong database
    protected $primaryKey = 'MaPhieuNhap'; // Khóa chính
    public $timestamps = false; // Không sử dụng created_at và updated_at

    protected $fillable = [
        'NgayNhap',
        'TongSoLuong',
        'TongTien',
        'GhiChu',
        'MaNhanVien',
        'MaNhaCungCap',
        'TrangThai',
        'MaNhanVienDuyet',
        'MaHienThi',
    ];
    protected static function boot()
    {
        parent::boot();

        // Sự kiện `creating` để tạo mã phiếu nhập
        static::creating(function ($phieuNhap) {
            $now = Carbon::now(); 
            $phieuNhap->MaHienThi = 'PN' . $now->format('ymd-His');
        });
    }
    public function nhaCungCap()
    {
        return $this->belongsTo(NhaCungCap::class, 'MaNhaCungCap', 'MaNhaCungCap');
    }
    public function nhanVien()
    {
        return $this->belongsTo(NhanVien::class, 'MaNhanVien', 'MaNhanVien');
    }

    public function chiTietPhieuNhap()
    {
        return $this->hasMany(ChiTietPhieuNhap::class, 'MaPhieuNhap', 'MaPhieuNhap');
    }
    public function nhanVienDuyet()
    {
        return $this->belongsTo(NhanVien::class, 'MaNhanVienDuyet', 'MaNhanVien');
    }
}
