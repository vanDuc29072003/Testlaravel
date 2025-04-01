<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'taikhoan'; // Tên bảng trong database
    protected $primaryKey = 'MaNhanVien'; // Khóa chính
    public $timestamps = false; // Không sử dụng created_at và updated_at

    protected $fillable = [
        'MaNhanVien',
        'MatKhau',
        'TenTaiKhoan',
        
    ];

    // Ghi đè phương thức getAuthPassword để sử dụng cột MatKhau
    public function getAuthPassword()
    {
        return $this->MatKhau;
    }
}