<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NhanVien extends Model
{
    protected $table = 'nhanvien'; // Tên bảng trong database
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

    // Thiết lập mối quan hệ với bảng bophan
    public function bophan()
    {
        return $this->belongsTo(BoPhan::class, 'MaBoPhan', 'MaBoPhan');
    }
}
