<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PhieuThanhLy extends Model
{
    use HasFactory;
    protected $table = 'phieuthanhly';
    protected $primaryKey = 'MaPhieuThanhLy';
    public $timestamps = true;
    protected $fillable = [
        'NgayLapPhieu',
        'MaNhanVien',
        'MaMay',
        'GiaTriBanDau',
        'GiaTriConLai',
        'DanhGia',
        'GhiChu',
        'TrangThai',
        'MaNhanVienDuyet',
        'MaHienThi',
    ];
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($phieuThanhLy) {
            $now = Carbon::now();
            $phieuThanhLy->MaHienThi = 'PTL' . $now->format('ymd-His');
        });
    }
    public function may()
    {
        return $this->belongsTo(May::class, 'MaMay', 'MaMay');
    }
    public function nhanVien()
    {
        return $this->belongsTo(NhanVien::class, 'MaNhanVien', 'MaNhanVien');
    }
    public function nhanVienDuyet()
    {
        return $this->belongsTo(NhanVien::class, 'MaNhanVienDuyet', 'MaNhanVien');
    }
}
