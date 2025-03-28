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

    public function detailMay($MaMay) {
        $may = May::findOrFail($MaMay); // Tìm máy theo ID
        return view('detailmay', compact('may'));
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
    public function addMay() {
        return view('addmay');
    }
    public function storeMay(Request $request) {
        try {
            $request->validate([
                'TenMay' => 'required|string|max:255',
                'SeriMay' => 'required|string|max:255|unique:may,SeriMay',
                'ChuKyBaoTri' => 'required|integer',
                'NamSanXuat' => 'required|integer',
                'HangSanXuat' => 'required|string|max:255',
                'ThoiGianDuaVaoSuDung' => 'required|date',
                'ThoiGianBaoHanh' => 'required|integer',
            ]);
    
            // Tạo mới máy
            May::create([
                'TenMay' => $request->TenMay,
                'SeriMay' => $request->SeriMay,
                'ChuKyBaoTri' => $request->ChuKyBaoTri,
                'NamSanXuat' => $request->NamSanXuat,
                'HangSanXuat' => $request->HangSanXuat,
                'ThoiGianDuaVaoSuDung' => $request->ThoiGianDuaVaoSuDung,
                'ThoiGianBaoHanh' => $request->ThoiGianBaoHanh,
                'ChiTietLinhKien' => $request->ChiTietLinhKien,
                'MaNhaCungCap' => $request->MaNhaCungCap,
            ]);
    
            return redirect()->route('may')->with('success', 'Thêm máy thành công!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Lưu lỗi vào session
            return redirect()->back()
                ->with('error', 'Seri Máy trùng lặp hoặc thông tin không hợp lệ!')
                ->withInput();
        }
    }
}
