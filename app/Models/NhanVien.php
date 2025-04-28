<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NhanVien extends Model
{
    protected $table = 'nhanvien'; // Tên bảng trong cơ sở dữ liệu
    protected $primaryKey = 'MaNhanVien'; // Khóa chính
    public $timestamps = false; // Không sử dụng created_at và updated_at

    protected $fillable = [
        'MaNhanVien',
        'TenNhanVien',
        'Email',
        'GioiTinh',
        'NgaySinh',
        'SDT',
        'DiaChi',
        'MaBoPhan',
    ];

    // Mối quan hệ với bảng bophan
    public function bophan()
    {
        return $this->belongsTo(BoPhan::class, 'MaBoPhan', 'MaBoPhan');
    }

    // Mối quan hệ với bảng taikhoan
    public function taikhoan()
    {
        return $this->hasOne(TaiKhoan::class, 'MaNhanVien', 'MaNhanVien');
    }
}
