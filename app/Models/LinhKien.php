<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinhKien extends Model
{
    use HasFactory;

    protected $table = 'linhkiensuachua'; // Tên bảng trong database
    protected $primaryKey = 'MaLinhKien'; // Khóa chính
    public $timestamps = false; // Không sử dụng created_at và updated_at

    protected $fillable = [
        'TenLinhKien',
        'MoTa',
        'SoLuong',
        'MaDonViTinh',
    ];
    public function nhaCungCaps()
    {
        return $this->belongsToMany(
            NhaCungCap::class,
            'nhacungcap_linhkien', // Tên bảng trung gian
            'MaLinhKien', // Khóa ngoại trong bảng trung gian trỏ đến LinhKien
            'MaNhaCungCap' // Khóa ngoại trong bảng trung gian trỏ đến NhaCungCap
        );
    }
    public function donViTinh()
    {
        return $this->belongsTo(DonViTinh::class, 'MaDonViTinh', 'MaDonViTinh');
    }
    public function chiTietPhieuNhap()
    {
        return $this->hasMany(ChiTietPhieuNhap::class, 'MaLinhKien', 'MaLinhKien');
    }
    public function chiTietPhieuXuat()
    {
        return $this->hasMany(ChiTietPhieuXuat::class, 'MaLinhKien', 'MaLinhKien');
    }
    public function chiTietPhieuBanGiaoNoiBo()
    {
        return $this->hasMany(ChiTietPhieuBanGiaoNoiBo::class, 'MaLinhKien', 'MaLinhKien');
    }
}