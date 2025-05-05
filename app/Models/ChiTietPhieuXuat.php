<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chiTietPhieuXuat extends Model
{
    use HasFactory;

    protected $table = 'chitietphieuxuat'; // Tên bảng trong database
    protected $primaryKey = 'MaChiTietPhieuXuat'; // Khóa chính
    public $timestamps = true;

    protected $fillable = [
        'MaPhieuXuat',
        'MaLinhKien',
        'SoLuong',
    ];
        public function phieuXuat()
    {
        return $this->belongsTo(PhieuXuat::class, 'MaPhieuXuat', 'MaPhieuXuat');
    }

    public function linhKien()
    {
        return $this->belongsTo(LinhKien::class, 'MaLinhKien', 'MaLinhKien');
    }
}
