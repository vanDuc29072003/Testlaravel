<?php

namespace App\Http\Controllers;

use App\Events\eventDuyetYeuCauSuaChua;
use App\Events\eventUpdateTable;
use App\Events\eventUpdateUI;
use App\Events\eventYeuCauSuaChua;
use Illuminate\Http\Request;
use App\Models\YeuCauSuaChua;
use App\Models\May;
use App\Models\NhanVien;
use App\Models\LichSuaChua;
use App\Models\ThongBao;
use Illuminate\Support\Facades\Auth;

class YeuCauSuaChuaController extends Controller
{
    public function index(Request $request) {
        $queryChoDuyet = YeuCauSuaChua::query();
        $queryDaXuLy = YeuCauSuaChua::query();
        $query = YeuCauSuaChua::query();
        $dsMay = May::all();
        $dsNhanVien = NhanVien::all();
        $filters = [
            'MaYeuCauSuaChua' => '=',
            'ThoiGianYeuCau' => 'like',
            'MaMay' => '=',
            'MaNhanVienYeuCau' => '=',
            'MoTa' => 'like',  
        ];
        foreach ($filters as $field => $operator) {
            if ($request->filled($field)) {
                $value = $operator === 'like' ? '%' . $request->$field . '%' : $request->$field;
                $query->where($field, $operator, $value);
            }
        }
        $dsYeuCauSuaChuaChoDuyet = $queryChoDuyet->where('TrangThai', '0')
                                                ->with(['may', 'nhanVien'])
                                                ->orderBy('ThoiGianYeuCau', 'desc')
                                                ->paginate(10, ['*'], 'cho_duyet');

        $dsYeuCauSuaChuaDaXuLy = $queryDaXuLy->whereIn('TrangThai', ['1', '2'])
                                                ->with(['may', 'nhanVien'])
                                                ->orderBy('ThoiGianYeuCau', 'desc')
                                                ->paginate(10, ['*'], 'da_xu_ly');
        $dsYeuCauSuaChua = $dsYeuCauSuaChuaChoDuyet->merge($dsYeuCauSuaChuaDaXuLy);

        ThongBao::where('Icon', 'fa-solid fa-hammer')->update(['TrangThai' => 1]);

        return view('vYCSC.yeucausuachua', compact('dsYeuCauSuaChua', 'dsYeuCauSuaChuaChoDuyet', 'dsYeuCauSuaChuaDaXuLy', 'dsMay', 'dsNhanVien'));
    }

    public function create(){
        $dsMay = May::all();
        $nhanVien = Auth::user()->nhanvien;
        return view('vYCSC.createyeucausuachua', compact('dsMay', 'nhanVien'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'MaMay' => 'required',
            'MoTa' => 'required',
        ]);

        YeuCauSuaChua::create([
            'MaMay' => $request->input('MaMay'),
            'MaNhanVienYeuCau' => auth()->user()->MaNhanVien,
            'ThoiGianYeuCau' => now(),
            'MoTa' => $request->input('MoTa'),
            'TrangThai' => '0',
        ]);

        ThongBao::create([
            'NoiDung' => Auth()->user()->nhanvien->TenNhanVien . ' đã tạo một yêu cầu sửa chữa mới',
            'Loai' => 'primary',
            'Icon' => 'fa-solid fa-hammer',
            'Route' => route('yeucausuachua.index')
        ]);
        
        $TenNhanVien = Auth()->user()->nhanvien->TenNhanVien;
        event(new eventYeuCauSuaChua($TenNhanVien));
        event(new eventUpdateTable());
        event(new eventUpdateUI());
        
        return redirect()->route('yeucausuachua.index')->with('success', 'Yêu cầu sửa chữa đã được gửi thành công!');
    }

    public function tuchoi($MaYeuCauSuaChua)
    {
        $yeuCauSuaChua = YeuCauSuaChua::findOrFail($MaYeuCauSuaChua);
        $yeuCauSuaChua->TrangThai = '2';
        $yeuCauSuaChua->save();

        event(new eventUpdateTable());
        event(new eventUpdateUI());

        return redirect()->route('yeucausuachua.index')->with('success', 'Yêu cầu sửa chữa đã bị từ chối!');
    }

    public function formduyet($MaYeuCauSuaChua)
    {
        $yeuCauSuaChua = YeuCauSuaChua::findOrFail($MaYeuCauSuaChua);
        $dsNhanVienKyThuat = NhanVien::where('MaBoPhan', '3')->get();
        return view('vYCSC.duyetyeucausuachua', compact('yeuCauSuaChua', 'dsNhanVienKyThuat'));
    }
    public function duyet(Request $request, $MaYeuCauSuaChua)
    {
        $request->validate([
            'MaNhanVienKyThuat' => 'required',
        ]);
        
        $yeuCauSuaChua = YeuCauSuaChua::findOrFail($MaYeuCauSuaChua);
        $yeuCauSuaChua->TrangThai = '1';
        $yeuCauSuaChua->save();

        LichSuaChua::create([
            'MaYeuCauSuaChua' => $MaYeuCauSuaChua,
            'MaNhanVienKyThuat' => $request->input('MaNhanVienKyThuat'),
        ]);

        ThongBao::create([
            'NoiDung' => 'Có một lịch sửa chữa mới',
            'Loai' => 'success',
            'Icon' => 'fa-solid fa-calendar-days',
            'Route' => route('lichsuachua.index')
        ]);
        
        event(new eventDuyetYeuCauSuaChua());
        event(new eventUpdateTable());
        event(new eventUpdateUI());

        return redirect()->route('yeucausuachua.index')->with('success', 'Yêu cầu sửa chữa đã được duyệt!');
    }
}
