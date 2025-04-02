<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetailuserController extends Controller
{
    public function detailuser()
    {
        $user = Auth::user();

        // Lấy thông tin nhân viên từ quan hệ
        $nhanvien = $user->nhanvien;

        // Lấy thông tin bộ phận từ quan hệ của nhân viên
        $bophan = $nhanvien ? $nhanvien->bophan : null;
        return view('vUser.detailuser', compact('user', 'nhanvien','bophan'));

    }
}
