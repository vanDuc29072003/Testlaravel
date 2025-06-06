<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PhieuXuat extends Model
{
    use HasFactory;

    protected $table = 'phieuxuat'; // Tên bảng trong database
    protected $primaryKey = 'MaPhieuXuat'; // Khóa chính
    public $timestamps = false; // Không sử dụng created_at và updated_at

    protected $fillable = [
        'NgayXuat',
        'TongSoLuong',
        'GhiChu',
        'MaNhanVienTao',
        'MaNhanVienNhan',
        'MaHienThi',
    ];

    protected static function boot()
    {
        parent::boot();

       
        static::creating(function ($phieuXuat) {
            $now = Carbon::now(); 
            $phieuXuat->MaHienThi = 'PX' . $now->format('ymd-His'); 
        });
    }

    public function nhanVienTao()
    {
        return $this->belongsTo(NhanVien::class, 'MaNhanVienTao', 'MaNhanVien');
    }
    public function nhanVienNhan()
{
    return $this->belongsTo(NhanVien::class, 'MaNhanVienNhan', 'MaNhanVien');
}
    public function chiTietPhieuXuat()
    {
        return $this->hasMany(chiTietPhieuXuat::class, 'MaPhieuXuat', 'MaPhieuXuat');
    }
}
