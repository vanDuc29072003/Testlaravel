<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietPhieuBanGiaoNoiBo extends Model
{
    use HasFactory;

    protected $table = 'chitietphieubangiaonoibo';
    protected $primaryKey = 'MaChiTietPhieuSuaNB';
    public $timestamps = true ;
    protected $fillable = [
        'MaPhieuBanGiaoNoiBo',
        'MaLinhKien',
        'SoLuong',   
      
    ];
    public function phieuBanGiaoNoiBo()
    {
        return $this->belongsTo(PhieuBanGiaoNoiBo::class, 'MaPhieuBanGiaoNoiBo', 'MaPhieuBanGiaoNoiBo');
    }

    public function LinhKienSuaChua()
    {
        return $this->belongsTo(LinhKien::class, 'MaLinhKien', 'MaLinhKien');
    }
}
