<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class TaiKhoan extends Authenticatable
{
    protected $table = 'taikhoan'; 
    protected $primaryKey = 'MaNhanVien'; 
    public $timestamps = false; 
    protected $fillable = [
        'MaNhanVien',
        'TenTaiKhoan',
        'MatKhauChuaMaHoa',
        'MatKhau',
    ];

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
                $model->MatKhau = bcrypt($model->MatKhauChuaMaHoa); 
            }
        });
    }
}