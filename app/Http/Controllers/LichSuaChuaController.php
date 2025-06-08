<?php

namespace App\Http\Controllers;

use App\Events\eventUpdateTable;
use App\Models\LichSuaChua;
use Illuminate\Http\Request;
use App\Models\YeuCauSuaChua;
use App\Models\NhanVien;
use App\Models\ThongBao;
use App\Events\eventUpdateUI;
use Carbon\Carbon;
use App\Models\PhieuBanGiaoNoiBo;
use App\Models\PhieuBanGiaoSuaChuaNCC;
use App\Models\May;
use Barryvdh\DomPDF\Facade\Pdf;
class LichSuaChuaController extends Controller
{

    public function index(Request $request)
    {
        $queryChuaHoanThanh = LichSuaChua::query();
        $dsNhanVien = NhanVien::all();

        $dsLSCChuaHoanThanh = $queryChuaHoanThanh->where('TrangThai', '0')
            ->with(['yeuCauSuaChua', 'nhanVienKyThuat'])
            ->orderBy('updated_at', 'desc')
            ->get();

        $dsLSCtheongay = $dsLSCChuaHoanThanh->groupBy(function ($item) {
            return Carbon::parse($item->yeuCauSuaChua->ThoiGianYeuCau)->format('d-m-Y');
        });

        ThongBao::where('Icon', 'fa-solid fa-calendar-days')->update(['TrangThai' => 1]);

        return view('vLichSuaChua.lichsuachua', compact('dsLSCChuaHoanThanh', 'dsNhanVien', 'dsLSCtheongay'));
    }
  

    public function lichSuDaHoanThanh(Request $request)
    {
       
        $dsNhanVienYeuCau = NhanVien::where('MaBoPhan', 2)->get(); // Bộ phận yêu cầu
        $dsNhanVienKyThuat = NhanVien::where('MaBoPhan', 3)->get(); // Bộ phận kỹ thuật
        $dsMay = May::where('TrangThai', '!=', 1)->get();
        $query = LichSuaChua::query()
            ->join('yeucausuachua', 'lichsuachua.MaYeuCauSuaChua', '=', 'yeucausuachua.MaYeuCauSuaChua')
            ->join('may', 'yeucausuachua.MaMay', '=', 'may.MaMay') // để lọc theo tên máy
            ->whereIn('lichsuachua.TrangThai', ['1', '2'])
            ->orderByDesc('yeucausuachua.ThoiGianYeuCau')
            ->select('lichsuachua.*');

        // Lọc theo tháng
        if ($request->filled('thang')) {
            $month = date('m', strtotime($request->thang));
            $year = date('Y', strtotime($request->thang));
            $query->whereMonth('yeucausuachua.ThoiGianYeuCau', $month)
                ->whereYear('yeucausuachua.ThoiGianYeuCau', $year);
        }

        // Lọc theo tên máy
        if ($request->filled('TenMay')) {
            $query->where('may.TenMay', $request->TenMay);
        }

        // Lọc theo nhân viên yêu cầu (bộ phận 2)
        if ($request->filled('MaNhanVienYeuCau')) {
            $query->where('yeucausuachua.MaNhanVienYeuCau', $request->MaNhanVienYeuCau);
        }

        // Lọc theo nhân viên kỹ thuật (bộ phận 3)
        if ($request->filled('MaNhanVienKyThuat')) {
            $query->where('lichsuachua.MaNhanVienKyThuat', $request->MaNhanVienKyThuat);
        }
        if ($request->filled('TrangThai')) {
        $query->where('lichsuachua.TrangThai', $request->TrangThai);
        }
        $dsLSCDaHoanThanh = $query
            ->with(['yeuCauSuaChua', 'nhanVienKyThuat'])
            ->paginate(10, ['*'], 'da_hoan_thanh');

        return view('vLichSu.lichsusuachua', [
            'dsLSCDaHoanThanh' => $dsLSCDaHoanThanh,
            'dsNhanVien' => $dsNhanVienKyThuat, // dùng nếu view cũ cần
            'dsNhanVienYeuCau' => $dsNhanVienYeuCau,
            'dsNhanVienKyThuat' => $dsNhanVienKyThuat,
            'dsMay' => $dsMay,
        ]);
    }



