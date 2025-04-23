<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThongBao extends Model
{
    use HasFactory;

    protected $table ='thongbao';
    protected $primaryKey = 'MaThongBao'; // Khóa chính
    public $timestamps = true;

    protected $fillable = [
        'MaThongBao',
        'NoiDung',
        'Loai',
        'Icon',
        'TrangThai',
        'Route'
    ];
}
