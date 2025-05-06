<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietPhieuBanGiaoBaoTri extends Model
{
    use HasFactory;

    protected $table = 'chitietphieubaotri';
    protected $primaryKey = 'MaChiTietPhieuBaoTri';
    public $timestamps = false;
    protected $fillable = [
        'MaPhieuBanGiaoBaoTri',
        'TenLinhKien',
        'SoLuong',
        'DonViTinh',
        'GiaThanh',
        'BaoHanh',
       
    ];
    public function phieuBanGiaoBaoTri()
    {
        return $this->belongsTo(PhieuBanGiaoBaoTri::class, 'MaPhieuBanGiaoBaoTri', 'MaPhieuBanGiaoBaoTri');
    }


}
