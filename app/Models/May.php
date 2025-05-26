<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class May extends Model
{
    use HasFactory;

    protected $table = 'may'; // Tên bảng trong database
    protected $primaryKey = 'MaMay'; // Khóa chính
    public $timestamps = false; // Không sử dụng created_at và updated_at

    protected $fillable = [
        'MaMay2',
        'TenMay', 
        'SeriMay', 
        'ChuKyBaoTri', 
        'ThoiGianBaoHanh',
        'ThoiGianDuaVaoSuDung',
        'NamSanXuat', 
        'GiaTriBanDau',
        'ChiTietLinhKien',
        'MaNhaCungCap',
        'MaLoai',
        'TrangThai',
        'ThoiGianKhauHao'
    ];
    public function nhaCungCap()
    {
        return $this->belongsTo(NhaCungCap::class, 'MaNhaCungCap', 'MaNhaCungCap');
    }
    public function loaiMay()
    {
        return $this->belongsTo(LoaiMay::class, 'MaLoai', 'MaLoai');
    }
    public function lichBaoTri()
    {
        return $this->hasMany(LichBaoTri::class, 'MaMay', 'MaMay');
    }
    public function yeuCauSuaChua()
    {
        return $this->hasMany(YeuCauSuaChua::class, 'MaMay', 'MaMay');
    }
}
