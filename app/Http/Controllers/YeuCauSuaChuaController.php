<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\YeuCauSuaChua;
use App\Models\May;
use App\Models\NhanVien;
use App\Models\LichSuaChua;
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

        return redirect()->route('yeucausuachua.index')->with('success', 'Yêu cầu sửa chữa đã được gửi thành công!');
    }

    public function tuchoi($MaYeuCauSuaChua)
    {
        $yeuCauSuaChua = YeuCauSuaChua::findOrFail($MaYeuCauSuaChua);
        $yeuCauSuaChua->TrangThai = '2';
        $yeuCauSuaChua->save();

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
        return redirect()->route('yeucausuachua.index')->with('success', 'Yêu cầu sửa chữa đã được duyệt!');
    }
}
