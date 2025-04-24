<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonViTinh extends Model
{
    use HasFactory;

    protected $table = 'donvitinh'; // Tên bảng trong database
    protected $primaryKey = 'MaDonViTinh'; // Khóa chính
    public $timestamps = false; // Không sử dụng created_at và updated_at

    protected $fillable = [
        'TenDonViTinh',
    ];
    public function linhKiens()
    {
        return $this->hasMany(LinhKien::class, 'MaDonViTinh', 'MaDonViTinh');
    }
}