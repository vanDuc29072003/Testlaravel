<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LichSuaChua extends Model
{
    use HasFactory;
    protected $table = 'lichsuachua';
    protected $fillable = [
        

    ];
    function yeucau()
    {
        return $this->belongsTo(YeuCauSuaChua::class, 'MaYeuCauSuaChua', 'MaYeuCauSuaChua');

    }
    function nhanvienkithuat()
    {
        return $this->belongsTo(NhanVien::class, 'MaNhanVienKyThuat', 'MaNhanVien');
    }
}
