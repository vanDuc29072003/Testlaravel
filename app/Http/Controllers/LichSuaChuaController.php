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

        // Danh sách các trường cần lọc
        $filters = [
            'MaLichSuaChua' => '=',
            'MaYeuCauSuaChua' => '=',
            'MaNhanVienKyThuat' => '='
        ];
        foreach ($filters as $field => $operator) {
            if ($request->filled($field)) {
                $value = $operator === 'like' ? '%' . $request->$field . '%' : $request->$field;
                $queryChuaHoanThanh->where($field, $operator, $value);
            }
        }

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
        // Lấy danh sách nhân viên theo bộ phận
        $dsNhanVienYeuCau = NhanVien::where('MaBoPhan', 2)->get(); // Bộ phận yêu cầu
        $dsNhanVienKyThuat = NhanVien::where('MaBoPhan', 3)->get(); // Bộ phận kỹ thuật
        $dsMay = May::all();

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
        // Truyền dữ liệu cần thiết sang view
        return view('vPhieuBanGiao.pbgNoiBo', compact('lichSuaChua'));
    }


    public function xemNCC($MaLichSuaChua)
    {
        // Lấy thông tin lịch sửa chữa
        $lichSuaChua = LichSuaChua::with(['yeuCauSuaChua.may.nhaCungCap'])->findOrFail($MaLichSuaChua);

        // Lấy thông tin nhà cung cấp từ mã máy
        $nhaCungCap = $lichSuaChua->yeuCauSuaChua->may->nhaCungCap;

        // Nếu không tìm thấy nhà cung cấp, trả về lỗi
        if (!$nhaCungCap) {
            return redirect()->back()->with('error', 'Không tìm thấy thông tin nhà cung cấp.');
        }

        // Trả về view hiển thị thông tin nhà cung cấp và lịch sửa chữa
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
        // Lấy thông tin lịch sửa chữa cùng với nhà cung cấp
        $lichSuaChua = LichSuaChua::with(['yeuCauSuaChua.may.nhaCungCap'])->findOrFail($MaLichSuaChua);

        // Lấy thông tin nhà cung cấp từ mã máy
        $nhaCungCap = $lichSuaChua->yeuCauSuaChua->may->nhaCungCap;

        // Nếu không tìm thấy nhà cung cấp, trả về lỗi
        if (!$nhaCungCap) {
            return redirect()->back()->with('error', 'Không tìm thấy thông tin nhà cung cấp.');
        }

        // Trả về view tạo phiếu bàn giao nhà cung cấp
        return view('vPhieuBanGiao.pbgNCC', compact('lichSuaChua', 'nhaCungCap'));
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

        // Lấy luôn nhà cung cấp
        $nhaCungCap = $lichSuaChua->yeuCauSuaChua->may->nhaCungCap ?? null;

        // Nếu không có nhà cung cấp thì trả về lỗi
        if (!$nhaCungCap) {
            return redirect()->back()->with('error', 'Không tìm thấy thông tin nhà cung cấp.');
        }

        // Truyền dữ liệu sang view vPhieuBanGiao.pbgNCC
        return view('vPhieuBanGiao.detailpbgNCC', compact('lichSuaChua', 'nhaCungCap'));
    }

}
