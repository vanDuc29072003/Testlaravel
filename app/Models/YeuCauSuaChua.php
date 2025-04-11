<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YeuCauSuaChua extends Model
{
    use HasFactory;
    protected $table = 'yeucausuachua'; // Tên bảng trong database
    protected $primaryKey = 'MaYeuCauSuaChua'; // Khóa chính
    public $timestamps = false; // Không sử dụng created_at và updated_at

    protected $fillable = [
        'MaMay',
        'MaNhanVienYeuCau',
        'ThoiGianYeuCau',
        'MoTa',
        'TrangThai'
    ];
    public function may()
    {
        return $this->belongsTo(May::class, 'MaMay', 'MaMay');
    }
    public function nhanVien()
    {
        return $this->belongsTo(NhanVien::class, 'MaNhanVienYeuCau', 'MaNhanVien');
    }
}
