<?php

namespace App\Http\Controllers;

use App\Events\eventPhieuThanhLy;
use App\Events\eventUpdateTable;
use App\Events\eventUpdateUI;
use Illuminate\Http\Request;
use App\Models\PhieuThanhLy;
use App\Models\May;
use App\Models\NhanVien;
use App\Models\ThongBao;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PhieuThanhLyController extends Controller
{
    public function index(Request $request)
    {
        $query = PhieuThanhLy::query();
        $dsNhanVien = NhanVien::all();
        $dsMay = May::all();

        $filters = [
            'MaPhieuThanhLy' => '=',
            'NgayLapPhieu' => 'like',
            'MaNhanVien' => '=',
            'MaMay' => '=',
        ];

        foreach ($filters as $field => $operator) {
            if ($request->filled($field)) {
                $value = $operator === 'like' ? '%' . $request->$field . '%' : $request->$field;
                $query->where($field, $operator, $value);
            }
        }

        $dsPhieuThanhLyDaDuyet = $query
            ->whereIn('TrangThai', ['1', '2'])
            ->with('nhanVien', 'may')
            ->paginate(10, ['*'], 'da_duyet');

        $dsPhieuThanhLyChoDuyet = PhieuThanhLy::where('TrangThai', '0')
            ->with('nhanVien', 'may')
            ->paginate(10, ['*'], 'cho_duyet');

        ThongBao::where('Icon', 'fas fa-recycle')->update(['TrangThai' => '1']);

        return view('vPhieuThanhLy.phieuthanhly', compact('dsPhieuThanhLyDaDuyet', 'dsPhieuThanhLyChoDuyet', 'dsNhanVien', 'dsMay'));
    }
    public function create()
    {
        $dsMay = May::all();
        return view('vPhieuThanhLy.addphieuthanhly', compact('dsMay'));
    }
    public function getThongTinMay($MaMay)
    {
        $may = May::with(['nhaCungCap', 'loaiMay'])->findOrFail($MaMay);

        return response()->json([
            'SeriMay' => $may->SeriMay,
            'ThoiGianDuaVaoSuDung' => $may->ThoiGianDuaVaoSuDung,
            'ThoiGianKhauHao' => $may->ThoiGianBaoHanh, // Giả sử Thời Gian Khấu Hao là Thời Gian Bảo Hành
            'NamSanXuat' => $may->NamSanXuat,
            'HangSanXuat' => $may->HangSanXuat,
            'TenNhaCungCap' => $may->nhaCungCap->TenNhaCungCap ?? 'Không xác định',
            'TenLoai' => $may->loaiMay->TenLoai ?? 'Không xác định',
        ]);
    }
    public function store(Request $request)
    {
        PhieuThanhLy::create([
            'NgayLapPhieu' => now(),
            'MaNhanVien' => $request->input('MaNhanVien'),
            'MaMay' => $request->input('MaMay'),
            'GiaTriBanDau' => $request->input('GiaTriBanDau'),
            'GiaTriConLai' => $request->input('GiaTriConLai'),
            'DanhGia' => $request->input('DanhGia'),
            'GhiChu' => $request->input('GhiChu'),
            'TrangThai' => '0',
        ]);
        ThongBao::create([
            'NoiDung' => Auth()->user()->nhanvien->TenNhanVien . ' đã tạo một phiếu thanh lý mới cần duyệt',
            'Loai' => 'primary',
            'Icon' => 'fas fa-recycle',
            'Route' => 'phieuthanhly.index',
        ]);

        event(new eventPhieuThanhLy());
        event(new eventUpdateTable());
        event(new eventUpdateUI());

        return redirect()->route('phieuthanhly.index')->with('success', 'Phiếu thanh lý đã được tạo thành công!');
    }
    public function detail($MaPhieuThanhLy)
    {
        $phieuThanhLy = PhieuThanhLy::with(['nhanVien', 'may'])->findOrFail($MaPhieuThanhLy);
        return view('vPhieuThanhLy.detailphieuthanhly', compact('phieuThanhLy'));
    }
    public function edit($MaPhieuThanhLy)
    {
        $phieuThanhLy = PhieuThanhLy::with(['nhanVien', 'may'])->findOrFail($MaPhieuThanhLy);
        $dsMay = May::all();
        return view('vPhieuThanhLy.editphieuthanhly', compact('phieuThanhLy', 'dsMay'));
    }
    public function update(Request $request, $MaPhieuThanhLy)
    {
        $phieuThanhLy = PhieuThanhLy::findOrFail($MaPhieuThanhLy);
        $phieuThanhLy->update([
            'MaNhanVien' => Auth::user()->nhanvien->MaNhanVien,
            'MaMay' => $request->input('MaMay'),
            'GiaTriBanDau' => $request->input('GiaTriBanDau'),
            'GiaTriConLai' => $request->input('GiaTriConLai'),
            'DanhGia' => $request->input('DanhGia'),
            'GhiChu' => $request->input('GhiChu'),
        ]);

        event(new eventUpdateTable());

        return redirect()->route('phieuthanhly.index')->with('success', 'Phiếu thanh lý đã được cập nhật thành công!');
    }
    public function duyet($MaPhieuThanhLy)
    {
        $phieuThanhLy = PhieuThanhLy::findOrFail($MaPhieuThanhLy);
        $phieuThanhLy->TrangThai = '1';
        $phieuThanhLy->save();

        event(new eventUpdateTable());

        return redirect()->route('phieuthanhly.index')->with('success', 'Phiếu thanh lý đã được duyệt!');
    }
    public function tuchoi($MaPhieuThanhLy)
    {
        $phieuThanhLy = PhieuThanhLy::findOrFail($MaPhieuThanhLy);
        $phieuThanhLy->TrangThai = '2';
        $phieuThanhLy->save();

        event(new eventUpdateTable());

        return redirect()->route('phieuthanhly.index')->with('success', 'Phiếu thanh lý đã được tu choi!');
    }
    public function exportPDF($MaPhieuThanhLy)
    {
        $phieuThanhLy = PhieuThanhLy::with(['nhanVien', 'may'])->findOrFail($MaPhieuThanhLy);
        $pdf = PDF::loadView('vPhieuThanhLy.pdfphieuthanhly', compact('phieuThanhLy'));
        return $pdf->stream('phieu_thanh_ly_' . $MaPhieuThanhLy . '.pdf');
    }
}
