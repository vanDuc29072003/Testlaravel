<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\LinhKien;
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
        // Xử lý khoảng thời gian
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
                $startDate = $request->input('start_date');
                $endDate = $request->input('end_date');
                break;
        }
        // Tổng số yêu cầu sửa chữa trong khoảng thời gian
        $tongSoYeuCauSuaChua = DB::table('yeucausuachua')
            ->whereBetween('thoigianyeucau', [$startDate, $endDate])
            ->count();

        // Đếm số lần yêu cầu sửa chữa theo máy
        $thongKeSuaChua = DB::table('yeucausuachua')
            ->select('mamay', DB::raw('count(*) as SoLanSuaChua'))
            ->whereBetween('thoigianyeucau', [$startDate, $endDate])
            ->groupBy('mamay')
            ->orderByDesc('SoLanSuaChua')

            ->get();

        // Lấy tên máy từ bảng máy (nếu cần)
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
        $thongKeSuaChua = $thongKeSuaChua->sort(function ($a, $b) {
            // So sánh số lần sửa chữa giảm dần
            if ($a['SoLanSuaChua'] !== $b['SoLanSuaChua']) {
                return $b['SoLanSuaChua'] <=> $a['SoLanSuaChua'];
            }
            // Nếu bằng nhau, so sánh MaMay2 tăng dần
            return strcmp($a['MaMay2'], $b['MaMay2']);
        })->values(); // Reset lại index sau khi sort
        return view('vThongKe.thongkesuachua', compact('thongKeSuaChua', 'startDate', 'endDate', 'tongSoYeuCauSuaChua'));
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

}