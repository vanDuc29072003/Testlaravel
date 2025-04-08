<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LichSuaChua;
use App\Models\YeuCauSuaChua;

class LichSuaChuaController extends Controller
{
    public function index()
    {
        $dsLichSuaChua = LichSuaChua::with(['yeuCauSuaChua', 'nhanVienKyThuat'])->get();
        return view('vLichSuaChua.lichsuachua');
    }
}
