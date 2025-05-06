<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class BoPhan extends Authenticatable
{
    protected $table = 'bophan'; // Tên bảng trong database
    protected $primaryKey = 'MaBoPhan'; // Khóa chính
    public $timestamps = false; // Không sử dụng created_at và updated_at

    protected $fillable = [
        'MaBoPhan',
        'TenBoPhan',
    ];
    
    public function nhanviens()
    {
        return $this->hasMany(NhanVien::class, 'MaBoPhan', 'MaBoPhan');
    }
    
    public function phanQuyens()
    {
        return $this->belongsToMany(PhanQuyen::class, 'phanquyen_bophan', 'MaBoPhan', 'MaPhanQuyen');
    }
}