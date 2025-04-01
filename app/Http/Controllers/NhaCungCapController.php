<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NhaCungCap;

class NhaCungCapController extends Controller
{
    // Hiển thị danh sách nhà cung cấp
    public function nhacungcap()
    {
        $dsNhaCungCap = NhaCungCap::all(); // Lấy toàn bộ danh sách nhà cung cấp
        return view('nhacungcap', compact('dsNhaCungCap'));
    }

    public function detailNhaCungCap($MaNhaCungCap)
    {
        $nhaCungCap = NhaCungCap::findOrFail($MaNhaCungCap); // Tìm nhà cung cấp theo ID
        return view('detailnhacungcap', compact('nhaCungCap'));
    }
    // Hiển thị form chỉnh sửa nhà cung cấp
    public function form_editNhaCungCap($MaNhaCungCap)
    {
        $nhaCungCap = NhaCungCap::findOrFail($MaNhaCungCap); // Tìm nhà cung cấp theo ID
        return view('editnhacungcap', compact('nhaCungCap'));
    }

    // Xử lý chỉnh sửa nhà cung cấp
    public function editNhaCungCap(Request $request, $MaNhaCungCap)
    {
        $nhaCungCap = NhaCungCap::findOrFail($MaNhaCungCap); // Tìm nhà cung cấp theo ID
        $nhaCungCap->update($request->all()); // Cập nhật thông tin nhà cung cấp
        return redirect()->route('nhacungcap.detail', ['MaNhaCungCap' => $MaNhaCungCap])->with('success', 'Cập nhật nhà cung cấp thành công!');
    }

    // Hiển thị form thêm nhà cung cấp
    public function addNhaCungCap()
    {
        return view('addnhacungcap');
    }

    // Xử lý thêm nhà cung cấp
    public function storeNhaCungCap(Request $request)
    {
        try {
            $request->validate([
                'TenNhaCungCap' => 'required|string|max:255',
                'DiaChi' => 'required|string|max:255',
                'SDT' => 'required|numeric|digits_between:10,12',
                'Email' => 'required|email|max:255|unique:nhacungcap,Email',
                'MaSoThue' => 'required|numeric|max:15',
            ]);

            // Tạo mới nhà cung cấp
            NhaCungCap::create([
                'TenNhaCungCap' => $request->TenNhaCungCap,
                'DiaChi' => $request->DiaChi,
                'SDT' => $request->SDT,
                'Email' => $request->Email,
                'MaSoThue' => $request->MaSoThue,
            ]);

            return redirect()->route('nhacungcap')->with('success', 'Thêm nhà cung cấp thành công!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->with('error', 'Email đã tồn tại hoặc thông tin không hợp lệ!')
                ->withInput();
        }
    }

    // Xóa nhà cung cấp
    public function deleteNhaCungCap($MaNhaCungCap)
    {
        $nhaCungCap = NhaCungCap::findOrFail($MaNhaCungCap); // Tìm nhà cung cấp theo ID
        $nhaCungCap->delete(); // Xóa nhà cung cấp
        return redirect()->route('nhacungcap')->with('success', 'Xóa nhà cung cấp thành công!');
    }
}