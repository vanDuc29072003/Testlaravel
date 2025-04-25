<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhieuBanGiaoSuaChuaNCC extends Model
{
    use HasFactory;

    protected $table = 'phieubangiaosuachuanhacungcap';
    protected $primaryKey = 'MaPhieuBanGiaoSuaChua';
    public $timestamps = true;
    protected $fillable = [
        'MaNhaCungCap',
        'MaLichSuaChua',
        'ThoiGianBanGiao',
        'BienPhapXuLy',
        'TongTien',
        'ChiPhiKhac',   
        'GhiChu',   
    ];
    public function nhaCungCap()
    {
        return $this->belongsTo(NhaCungCap::class, 'MaNhaCungCap', 'MaNhaCungCap');
    }

    // Quan hệ đến bảng lịch sửa chữa
    public function lichSuaChua()
    {
        return $this->belongsTo(LichSuaChua::class, 'MaLichSuaChua', 'MaLichSuaChua');
    }
}
