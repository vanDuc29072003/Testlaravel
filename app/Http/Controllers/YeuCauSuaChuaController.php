<?php

namespace App\Http\Controllers;
use App\Models\LichVanHanh;
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
        $dsMay = May::where('TrangThai', '!=', 1)->get();
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
                $queryDaXuLy->where($field, $operator, $value);
            }
        }
        $queryDaXuLy->whereIn('TrangThai', ['1', '2']);
            if ($request->filled('TrangThai')) {
                $queryDaXuLy->where('TrangThai', $request->TrangThai);
            }
        $dsYeuCauSuaChuaChoDuyet = $queryChoDuyet->where('TrangThai', '0')
            ->with(['may', 'nhanVien'])
            ->orderBy('ThoiGianYeuCau', 'desc')
            ->paginate(10, ['*'], 'cho_duyet');
    
        $dsYeuCauSuaChuaDaXuLy = $queryDaXuLy->whereIn('TrangThai', ['1', '2'])
            ->with(['may', 'nhanVien'])
            ->orderBy('ThoiGianYeuCau', 'desc')
            ->paginate(10, ['*'], 'da_xu_ly');
    
        ThongBao::where('Icon', 'fa-solid fa-hammer')->update(['TrangThai' => 1]);
    
        return view('vYCSC.yeucausuachua', compact('dsYeuCauSuaChuaChoDuyet','dsYeuCauSuaChuaDaXuLy', 'dsMay', 'dsNhanVien'
        ));
    }

    public function create(Request $request)
    {
        $maLich = $request->input('ma_lich');
        $dsMay = May::where('TrangThai', '!=', 1)->get();

        $nhanVien = Auth::user()->nhanvien;

        $lichVanHanh = null;
        if ($maLich) {
            $lichVanHanh = LichVanHanh::with(['may', 'nhanVien'])->find($maLich);
            if (!$lichVanHanh) {
                return redirect()->route('lichvanhanh.index')->with('error', 'Không tìm thấy lịch vận hành.');
            }
        }   

        return view('vYCSC.createyeucausuachua', compact('dsMay', 'nhanVien', 'lichVanHanh'));
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
            'Loai' => 'danger',
            'Icon' => 'fa-solid fa-hammer',
            'Route' => 'yeucausuachua.index'
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
        $yeuCauSuaChua->MaNhanVienDuyet = Auth::user()->MaNhanVien;
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
        $yeuCauSuaChua->MaNhanVienDuyet = Auth::user()->MaNhanVien;
        $yeuCauSuaChua->save();

        LichSuaChua::create([
            'MaYeuCauSuaChua' => $MaYeuCauSuaChua,
            'MaNhanVienKyThuat' => $request->input('MaNhanVienKyThuat'),
        ]);

        ThongBao::create([
            'NoiDung' => 'Có một lịch sửa chữa mới',
            'Loai' => 'success',
            'Icon' => 'fa-solid fa-calendar-days',
            'Route' => 'lichsuachua.index'
        ]);
        
        event(new eventDuyetYeuCauSuaChua());
        event(new eventUpdateTable());
        event(new eventUpdateUI());

        return redirect()->route('yeucausuachua.index')->with('success', 'Yêu cầu sửa chữa đã được duyệt!');
    }
}
