<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LichSuSuaChua extends Model
{
    use HasFactory;

    protected $table = 'lichsusuachua';
    protected $primaryKey = 'MaLichSuSuaChua';
    public $timestamps = true;
    protected $fillable = [
        'MaYeuCauSuaChua',
        'MaPhieuBanGiaoSuaNCC',
        'MaPhieuBanGiaoNoiBo',
       
    ];
    public function yeuCauSuaChua()
    {
        return $this->belongsTo(YeuCauSuaChua::class, 'MaYeuCauSuaChua', 'MaYeuCauSuaChua');
    }
    public function phieuBanGiaoSuaNCC()
    {
        return $this->belongsTo(PhieuBanGiaoSuaChuaNCC::class, 'MaPhieuBanGiaoSuaChua', 'MaPhieuBanGiaoSuaChua');
    }
    public function phieuBanGiaoNoiBo()
    {
        return $this->belongsTo(PhieuBanGiaoNoiBo::class, 'MaPhieuBanGiaoNoiBo', 'MaPhieuBanGiaoNoiBo');
    }

}
