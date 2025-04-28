<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaiKhoan extends Model
{
    use HasFactory;

    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'taikhoan';

    // Đặt khóa chính là TenTaiKhoan
    protected $primaryKey = 'TenTaiKhoan';

    // Không sử dụng timestamps
    public $timestamps = false;

    // Định nghĩa keyType là string nếu TenTaiKhoan là string
    protected $keyType = 'string';

    // Các trường có thể gán
    protected $fillable = [
        'MaNhanVien',
        'TenTaiKhoan',
        'MatKhau',
        'MatKhauChuaMaHoa'
    ];

    // Mối quan hệ với model NhanVien
    public function nhanvien()
    {
        return $this->belongsTo(NhanVien::class, 'MaNhanVien', 'MaNhanVien');
    }

    // Hàm lấy mật khẩu cho chức năng đăng nhập
    public function getAuthPassword()
    {
        return $this->MatKhau;
    }
}
