<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class TaiKhoan extends Authenticatable
{
    protected $table = 'taikhoan'; // Tên bảng trong database
    protected $primaryKey = 'MaNhanVien'; // Khóa chính
    public $timestamps = false; // Không sử dụng created_at và updated_at

    protected $fillable = [
        'MaNhanVien',
        'TenTaiKhoan',
        'MatKhauChuaMaHoa',
        'MatKhau',
    ];

    // Ghi đè phương thức getAuthPassword để sử dụng cột MatKhau
    public function getAuthPassword()
    {
        return $this->MatKhau;
    }
    public function nhanvien()
    {
        return $this->belongsTo(NhanVien::class, 'MaNhanVien', 'MaNhanVien');
    }
    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->MatKhauChuaMaHoa) {
                $model->MatKhau = bcrypt($model->MatKhauChuaMaHoa); // Mã hóa mật khẩu
            }
        });
    }
}