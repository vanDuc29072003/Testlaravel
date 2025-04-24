<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chiTietPhieuTra extends Model
{
    use HasFactory;

    protected $table = 'chitietphieutra'; // Tên bảng trong database
    protected $primaryKey = 'MaChiTietPhieuTra'; // Khóa chính
    public $timestamps = false; // Không sử dụng created_at và updated_at

    protected $fillable = [
        'MaPhieuTra',
        'MaLinhKien',
        'SoLuong',
    ];
        public function phieuTra()
    {
        return $this->belongsTo(PhieuTra::class, 'MaPhieuTra', 'MaPhieuTra');
    }

    public function linhKien()
    {
        return $this->belongsTo(LinhKien::class, 'MaLinhKien', 'MaLinhKien');
    }
}
