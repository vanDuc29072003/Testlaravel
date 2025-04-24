<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LienKetLKNCC extends Model
{
    use HasFactory;

    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'nhacungcap_linhkien'; 

    protected $primaryKey = 'MaLienKet';
    public $timestamps = false;
    // Các trường có thể được gán giá trị
    protected $fillable = [
        'MaNhaCungCap',
        'MaLinhKien',
        
    ];


    // Quan hệ với model NhaCungCap
    public function nhaCungCap()
    {
        return $this->belongsTo(NhaCungCap::class, 'MaNhaCungCap', 'MaNhaCungCap');
    }

    // Quan hệ với model LinhKien
    public function linhKien()
    {
        return $this->belongsTo(LinhKien::class, 'MaLinhKien', 'MaLinhKien');
    }
}