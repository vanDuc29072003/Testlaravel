<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietPhieuNhap extends Model
{
    use HasFactory;

    protected $table = 'chitietphieunhap'; // Tên bảng trong database
    protected $primaryKey = 'MaChiTietPhieuNhap'; // Khóa chính
    public $timestamps = true;

    protected $fillable = [
        'MaPhieuNhap',
        'MaLinhKien',
        'SoLuong',
        'GiaNhap',
        'TongCong',
    ];
        public function phieuNhap()
    {
        return $this->belongsTo(PhieuNhap::class, 'MaPhieuNhap', 'MaPhieuNhap');
    }

    public function linhKien()
    {
        return $this->belongsTo(LinhKien::class, 'MaLinhKien', 'MaLinhKien');
    }
}
