<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\LinhKien;

use App\Models\May;
use App\Models\DonViTinh;
use App\Models\ChiTietPhieuNhap;
use App\Models\ChiTietPhieuXuat;
use App\Models\ChiTietPhieuBanGiaoNoiBo;
use App\Models\ChiTietPhieuTra;
use App\Models\LichSuaChua;
use App\Models\LichBaoTri;
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

        // Lọc theo tên hàng và đơn vị tính
        $tenHang = $request->input('ten_hang');
        $dvt = $request->input('dvt');

        // Lấy danh sách đơn vị tính cho filter
        $dsDonViTinh = DonViTinh::all();

        // Lấy danh sách linh kiện theo filter
        $linhKienQuery = LinhKien::with('donViTinh');

        if ($tenHang) {
            $linhKienQuery->where('TenLinhKien', 'like', '%' . $tenHang . '%');
        }
        if ($dvt) {
            $linhKienQuery->where('MaDonViTinh', '=', $dvt);
        }

        $linhKien = $linhKienQuery->get();

        // Tính toán thống kê cho từng linh kiện
        $thongKe = $linhKien->map(function ($item) use ($startDate, $endDate) {
            return [
                'MaHang' => $item->MaLinhKien,
                'TenHang' => $item->TenLinhKien,
                'DVT' => $item->donViTinh->TenDonViTinh ?? 'N/A',
                'TongNhap' => ChiTietPhieuNhap::where('MaLinhKien', $item->MaLinhKien)
                    ->whereHas('phieuNhap', function ($query) {
                        $query->where('TrangThai', 1);
                    })
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

        // Trả về view với dữ liệu thống kê và danh sách đơn vị tính cho filter
        return view('vThongKe.thongkekho', compact('thongKe', 'startDate', 'endDate', 'dsDonViTinh'));
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

        // Lọc theo tên hàng và đơn vị tính
        $tenHang = $request->input('ten_hang');
        $dvt = $request->input('dvt');

        // Lấy danh sách đơn vị tính cho filter
        $dsDonViTinh = DonViTinh::all();

        // Lấy danh sách linh kiện theo filter
        $linhKienQuery = LinhKien::with('donViTinh');

        if ($tenHang) {
            $linhKienQuery->where('TenLinhKien', 'like', '%' . $tenHang . '%');
        }
        if ($dvt) {
            $linhKienQuery->where('MaDonViTinh', '=', $dvt);
        }

        $linhKien = $linhKienQuery->get();

        // Tính toán thống kê cho từng linh kiện
        $thongKe = $linhKien->map(function ($item) use ($startDate, $endDate) {
            return [
                'MaHang' => $item->MaLinhKien,
                'TenHang' => $item->TenLinhKien,
                'DVT' => $item->donViTinh->TenDonViTinh ?? 'N/A',
                'TongNhap' => ChiTietPhieuNhap::where('MaLinhKien', $item->MaLinhKien)
                    ->whereHas('phieuNhap', function ($query) {
                        $query->where('TrangThai', 1);
                    })
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
        $dsLoaiMay = DB::table('loaimay')->select('MaLoai', 'TenLoai')->distinct()->get();

        $filterType = $request->input('filter_type', 'all');
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

        $loaiMay = $request->input('loai_may');
        $tenMay = $request->input('ten_may');

        // Subquery: Sửa chữa
        $repairSub = DB::table('lichsuachua')
            ->join('yeucausuachua', 'lichsuachua.MaYeuCauSuaChua', '=', 'yeucausuachua.MaYeuCauSuaChua')
            ->leftJoin('phieubangiaosuachuanhacungcap', 'lichsuachua.MaLichSuaChua', '=', 'phieubangiaosuachuanhacungcap.MaLichSuaChua')
            ->select(
                'yeucausuachua.MaMay',
                DB::raw('COUNT(DISTINCT lichsuachua.MaLichSuaChua) AS SoLanSuaChua'),
                DB::raw('COALESCE(SUM(DISTINCT phieubangiaosuachuanhacungcap.TongTien), 0) AS TongChiPhiSuaChua')
            )
            ->whereBetween('lichsuachua.created_at', [$startDate, $endDate])
            ->groupBy('yeucausuachua.MaMay');

        // Subquery: Bảo trì
        $maintenanceSub = DB::table('lichbaotri')
            ->leftJoin('phieubangiaobaotri', 'lichbaotri.MaLichBaoTri', '=', 'phieubangiaobaotri.MaLichBaoTri')
            ->select(
                'lichbaotri.MaMay',
                DB::raw('COUNT(DISTINCT lichbaotri.MaLichBaoTri) AS SoLanBaoTri'),
                DB::raw('COALESCE(SUM(DISTINCT phieubangiaobaotri.TongTien), 0) AS TongChiPhiBaoTri')
            )
            ->where('lichbaotri.TrangThai', 1)
            ->whereBetween('lichbaotri.NgayBaoTri', [$startDate, $endDate])
            ->groupBy('lichbaotri.MaMay');

        // Truy vấn chính
        $query = DB::table('may')
            ->leftJoinSub($repairSub, 'repairs', 'may.MaMay', '=', 'repairs.MaMay')
            ->leftJoinSub($maintenanceSub, 'maintenances', 'may.MaMay', '=', 'maintenances.MaMay')
            ->select(
                'may.MaMay',
                'may.MaMay2',
                'may.TenMay',
                DB::raw('COALESCE(repairs.SoLanSuaChua, 0) AS SoLanSuaChua'),
                DB::raw('COALESCE(repairs.TongChiPhiSuaChua, 0) AS TongChiPhiSuaChua'),
                DB::raw('COALESCE(maintenances.SoLanBaoTri, 0) AS SoLanBaoTri'),
                DB::raw('COALESCE(maintenances.TongChiPhiBaoTri, 0) AS TongChiPhiBaoTri')
            );

        if ($loaiMay) {
            $query->where('may.MaLoai', $loaiMay);
        }

        if ($tenMay) {
            $query->where('may.TenMay', 'like', "%{$tenMay}%");
        }

        $thongKeMay = $query->get()->filter(function ($item) {
            return $item->SoLanSuaChua > 0 || $item->SoLanBaoTri > 0;
        })->values();


        // Sắp xếp
        $sortOrder = $request->input('sort_order', 'desc');
        $thongKeMay = $thongKeMay->sortBy([
            ['SoLanSuaChua', $sortOrder],
            ['MaMay2', 'asc'],
        ])->values();

        return view('vThongKe.thongkesuachua', compact(
            'thongKeMay',
            'startDate',
            'endDate',
            'timeFilter',
            'sortOrder',
            'dsLoaiMay',
            'loaiMay',
            'tenMay',
            'filterType'
        ));
    }




    public function exportPDF1(Request $request)
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

        $loaiMay = $request->input('loai_may');
        $tenMay = $request->input('ten_may');

        // Subquery: Sửa chữa
        $repairSub = DB::table('lichsuachua')
            ->join('yeucausuachua', 'lichsuachua.MaYeuCauSuaChua', '=', 'yeucausuachua.MaYeuCauSuaChua')
            ->leftJoin('phieubangiaosuachuanhacungcap', 'lichsuachua.MaLichSuaChua', '=', 'phieubangiaosuachuanhacungcap.MaLichSuaChua')
            ->select(
                'yeucausuachua.MaMay',
                DB::raw('COUNT(DISTINCT lichsuachua.MaLichSuaChua) AS SoLanSuaChua'),
                DB::raw('COALESCE(SUM(DISTINCT phieubangiaosuachuanhacungcap.TongTien), 0) AS TongChiPhiSuaChua')
            )
            ->whereBetween('lichsuachua.created_at', [$startDate, $endDate])
            ->groupBy('yeucausuachua.MaMay');

        // Subquery: Bảo trì
        $maintenanceSub = DB::table('lichbaotri')
            ->leftJoin('phieubangiaobaotri', 'lichbaotri.MaLichBaoTri', '=', 'phieubangiaobaotri.MaLichBaoTri')
            ->select(
                'lichbaotri.MaMay',
                DB::raw('COUNT(DISTINCT lichbaotri.MaLichBaoTri) AS SoLanBaoTri'),
                DB::raw('COALESCE(SUM(DISTINCT phieubangiaobaotri.TongTien), 0) AS TongChiPhiBaoTri')
            )
            ->where('lichbaotri.TrangThai', 1)
            ->whereBetween('lichbaotri.NgayBaoTri', [$startDate, $endDate])
            ->groupBy('lichbaotri.MaMay');

        // Truy vấn chính lấy thông tin máy + sửa chữa + bảo trì
        $query = DB::table('may')
            ->leftJoinSub($repairSub, 'repairs', 'may.MaMay', '=', 'repairs.MaMay')
            ->leftJoinSub($maintenanceSub, 'maintenances', 'may.MaMay', '=', 'maintenances.MaMay')
            ->select(
                'may.MaMay',
                'may.MaMay2',
                'may.TenMay',
                DB::raw('COALESCE(repairs.SoLanSuaChua, 0) AS SoLanSuaChua'),
                DB::raw('COALESCE(repairs.TongChiPhiSuaChua, 0) AS TongChiPhiSuaChua'),
                DB::raw('COALESCE(maintenances.SoLanBaoTri, 0) AS SoLanBaoTri'),
                DB::raw('COALESCE(maintenances.TongChiPhiBaoTri, 0) AS TongChiPhiBaoTri')
            );

        if ($loaiMay) {
            $query->where('may.MaLoai', $loaiMay);
        }

        if ($tenMay) {
            $query->where('may.TenMay', 'like', "%{$tenMay}%");
        }

        // Lấy dữ liệu và lọc ra những máy có ít nhất 1 lần sửa chữa hoặc bảo trì
        $thongKeMay = $query->get()->filter(function ($item) {
            return $item->SoLanSuaChua > 0 || $item->SoLanBaoTri > 0;
        })->values();

        // Tính tổng số lần sửa chữa
        $tongSoYeuCauSuaChua = $thongKeMay->sum('SoLanSuaChua');
        $tongSoBaoTri = $thongKeMay -> sum('SoLanBaoTri');
        // Sắp xếp dữ liệu theo số lần sửa chữa và mã máy 2
        $sortOrder = $request->input('sort_order', 'desc');
        $thongKeMay = $thongKeMay->sortBy([
            ['SoLanSuaChua', $sortOrder],
            ['MaMay2', 'asc'],
        ])->values();

        $ngayLap = now()->format('d/m/Y H:i');
        $nguoiTao = Auth::user()->nhanvien->TenNhanVien;

        $pdf = PDF::loadView('vThongKe.pdfthongkesuachua', compact(
            'thongKeMay',
            'startDate',
            'endDate',
            'tongSoYeuCauSuaChua',
            'tongSoBaoTri',
            'ngayLap',
            'nguoiTao'
        ));

        return $pdf->stream('thongkesuachua.pdf');
    }



    public function detailSC(Request $request, $maMay)
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

        // Truy vấn chi tiết sửa chữa liên quan đến máy trong khoảng thời gian
        $chiTietSuaChua = LichSuaChua::whereHas('yeuCauSuaChua', function ($query) use ($maMay, $startDate, $endDate) {
            $query->where('MaMay', $maMay)
                ->whereBetween('created_at', [$startDate, $endDate]);
        })
            ->with([
                'yeuCauSuaChua.may',
                'yeuCauSuaChua.nhanVien',
                'nhanVienKyThuat',
                'phieuBanGiaoNoiBo.nhanVienTao',
                'phieuBanGiaoSuaChuaNCC.nhaCungCap'
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('vThongKe.detailSC', compact(
            'chiTietSuaChua',
            'maMay',
            'startDate',
            'endDate',
            'timeFilter'
        ));
    }

    public function detailBT(Request $request, $maMay)
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

        $chiTietBaoTri = May::where('MaMay', $maMay)
            ->with([
                'nhaCungCap',
                'lichBaoTri' => function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('NgayBaoTri', [$startDate, $endDate])
                        ->orderBy('NgayBaoTri', 'desc');
                },
                'lichBaoTri.phieuBanGiaoBaoTri.nhanVien' // lấy tên nhân viên bàn giao
            ])
            ->first();

        return view('vThongKe.detailBT', compact('chiTietBaoTri', 'maMay', 'startDate', 'endDate', 'timeFilter'));
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
            ->join('phieuxuat as px', 'ctpx.MaPhieuXuat', '=', 'px.MaPhieuXuat') // join thêm bảng phieuxuat
            ->join('linhkiensuachua as lk', 'ctpx.MaLinhKien', '=', 'lk.MaLinhKien')
            ->join('donvitinh as dvt', 'lk.MaDonViTinh', '=', 'dvt.MaDonViTinh')
            ->whereBetween('px.NgayXuat', [$startDate, $endDate]) // lọc theo thời gian của phieuxuat
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
            $query->where(
                'lk.MaDonViTinh',
                $maDonViTinh
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