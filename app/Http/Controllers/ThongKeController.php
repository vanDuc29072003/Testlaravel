<?php

namespace App\Http\Controllers;

use App\Models\LinhKien;
use App\Models\ChiTietPhieuNhap;
use App\Models\ChiTietPhieuXuat;
use App\Models\ChiTietPhieuBanGiaoNoiBo;
use App\Models\ChiTietPhieuTra;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Auth;

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

        return $pdf->stream('thong_khe_kho_' . $ngayLap . '.pdf');
    }
}