    public function taoPhieuBanGiaoNoiBo($MaLichSuaChua)
    {
        // Lấy thông tin lịch sửa chữa cùng với phiếu bàn giao nội bộ
        $lichSuaChua = LichSuaChua::with(['yeuCauSuaChua', 'nhanVienKyThuat', 'phieuBanGiaoNoiBo'])->findOrFail($MaLichSuaChua);

        // Kiểm tra nếu chưa có mã phiếu bàn giao nội bộ
        if (!$lichSuaChua->phieuBanGiaoNoiBo) {
            // Tạo một đối tượng giả để hiển thị mã phiếu bàn giao nội bộ bằng mã lịch sửa chữa
            $lichSuaChua->phieuBanGiaoNoiBo = (object) [
                'MaPhieuBanGiaoNoiBo' => $MaLichSuaChua,
                'ThoiGianBanGiao' => null,
                'BienPhapXuLy' => null,
                'GhiChu' => null,
            ];
        }
      
        return view('vPhieuBanGiao.pbgNoiBo', compact('lichSuaChua'));
    }


    public function xemNCC($MaLichSuaChua)
    {
       
        $lichSuaChua = LichSuaChua::with(['yeuCauSuaChua.may.nhaCungCap'])->findOrFail($MaLichSuaChua);

      
        $nhaCungCap = $lichSuaChua->yeuCauSuaChua->may->nhaCungCap;

       
        if (!$nhaCungCap) {
            return redirect()->back()->with('error', 'Không tìm thấy thông tin nhà cung cấp.');
        }

      
        return view('vPhieuBanGiao.xemnhacungcap', compact('nhaCungCap', 'lichSuaChua'));
    }

    public function exporttscSC($MaLichSuaChua)
    {
        $lichSuaChua = LichSuaChua::with(['yeuCauSuaChua'])
            ->where('MaLichSuaChua', $MaLichSuaChua)
            ->firstOrFail();
    
        $pdf = PDF::loadView('vLichSuaChua.exporttscSC', ['lichSuaChua' => $lichSuaChua]);
    
        return $pdf->stream('phieu_ban_giao_' . $MaLichSuaChua . '.pdf');
    }

    public function bangiaoNhaCungCap($MaLichSuaChua)
    {
        
        $lichSuaChua = LichSuaChua::with(['yeuCauSuaChua.may.nhaCungCap'])->findOrFail($MaLichSuaChua);

        
        $nhaCungCap = $lichSuaChua->yeuCauSuaChua->may->nhaCungCap;

        //Lấy ngày hết bảo hành của máy
        $ngayHetBaoHanh = null;
        if ($lichSuaChua->yeuCauSuaChua->may->ThoiGianDuaVaoSuDung && $lichSuaChua->yeuCauSuaChua->may->ThoiGianBaoHanh) {
            $ngayHetBaoHanh = Carbon::parse($lichSuaChua->yeuCauSuaChua->may->ThoiGianDuaVaoSuDung)->addMonths($lichSuaChua->yeuCauSuaChua->may->ThoiGianBaoHanh);
        }

       
        if (!$nhaCungCap) {
            return redirect()->back()->with('error', 'Không tìm thấy thông tin nhà cung cấp.');
        }

        // Trả về view tạo phiếu bàn giao nhà cung cấp
        return view('vPhieuBanGiao.pbgNCC', compact('lichSuaChua', 'nhaCungCap', 'ngayHetBaoHanh'));
    }
    public function show($MaLichSuaChua)
    {
        $lichSuaChua = LichSuaChua::with([
            'yeuCauSuaChua.may',
            'yeuCauSuaChua.nhanVien',
            'nhanVienKyThuat',
            'phieuBanGiaoNoiBo.chiTietPhieuBanGiaoNoiBo.LinhKienSuaChua.donViTinh',
            'phieuBanGiaoNoiBo.nhanVienTao'
        ])->findOrFail($MaLichSuaChua);

        $phieuBanGiaoNoiBo = $lichSuaChua->phieuBanGiaoNoiBo;

        return view('vPhieuBanGiao.detailpbgNB', compact('lichSuaChua', 'phieuBanGiaoNoiBo'));
    }



    public function show1($MaLichSuaChua)
    {
        // Lấy lịch sửa chữa + yêu cầu sửa chữa + máy + nhà cung cấp + phiếu bàn giao NCC
        $lichSuaChua = LichSuaChua::with([
            'yeuCauSuaChua.may.nhaCungCap',
            'phieuBanGiaoSuaChuaNCC',
            'phieuBanGiaoSuaChuaNCC.chiTietPhieuBanGiaoSuaChuaNCC',
            'phieuBanGiaoSuaChuaNCC.nhanVienTao'
        ])->findOrFail($MaLichSuaChua);

       
        $nhaCungCap = $lichSuaChua->yeuCauSuaChua->may->nhaCungCap ?? null;

        
        if (!$nhaCungCap) {
            return redirect()->back()->with('error', 'Không tìm thấy thông tin nhà cung cấp.');
        }

        
        return view('vPhieuBanGiao.detailpbgNCC', compact('lichSuaChua', 'nhaCungCap'));
    }

}
