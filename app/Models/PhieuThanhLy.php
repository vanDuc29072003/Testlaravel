<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];
    public function may()
    {
        return $this->belongsTo(May::class, 'MaMay', 'MaMay');
    }
    public function nhanVien()
    {
        return $this->belongsTo(NhanVien::class, 'MaNhanVien', 'MaNhanVien');
    }
}
