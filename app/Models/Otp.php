<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;
    protected $table = 'otps';
    protected $primaryKey = 'id';
    protected $fillable = ['TenTaiKhoan', 'otp_code', 'expires_at'];
    public $timestamps = true;
}
