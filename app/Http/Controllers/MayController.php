<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\May;
class MayController extends Controller
{
    public function may() {
        $dsMay = May::all(); // Lấy toàn bộ danh sách máy
        return view('may', compact('dsMay'));
    }
}
