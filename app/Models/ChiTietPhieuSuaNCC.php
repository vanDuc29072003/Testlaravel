<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietPhieuSuaNCC extends Model
{
    use HasFactory;

    protected $table = 'chitietphieusuanhacungcap';
    protected $primaryKey = 'MaChiTietPhieuSuaNCC';
    public $timestamps = true;
    protected $fillable = [
        'MaPhieuBanGiaoSuaChua',
        'Tên Linh Kien',
        'SoLuong',
        'DonViTinh',
        'GiaThanh',
        'GhiChu',
    ];
    public function phieuBanGiaoSuaNCC()
    {
        return $this->belongsTo(PhieuBanGiaoSuaChuaNCC::class, 'MaPhieuBanGiaoSuaChua', 'MaPhieuBanGiaoSuaChua');
    }


}
