<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PhieuTra extends Model
{
    use HasFactory;

    protected $table = 'phieutra'; // Tên bảng trong database
    protected $primaryKey = 'MaPhieuTra'; // Khóa chính
    public $timestamps = false; // Không sử dụng created_at và updated_at

    protected $fillable = [
        'NgayTra',
        'TongSoLuong',
        'GhiChu',
        'MaNhanVienTao',
        'MaNhanVienTra',
        'MaHienThi',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($phieuTra) {
            $now = Carbon::now();
            $phieuTra->MaHienThi = 'PT' . $now->format('ymd-His');
        });
    }

    public function nhanVienTao()
    {
        return $this->belongsTo(NhanVien::class, 'MaNhanVienTao', 'MaNhanVien');
    }
    public function nhanVienTra()
    {
        return $this->belongsTo(NhanVien::class, 'MaNhanVienTra', 'MaNhanVien');
    }
    public function chiTietPhieuTra()
    {
        return $this->hasMany(chiTietPhieuTra::class, 'MaPhieuTra', 'MaPhieuTra');
    }
}
