<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;

use App\Events\eventUpdateTable;
use Illuminate\Http\Request;
use App\Models\May;
use App\Models\NhaCungCap;
use App\Models\LoaiMay;
use Carbon\Carbon;
class MayController extends Controller
{
    public function may(Request $request)
    {
        $query = May::query();

        if ($request->filled('TrangThai')) {
            if ($request->TrangThai == 'da_thanh_ly') {
                $query->where('TrangThai', 1);
            } elseif ($request->TrangThai == 'dang_su_dung') {
                $query->where('TrangThai', '!=', 1);
            }
        }

        if ($request->filled('KhauHao')) {
            if ($request->KhauHao == 'het_khau_hao') {
                // Đã hết khấu hao
                $query->whereRaw("DATE_ADD(`ThoiGianDuaVaoSuDung`, INTERVAL `ThoiGianKhauHao` YEAR) <= CURDATE()");
            } elseif ($request->KhauHao == 'con_khau_hao') {
                // Còn khấu hao
                $query->whereRaw("DATE_ADD(`ThoiGianDuaVaoSuDung`, INTERVAL `ThoiGianKhauHao` YEAR) > CURDATE()");
            }
        }

        if ($request->filled('BaoHanh')) {
            if ($request->BaoHanh == 'het_bao_hanh') {
                // Đã hết bao hành
                $query->whereRaw("DATE_ADD(`ThoiGianDuaVaoSuDung`, INTERVAL `ThoiGianBaoHanh` MONTH) <= CURDATE()");
            } elseif ($request->BaoHanh == 'con_bao_hanh') {
                // Còn bao hành
                $query->whereRaw("DATE_ADD(`ThoiGianDuaVaoSuDung`, INTERVAL `ThoiGianBaoHanh` MONTH) > CURDATE()");
            }
        }

        $filters = [
            'MaLoai' => '=',
            'MaNhaCungCap' => '=',
            'TenMay' => 'like',
            'SeriMay' => 'like',
            'ChuKyBaoTri' => '=',
            'ThoiGianBaoHanh' => '=',
            'ThoiGianDuaVaoSuDung' => '=',
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
        $may = May::with('nhaCungCap', 'loaiMay')->findOrFail($MaMay); // Eager load nhà cung cấp
        $ngayHetKhauHao = null;
        $ngayHetBaoHanh = null;
        if ($may->ThoiGianDuaVaoSuDung && $may->ThoiGianKhauHao) {
            $ngayHetKhauHao = Carbon::parse($may->ThoiGianDuaVaoSuDung)->addYears($may->ThoiGianKhauHao);
            $ngayHetBaoHanh = Carbon::parse($may->ThoiGianDuaVaoSuDung)->addMonths($may->ThoiGianBaoHanh);
        }

        return view('vMay.detailmay', compact('may', 'ngayHetKhauHao', 'ngayHetBaoHanh'));
    }

    public function form_editmay($MaMay)
    {
        $may = May::with('nhaCungCap:MaNhaCungCap,TenNhaCungCap')->findOrFail($MaMay); // Eager load nhà cung cấp
        $nhaCungCaps = NhaCungCap::select('MaNhaCungCap', 'TenNhaCungCap')->get(); // Chỉ lấy các cột cần thiết
        $loaiMays = LoaiMay::select('MaLoai', 'TenLoai')->get();
        return view('vMay.editmay', compact('may', 'nhaCungCaps', 'loaiMays'));
    }

    public function editmay(Request $request, $MaMay)
    {
        try {
            $may = May::findOrFail($MaMay);

            $request->validate([
                'TenMay' => 'required|string|max:255',
                'SeriMay' => 'required|string|max:255|unique:may,SeriMay,' . $MaMay . ',MaMay',
                'ChuKyBaoTri' => 'required|integer|min:1',
                'NamSanXuat' => 'required|integer|min:1900|max:' . date('Y'),
                'ThoiGianDuaVaoSuDung' => 'required|date',
                'ThoiGianBaoHanh' => 'required|integer|min:1',
                'ChiTietLinhKien' => 'nullable|string|max:255|url',
                'MaNhaCungCap' => 'required|exists:nhacungcap,MaNhaCungCap',
                'MaLoai' => 'required|exists:loaimay,MaLoai',
                'ThoiGianKhauHao' => 'nullable|numeric|min:0',
                'GiaTriBanDau' => 'nullable|numeric|min:0',
            ], [
                'SeriMay.unique' => 'Seri máy đã tồn tại trong hệ thống.',
                'ChiTietLinhKien.url' => 'Đường dẫn chi tiết linh kiện không hợp lệ.',
            ]);

            $may->update($request->all());

            event(new eventUpdateTable());
            return redirect()->route('may.detail', ['MaMay' => $MaMay])->with('success', 'Cập nhật thành công!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->with('error', $e->validator->errors()->first())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Cập nhật không thành công, vui lòng kiểm tra lại.')->withInput();
        }
    }

    public function addMay()
    {

        $loaiMays = LoaiMay::all(); // Lấy danh sách loại máy

        $nhaCungCaps = NhaCungCap::all(); // Lấy danh sách nhà cung cấp
        $mayFormData = session('may_form_data', []);
        session()->forget('may_form_data');

        return view('vMay.addmay', compact('nhaCungCaps', 'loaiMays', 'mayFormData'));
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
                'ChiTietLinhKien' => 'nullable|string|max:255|url',
                'MaNhaCungCap' => 'required|exists:nhacungcap,MaNhaCungCap',
                'MaLoai' => 'required|exists:loaimay,MaLoai',
                'ThoiGianKhauHao' => 'nullable|integer|min:1',
                'GiaTriBanDau' => 'nullable|integer|min:1',
            ],[
                'SeriMay.unique' => 'Seri máy đã tồn tại trong hệ thống.',
                'ChiTietLinhKien.url' => 'Đường dẫn chi tiết linh kiện không hợp lệ.',
            ]);

            $loaiMay = LoaiMay::where('MaLoai', $request->MaLoai)->first();
            $tiento = $loaiMay ? $loaiMay->MoTa : 'MAY';

            //Tìm máy có cùng tiền tố mới nhất
            $lastMay = May::where('MaLoai', $request->MaLoai)
                ->orderBy('MaMay2', 'desc')
                ->first();

            $newNumber = 1;
            if ($lastMay) {
                $lastNumber = substr($lastMay->MaMay2, 3);
                $newNumber = $lastNumber + 1;
            }

            // Ghép tiền tố với số thứ tự
            $newMaMay = $tiento . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

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
                'ThoiGianKhauHao' => $request->ThoiGianKhauHao,
                'GiaTriBanDau' => $request->GiaTriBanDau
            ]);

            event(new eventUpdateTable());

            session()->forget('may_form_data');
            return redirect()->route('may')->with('success', 'Thêm máy thành công!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->with('error', $e->validator->errors()->first())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Cập nhật không thành công, vui lòng kiểm tra lại.')->withInput();
        }
    }
    public function deleteMay($MaMay)
    {
        try {
            $may = May::findOrFail($MaMay); // Tìm máy theo ID
            $may->delete(); // Xóa máy

            event(new eventUpdateTable());

            return redirect()->back()->with('success', 'Xóa máy thành công!');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('error', 'Không thể xóa máy vì đang được sử dụng.');
        }
    }
    public function saveFormSession(Request $request)
    {
        session()->put('may_form_data', $request->all());
        return response()->json(['status' => 'ok']);
    }
}
