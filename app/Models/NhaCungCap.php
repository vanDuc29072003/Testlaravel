<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NhaCungCap extends Model
{
    use HasFactory;

    protected $table = 'nhacungcap'; // Tên bảng trong database
    protected $primaryKey = 'MaNhaCungCap'; // Khóa chính
    public $timestamps = false; // Không sử dụng created_at và updated_at

    protected $fillable = [
        'TenNhaCungCap',
        'SDT',
        'DiaChi',
        'Email',
        'MaSoThue'
    ];
    public function linhKiens()
    {
        return $this->belongsToMany(
            LinhKien::class,
            'nhacungcap_linhkien', // Tên bảng trung gian
            'MaNhaCungCap', // Khóa ngoại trong bảng trung gian trỏ đến NhaCungCap
            'MaLinhKien' // Khóa ngoại trong bảng trung gian trỏ đến LinhKien
        );
    }

    public function mays()
    {
        return $this->hasMany(May::class, 'MaNhaCungCap', 'MaNhaCungCap');
    }
}
