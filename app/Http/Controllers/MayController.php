<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;

use App\Events\eventUpdateTable;
use Illuminate\Http\Request;
use App\Models\May;
use App\Models\NhaCungCap;
use App\Models\LoaiMay;
class MayController extends Controller
{
    // public function may() {
    //     $dsMay = May::all(); // Lấy toàn bộ danh sách máy
    //     return view('vMay.may', compact('dsMay'));
    // }

    // public function may() {
    //     $dsMay = May::paginate(10); // Lấy 10 bản ghi mỗi trang
    //     return view('vMay.may', compact('dsMay'));
    // }

    public function may(Request $request)
    {
        $query = May::query();

        if ($request->filled('MaLoai')) {
            $query->where('MaLoai', $request->MaLoai);
        }

        if ($request->filled('TenNhaCungCap')) {
            $query->where('MaNhaCungCap', $request->TenNhaCungCap);
        }


        $filters = [
            'TenMay' => 'like',
            'SeriMay' => 'like',
            'ChuKyBaoTri' => '=',
            'ThoiGianBaoHanh' => '=',
            'ThoiGianDuaVaoSuDung' => '=',
            'NamSanXuat' => '=',
        ];

        foreach ($filters as $field => $operator) {
            if ($request->filled($field)) {
                $value = $operator === 'like' ? '%' . $request->$field . '%' : $request->$field;
                $query->where($field, $operator, $value);
            }
        }

        $query->orderBy('MaMay2', 'asc');
        $dsMay = $query->paginate(10)->appends($request->query());

        $dsLoaiMay = LoaiMay::all();
        $dsNhaCungCap = NhaCungCap::all();

        return view('vMay.may', compact('dsMay', 'dsLoaiMay', 'dsNhaCungCap'));
    }


    public function detailMay($MaMay)
    {
        $may = May::with('nhaCungCap')->findOrFail($MaMay); // Eager load nhà cung cấp
        return view('vMay.detailmay', compact('may'));
    }

    public function form_editmay($MaMay)
    {
        $may = May::with('nhaCungCap:MaNhaCungCap,TenNhaCungCap')->findOrFail($MaMay); // Eager load nhà cung cấp
        $nhaCungCaps = NhaCungCap::select('MaNhaCungCap', 'TenNhaCungCap')->get(); // Chỉ lấy các cột cần thiết
        return view('vMay.editmay', compact('may', 'nhaCungCaps'));
    }

    public function editmay(Request $request, $MaMay)
    {
        $may = May::findOrFail($MaMay); // Tìm máy theo ID
        $may->update($request->only('ChuKyBaoTri'));

        event(new eventUpdateTable());
        return redirect()->route('may.detail', ['MaMay' => $MaMay])->with('success', 'Cập nhật thành công!');
    }

    public function addMay()
    {
        
        $loaiMays = LoaiMay::all(); // Lấy danh sách loại máy
      
        $nhaCungCaps = NhaCungCap::all(); // Lấy danh sách nhà cung cấp
        return view('vMay.addmay', compact('nhaCungCaps', 'loaiMays'));
    }
    public function storeMay(Request $request)
    {
        
        try {
            $request->validate([
                'TenMay' => 'required|string|max:255',
                'SeriMay' => 'required|string|max:255|unique:may,SeriMay',
                'ChuKyBaoTri' => 'required|integer|min:1',
                'NamSanXuat' => 'required|integer|min:1900|max:' . date('Y'),
                'ThoiGianDuaVaoSuDung' => 'required|date',
                'ThoiGianBaoHanh' => 'required|integer|min:1',
                'ChiTietLinhKien' => 'nullable|string|max:255',
                'MaNhaCungCap' => 'required|exists:nhacungcap,MaNhaCungCap',
                'MaLoai' => 'required|exists:loaimay,MaLoai',
            ]);
            $loaiMay = LoaiMay::where('MaLoai', $request->MaLoai)->first();
            // Lấy tiền tố theo mã loại máy
            $prefix = match ($request->MaLoai) {
                '2' => 'MC',
                '1' => 'MI',
                '3' => 'MB',
                '4' => 'ME',
                '5' => 'MĐ',
                '6' => 'MD',
                '7' => 'MC',
                '8' => 'MG',
                '9' => 'MDG',
                '10' => 'MCM',
                default => 'MX',
            };

            // Tìm mã máy cuối cùng có cùng tiền tố
            $lastMachine = May::where('MaMay2', 'like', $prefix . '%')
                ->orderBy('MaMay2', 'desc')
                ->first();

            $newNumber = $lastMachine
                ? ((int) substr($lastMachine->MaMay2, strlen($prefix)) + 1)
                : 1;

            $newMaMay = $prefix . str_pad($newNumber, 2, '0', STR_PAD_LEFT);

            May::create([
                'MaMay2' => $newMaMay,
                'TenMay' => $request->TenMay,
                'SeriMay' => $request->SeriMay,
                'ChuKyBaoTri' => $request->ChuKyBaoTri,
                'NamSanXuat' => $request->NamSanXuat,
                'ThoiGianDuaVaoSuDung' => $request->ThoiGianDuaVaoSuDung,
                'ThoiGianBaoHanh' => $request->ThoiGianBaoHanh,
                'ChiTietLinhKien' => $request->ChiTietLinhKien,
                'MaNhaCungCap' => $request->MaNhaCungCap,
                'MaLoai' => $request->MaLoai,
            ]);

            event(new eventUpdateTable());

            return redirect()->route('may')->with('success', 'Thêm máy thành công!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Lưu lỗi vào session
            return redirect()->back()
                ->with('error', 'Seri Máy trùng lặp hoặc thông tin không hợp lệ!')
                ->withInput();
        }
    }
    public function deleteMay($MaMay)
    {
        $may = May::findOrFail($MaMay); // Tìm máy theo ID
        $may->delete(); // Xóa máy

        event(new eventUpdateTable());

        return redirect()->route('may')->with('success', 'Xóa máy thành công!');
    }
}
