<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietPhieuSuaNCC extends Model
{
    use HasFactory;

    protected $table = 'chitietphieusuanhacungcap';
    protected $primaryKey = 'MaChiTietPhieuSuaNCC';
    public $timestamps = false;
    protected $fillable = [
        'MaPhieuBanGiaoSuaChua',
        'TenLinhKien',
        'SoLuong',
        'DonViTinh',
        'GiaThanh',
        'BaoHanh',
       
    ];
    public function phieuBanGiaoSuaNCC()
    {
        return $this->belongsTo(PhieuBanGiaoSuaChuaNCC::class, 'MaPhieuBanGiaoSuaChua', 'MaPhieuBanGiaoSuaChua');
    }


}
