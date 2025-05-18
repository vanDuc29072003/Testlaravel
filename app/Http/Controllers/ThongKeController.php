<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\LinhKien;
use App\Models\DonViTinh;
use App\Models\ChiTietPhieuNhap;
use App\Models\ChiTietPhieuXuat;
use App\Models\ChiTietPhieuBanGiaoNoiBo;
use App\Models\ChiTietPhieuTra;
use App\Models\YeuCauSuaChua;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class ThongKeController extends Controller
{
    public function thongkekho(Request $request)
    {
        // Xử lý khoảng thời gian dựa trên tùy chọn
        $timeFilter = $request->input('time_filter', 'this_month');
        $startDate = now()->startOfMonth();
        $endDate = now()->endOfMonth();

        switch ($timeFilter) {
            case 'today':
                $startDate = now()->startOfDay();
                $endDate = now()->endOfDay();
                break;
            case 'yesterday':
                $startDate = now()->subDay()->startOfDay();
                $endDate = now()->subDay()->endOfDay();
                break;
            case 'last_7_days':
                $startDate = now()->subDays(7)->startOfDay();
                $endDate = now()->endOfDay();
                break;
            case 'last_month':
                $startDate = now()->subMonth()->startOfMonth();
                $endDate = now()->subMonth()->endOfMonth();
                break;
            case 'this_quarter':
                $startDate = now()->firstOfQuarter();
                $endDate = now()->lastOfQuarter();
                break;
            case 'custom':
                $startDate = $request->input('start_date');
                $endDate = $request->input('end_date');
                break;
        }

        // Lấy danh sách tất cả các linh kiện
        $linhKien = LinhKien::with('donViTinh')->get();

        // Tính toán thống kê cho từng linh kiện
        $thongKe = $linhKien->map(function ($item) use ($startDate, $endDate) {
            return [
                'MaHang' => $item->MaLinhKien,
                'TenHang' => $item->TenLinhKien,
                'DVT' => $item->donViTinh->TenDonViTinh ?? 'N/A',
                'TongNhap' => ChiTietPhieuNhap::where('MaLinhKien', $item->MaLinhKien)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->sum('SoLuong'),
                'TongXuat' => ChiTietPhieuXuat::where('MaLinhKien', $item->MaLinhKien)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->sum('SoLuong'),
                'TongTraKho' => ChiTietPhieuTra::where('MaLinhKien', $item->MaLinhKien)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->sum('SoLuong'),
                'TongBanGiao' => ChiTietPhieuBanGiaoNoiBo::where('MaLinhKien', $item->MaLinhKien)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->sum('SoLuong'),
                'TonKho' => $item->SoLuong,
                'ChenhLech' => ChiTietPhieuBanGiaoNoiBo::where('MaLinhKien', $item->MaLinhKien)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->sum('SoLuong') -
                    ChiTietPhieuXuat::where('MaLinhKien', $item->MaLinhKien)
                        ->whereBetween('created_at', [$startDate, $endDate])
                        ->sum('SoLuong'),
            ];
        });

        // Trả về view với dữ liệu thống kê
        return view('vThongKe.thongkekho', compact('thongKe', 'startDate', 'endDate'));
    }

    public function exportPDF(Request $request)
    {
        // Lấy dữ liệu thống kê từ phương thức `thongkekho`
        $timeFilter = $request->input('time_filter', 'this_month');
        $startDate = now()->startOfMonth();
        $endDate = now()->endOfMonth();

        switch ($timeFilter) {
            case 'today':
                $startDate = now()->startOfDay();
                $endDate = now()->endOfDay();
                break;
            case 'yesterday':
                $startDate = now()->subDay()->startOfDay();
                $endDate = now()->subDay()->endOfDay();
                break;
            case 'last_7_days':
                $startDate = now()->subDays(7)->startOfDay();
                $endDate = now()->endOfDay();
                break;
            case 'last_month':
                $startDate = now()->subMonth()->startOfMonth();
                $endDate = now()->subMonth()->endOfMonth();
                break;
            case 'this_quarter':
                $startDate = now()->firstOfQuarter();
                $endDate = now()->lastOfQuarter();
                break;
            case 'custom':
                $startDate = $request->input('start_date');
                $endDate = $request->input('end_date');
                break;
        }

        // Lấy danh sách tất cả các linh kiện
        $linhKien = LinhKien::with('donViTinh')->get();

        // Tính toán thống kê cho từng linh kiện
        $thongKe = $linhKien->map(function ($item) use ($startDate, $endDate) {
            return [
                'MaHang' => $item->MaLinhKien,
                'TenHang' => $item->TenLinhKien,
                'DVT' => $item->donViTinh->TenDonViTinh ?? 'N/A',
                'TongNhap' => ChiTietPhieuNhap::where('MaLinhKien', $item->MaLinhKien)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->sum('SoLuong'),
                'TongXuat' => ChiTietPhieuXuat::where('MaLinhKien', $item->MaLinhKien)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->sum('SoLuong'),
                'TongTraKho' => ChiTietPhieuTra::where('MaLinhKien', $item->MaLinhKien)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->sum('SoLuong'),
                'TongBanGiao' => ChiTietPhieuBanGiaoNoiBo::where('MaLinhKien', $item->MaLinhKien)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->sum('SoLuong'),
                'TonKho' => $item->SoLuong,
                'ChenhLech' => ChiTietPhieuBanGiaoNoiBo::where('MaLinhKien', $item->MaLinhKien)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->sum('SoLuong') -
                    ChiTietPhieuXuat::where('MaLinhKien', $item->MaLinhKien)
                        ->whereBetween('created_at', [$startDate, $endDate])
                        ->sum('SoLuong'),
            ];
        });

        // Thông tin bổ sung
        $ngayLap = now()->format('d/m/Y H:i');
        $nguoiTao = Auth::user()->nhanvien->TenNhanVien;

        // Render view PDF
        $pdf = PDF::loadView('vThongKe.pdfthongkekho', compact('thongKe', 'startDate', 'endDate', 'ngayLap', 'nguoiTao'));

        return $pdf->stream('thongkekho.pdf');
    }

    public function thongkesuachua(Request $request)
    {
        $dsLoaiMay = DB::table('loaimay')
            ->select('MaLoai', 'TenLoai')
            ->distinct()
            ->get();

        // Lọc theo thời gian
        $timeFilter = $request->input('time_filter', 'today');
        $startDate = now()->startOfDay();
        $endDate = now()->endOfDay();

        switch ($timeFilter) {
            case 'today':
                $startDate = now()->startOfDay();
                $endDate = now()->endOfDay();
                break;
            case 'yesterday':
                $startDate = now()->subDay()->startOfDay();
                $endDate = now()->subDay()->endOfDay();
                break;
            case 'this_month':
                $startDate = now()->startOfMonth();
                $endDate = now()->endOfMonth();
                break;
            case 'custom':
                $startDate = $request->input('start_date');
                $endDate = $request->input('end_date');
                break;
        }

        // Lọc theo loại máy và tên máy
        $loaiMay = $request->input('loai_may');
        $tenMay = $request->input('ten_may');

        // Câu truy vấn chính
        $query = DB::table('yeucausuachua')
            ->join('may', 'yeucausuachua.mamay', '=', 'may.MaMay')
            ->select('yeucausuachua.mamay', DB::raw('count(*) as SoLanSuaChua'))
            ->whereBetween('yeucausuachua.thoigianyeucau', [$startDate, $endDate]);

        if ($loaiMay) {
            $query->where('may.MaLoai', $loaiMay);
        }

        if ($tenMay) {
            $query->where('may.TenMay', 'like', "%{$tenMay}%");
        }

        $thongKeSuaChua = $query
            ->groupBy('yeucausuachua.mamay')
            ->get();

        $tongSoYeuCauSuaChua = $thongKeSuaChua->sum('SoLanSuaChua');

        // Lấy thông tin tên máy và mã máy 2
        $danhSachMay = DB::table('may')->pluck('TenMay', 'MaMay');
        $MaMay2 = DB::table('may')->pluck('MaMay2', 'MaMay');

        // Gộp dữ liệu
        $thongKeSuaChua = $thongKeSuaChua->map(function ($item) use ($danhSachMay, $MaMay2) {
            return [
                'MaMay' => $item->mamay,
                'MaMay2' => $MaMay2[$item->mamay] ?? 'Không rõ',
                'TenMay' => $danhSachMay[$item->mamay] ?? 'Không rõ',
                'SoLanSuaChua' => $item->SoLanSuaChua,
            ];
        });

        // Sắp xếp theo yêu cầu (tăng/giảm dần)
        $sortOrder = $request->input('sort_order', 'desc'); // 'asc' hoặc 'desc'
        $thongKeSuaChua = $thongKeSuaChua->sort(function ($a, $b) use ($sortOrder) {
            if ($a['SoLanSuaChua'] !== $b['SoLanSuaChua']) {
                return $sortOrder === 'asc'
                    ? $a['SoLanSuaChua'] <=> $b['SoLanSuaChua']
                    : $b['SoLanSuaChua'] <=> $a['SoLanSuaChua'];
            }
            return strcmp($a['MaMay2'], $b['MaMay2']);
        })->values();

        return view('vThongKe.thongkesuachua', compact(
            'thongKeSuaChua',
            'startDate',
            'endDate',
            'tongSoYeuCauSuaChua',
            'timeFilter',
            'sortOrder',
            'dsLoaiMay',
            'loaiMay',
            'tenMay'
        ));
    }


    public function detail(Request $request, $maMay)
    {
        $timeFilter = $request->input('time_filter', 'today');

        $startDate = now()->startOfDay();
        $endDate = now()->endOfDay();

        switch ($timeFilter) {
            case 'today':
                $startDate = now()->startOfDay();
                $endDate = now()->endOfDay();
                break;
            case 'yesterday':
                $startDate = now()->subDay()->startOfDay();
                $endDate = now()->subDay()->endOfDay();
                break;
            case 'last_7_days':
                $startDate = now()->subDays(7)->startOfDay();
                $endDate = now()->endOfDay();
                break;
            case 'this_month':
                $startDate = now()->startOfMonth();
                $endDate = now()->endOfMonth();
                break;
            case 'last_month':
                $startDate = now()->subMonth()->startOfMonth();
                $endDate = now()->subMonth()->endOfMonth();
                break;
            case 'this_quarter':
                $startDate = now()->firstOfQuarter();
                $endDate = now()->lastOfQuarter();
                break;
            case 'custom':
                $startDate = $request->input('start_date') ?? now()->startOfDay();
                $endDate = $request->input('end_date') ?? now()->endOfDay();
                break;
        }

        // Truy vấn theo mã máy và khoảng thời gian
        $chiTietSuaChua = YeuCauSuaChua::where('MaMay', $maMay)
            ->whereBetween('ThoiGianYeuCau', [$startDate, $endDate])
            ->with('nhanVien', 'may')
            ->orderBy('ThoiGianYeuCau', 'desc')
            ->get();

        return view('vThongKe.detailSC', compact('chiTietSuaChua', 'maMay', 'startDate', 'endDate', 'timeFilter'));
    }
    public function thongkelinhkienxuat(Request $request)
    {
        // 1. Xử lý khoảng thời gian
        $timeFilter = $request->input('time_filter', 'today');
        $startDate = now()->startOfDay();
        $endDate = now()->endOfDay();

        switch ($timeFilter) {
            case 'yesterday':
                $startDate = now()->subDay()->startOfDay();
                $endDate = now()->subDay()->endOfDay();
                break;
            case 'this_month':
                $startDate = now()->startOfMonth();
                $endDate = now()->endOfMonth();
                break;
            case 'custom':
                $startDate = $request->input('start_date');
                $endDate = $request->input('end_date');
                break;
        }

        // 2. Các bộ lọc
        $tenLinhKien = $request->input('ten_linh_kien'); // view đang dùng tên này
        $maDonViTinh = $request->input('ma_dvt');
        $sortOrder = $request->input('sort_quantity'); // 'asc' hoặc 'desc'

        // 3. Truy vấn chính
        $query = DB::table('chitietphieuxuat as ctpx')
            ->join('linhkiensuachua as lk', 'ctpx.MaLinhKien', '=', 'lk.MaLinhKien')
            ->join('donvitinh as dvt', 'lk.MaDonViTinh', '=', 'dvt.MaDonViTinh')
            ->whereBetween('ctpx.created_at', [$startDate, $endDate])
            ->select(
                'ctpx.MaLinhKien',
                'lk.TenLinhKien',
                'dvt.TenDonViTinh',
                DB::raw('SUM(ctpx.SoLuong) as TongXuat')
            )
            ->groupBy('ctpx.MaLinhKien', 'lk.TenLinhKien', 'dvt.TenDonViTinh');

        if ($tenLinhKien) {
            $query->where('lk.TenLinhKien', 'like', '%' . $tenLinhKien . '%');
        }

        if ($maDonViTinh) {
            $query->where('lk.MaDonViTinh', $maDonViTinh);
        }

        // 4. Lấy dữ liệu
        $thongKe = $query->get();

        // 5. Sắp xếp số lượng
        if ($sortOrder === 'asc') {
            $thongKe = $thongKe->sortBy('TongXuat')->values();
        } elseif ($sortOrder === 'desc') {
            $thongKe = $thongKe->sortByDesc('TongXuat')->values();
        }

        // 6. Danh sách đơn vị tính
        $danhSachDonViTinh = DB::table('donvitinh')->get();

        return view('vThongKe.thongkelinhkienxuat', compact(
            'thongKe',
            'startDate',
            'endDate',
            'danhSachDonViTinh'
        ));
    }
    public function exportPDF2(Request $request)
    {
        // 1. Xử lý khoảng thời gian
        $timeFilter = $request->input('time_filter', 'today');
        $startDate = now()->startOfDay();
        $endDate = now()->endOfDay();

        switch ($timeFilter) {
            case 'yesterday':
                $startDate = now()->subDay()->startOfDay();
                $endDate = now()->subDay()->endOfDay();
                break;
            case 'this_month':
                $startDate = now()->startOfMonth();
                $endDate = now()->endOfMonth();
                break;
            case 'custom':
                $startDate = $request->input('start_date');
                $endDate = $request->input('end_date');
                break;
        }

        // 2. Các bộ lọc
        $tenLinhKien = $request->input('ten_linh_kien'); // view đang dùng tên này
        $maDonViTinh = $request->input('ma_dvt');
        $sortOrder = $request->input('sort_quantity'); // 'asc' hoặc 'desc'

        // 3. Truy vấn chính
        $query = DB::table('chitietphieuxuat as ctpx')
            ->join('linhkiensuachua as lk', 'ctpx.MaLinhKien', '=', 'lk.MaLinhKien')
            ->join('donvitinh as dvt', 'lk.MaDonViTinh', '=', 'dvt.MaDonViTinh')
            ->whereBetween('ctpx.created_at', [$startDate, $endDate])
            ->select(
                'ctpx.MaLinhKien',
                'lk.TenLinhKien',
                'dvt.TenDonViTinh',
                DB::raw('SUM(ctpx.SoLuong) as TongXuat')
            )
            ->groupBy('ctpx.MaLinhKien', 'lk.TenLinhKien', 'dvt.TenDonViTinh');

        if ($tenLinhKien) {
            $query->where('lk.TenLinhKien', 'like', '%' . $tenLinhKien . '%');
        }

        if ($maDonViTinh) {
            $query->where('lk.MaDonViTinh', $maDonViTinh
            );
        }
        // 4. Lấy dữ liệu
        $thongKe = $query->get();   
        // 5. Sắp xếp số lượng
        if ($sortOrder === 'asc') {
            $thongKe = $thongKe->sortBy('TongXuat')->values();
        } elseif ($sortOrder === 'desc') {
            $thongKe = $thongKe->sortByDesc('TongXuat')->values();
        }
        // 6. Danh sách đơn vị tính
        $danhSachDonViTinh = DB::table('donvitinh')->get();
        // Thông tin bổ sung

        $ngayLap = now()->format('d/m/Y H:i');
        $nguoiTao = Auth::user()->nhanvien->TenNhanVien;
        // Render view PDF
        $pdf = PDF::loadView('vThongKe.pdfthongkelinhkienxuat', compact('thongKe', 'startDate', 'endDate', 'ngayLap', 'nguoiTao'));
        return $pdf->stream('thongkelinhkienxuat.pdf');
    }


    public function canhbaonhaphang(Request $request)
    {
        $sortOrder = $request->input('sort', 'asc'); // asc hoặc desc
        $donViFilter = $request->input('donvi');
        $colorFilter = $request->input('color');
        $searchName = $request->input('name');

        // Lấy tất cả linh kiện và đơn vị tính
        $query = LinhKien::with('donViTinh');

        // Lọc theo đơn vị tính
        if (!empty($donViFilter)) {
            $query->whereHas('donViTinh', function ($q) use ($donViFilter) {
                $q->where('TenDonViTinh', $donViFilter);
            });
        }

        // Lọc theo tên
        if (!empty($searchName)) {
            $query->where('TenLinhKien', 'like', '%' . $searchName . '%');
        }

        // Sắp xếp theo số lượng
        $query->orderBy('SoLuong', $sortOrder);

        $linhKienList = $query->get();

        // Danh sách đơn vị tính cho filter
        $dsDonViTinh = DonViTinh::pluck('TenDonViTinh');

        // Tạo danh sách cảnh báo
        $canhBaoList = $linhKienList->filter(function ($item) {
            return $item->SoLuong < 51; // chỉ lấy những cái dưới hoặc bằng 50
        })->map(function ($item) {
            if ($item->SoLuong < 20) {
                $mucDo = 'danger';
            } else { // từ 20 đến 50
                $mucDo = 'warning';
            }

            return [
                'MaLinhKien' => $item->MaLinhKien,
                'TenLinhKien' => $item->TenLinhKien,
                'SoLuong' => $item->SoLuong,
                'DVT' => $item->donViTinh->TenDonViTinh ?? 'N/A',
                'MucDo' => $mucDo
            ];
        });

        // Lọc màu (sau khi đã mapping)
        if ($colorFilter === 'red') {
            $canhBaoList = $canhBaoList->where('MucDo', 'danger');
        } elseif ($colorFilter === 'yellow') {
            $canhBaoList = $canhBaoList->where('MucDo', 'warning');
        }

        return view('vThongKe.canhbaonhaphang', compact('canhBaoList', 'dsDonViTinh', 'sortOrder', 'donViFilter', 'colorFilter', 'searchName'));
    }
    public function exportPDF3(Request $request)
    {
        $sortOrder = $request->input('sort', 'asc'); // asc hoặc desc
        $donViFilter = $request->input('donvi');
        $colorFilter = $request->input('color');
        $searchName = $request->input('name');

        // Lấy tất cả linh kiện và đơn vị tính
        $query = LinhKien::with('donViTinh');

        // Lọc theo đơn vị tính
        if (!empty($donViFilter)) {
            $query->whereHas('donViTinh', function ($q) use ($donViFilter) {
                $q->where('TenDonViTinh', $donViFilter);
            });
        }

        // Lọc theo tên
        if (!empty($searchName)) {
            $query->where('TenLinhKien', 'like', '%' . $searchName . '%');
        }

        // Sắp xếp theo số lượng
        $query->orderBy('SoLuong', $sortOrder);

        $linhKienList = $query->get();

        // Tạo danh sách cảnh báo
        $canhBaoList = $linhKienList->filter(function ($item) {
            return $item->SoLuong < 51; // chỉ lấy những cái dưới hoặc bằng 50
        })->map(function ($item) {
            if ($item->SoLuong < 20) {
                $mucDo = 'danger';
            } else { // từ 20 đến 50
                $mucDo = 'warning';
            }

            return [
                'MaLinhKien' => $item->MaLinhKien,
                'TenLinhKien' => $item->TenLinhKien,
                'SoLuong' => $item->SoLuong,
                'DVT' => $item->donViTinh->TenDonViTinh ?? 'N/A',
                'MucDo' => $mucDo
            ];
        });

        // Lọc màu (sau khi đã mapping)
        if ($colorFilter === 'red') {
            $canhBaoList = $canhBaoList->where('MucDo', 'danger');
        } elseif ($colorFilter === 'yellow') {
            $canhBaoList = $canhBaoList->where('MucDo', 'warning');
        }
        // Thông tin bổ sung
        $ngayLap = now()->format('d/m/Y H:i');
        $nguoiTao = Auth::user()->nhanvien->TenNhanVien;
        // Render view PDF
        $pdf = PDF::loadView('vThongKe.pdfcanhbaonhaphang', compact('canhBaoList', 'ngayLap', 'nguoiTao'));
        return $pdf->stream('canhbaonhaphang.pdf');
    }

}