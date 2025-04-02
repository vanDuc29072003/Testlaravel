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
        return view('vNCC.nhacungcap', compact('dsNhaCungCap'));
    }

    public function detailNhaCungCap($MaNhaCungCap)
    {
        $nhaCungCap = NhaCungCap::findOrFail($MaNhaCungCap); // Tìm nhà cung cấp theo ID
        return view('vNCC.detailnhacungcap', compact('nhaCungCap'));
    }
    // Hiển thị form chỉnh sửa nhà cung cấp
    public function form_editNhaCungCap($MaNhaCungCap)
    {
        $nhaCungCap = NhaCungCap::findOrFail($MaNhaCungCap); // Tìm nhà cung cấp theo ID
        return view('vNCC.editnhacungcap', compact('nhaCungCap'));
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
        return view('vNCC.addnhacungcap');
    }

    // Xử lý thêm nhà cung cấp
    public function storeNhaCungCap(Request $request)
    {
         try {
                $request->validate([
                    'TenNhaCungCap' => 'required|string|max:255|unique:nhacungcap,TenNhaCungCap',
                    'DiaChi' => 'required|string|max:255',
                    'SDT' => 'required|numeric|digits_between:10,12|unique:nhacungcap,SDT',
                    'Email' => 'required|email|max:255|unique:nhacungcap,Email',
                    'MaSoThue' => 'required|numeric|digits_between:10,15|unique:nhacungcap,MaSoThue',
                ], [
                    
                    'TenNhaCungCap.unique' => 'Nhà cung cấp đã tồn tại.',
                    'SDT.digits_between' => 'Số Điện Thoại phải có độ dài từ 10 đến 12 chữ số.',
                    
                    'Email.email' => 'Email phải là một địa chỉ email hợp lệ.',
                    'Email.unique' => 'Email đã tồn tại.',
                
                    'MaSoThue.numeric' => 'Mã Số Thuế phải là số.',
                    'MaSoThue.digits_between' => 'Mã Số Thuế phải có độ dài từ 10 đến 15 chữ số.',
                    'MaSoThue.unique' => 'Mã Số Thuế đã tồn tại.',
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
            ->with('error', $e->validator->errors()->first()) // Lấy lỗi đầu tiên     
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