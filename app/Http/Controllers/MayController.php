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

    public function form_editmay($MaMay) {
        $may = May::findOrFail($MaMay); // Tìm máy theo ID
        return view('editmay', compact('may'));
    }
    public function editmay(Request $request, $MaMay) {
        $may = May::findOrFail($MaMay); // Tìm máy theo ID
        $may->update($request->all()); // Cập nhật thông tin máy
        return redirect()->route('may')->with('success', 'Cập nhật thành công!');
    }
}
