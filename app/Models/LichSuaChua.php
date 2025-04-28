<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LichSuaChua extends Model
{
    use HasFactory;

    protected $table = 'lichsuachua';
    protected $primaryKey = 'MaLichSuaChua';
    public $timestamps = true;
    protected $fillable = [
        'MaYeuCauSuaChua',
        'MaNhanVienKyThuat',
        'TrangThai'
    ];
    public function yeuCauSuaChua()
    {
        return $this->belongsTo(YeuCauSuaChua::class, 'MaYeuCauSuaChua', 'MaYeuCauSuaChua');
    }
    public function nhanVienKyThuat()
    {
        return $this->belongsTo(NhanVien::class, 'MaNhanVienKyThuat', 'MaNhanVien');
    }
    public function phieuBanGiaoNoiBo()
    {
        return $this->belongsTo(PhieuBanGiaoNoiBo::class, 'MaLichSuaChua', 'MaLichSuaChua');
    }
    public function phieuBanGiaoSuaChuaNCC()
{
    return $this->belongsTo(PhieuBanGiaoSuaChuaNCC::class, 'MaLichSuaChua', 'MaLichSuaChua');
}

}
