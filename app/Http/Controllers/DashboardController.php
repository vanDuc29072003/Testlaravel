<?php

namespace App\Http\Controllers;

use App\Models\LichSuaChua;
use App\Models\LichVanHanh;
use App\Models\PhieuBanGiaoBaoTri;
use App\Models\PhieuBanGiaoSuaChuaNCC;
use App\Models\PhieuNhap;
use Illuminate\Http\Request;
use App\Models\YeuCauSuaChua;
use App\Models\LichBaoTri;
use App\Models\LinhKien;
use App\Models\PhieuThanhLy;
use App\Models\May;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $lichvanhanh = LichVanHanh::whereDate('NgayVanHanh', now()->format('Y-m-d'))->get();
        $lichbaotri = LichBaoTri::with('may')->whereBetween('NgayBaoTri', [now()->format('Y-m-d'), now()->addDays(7)->format('Y-m-d')])
            ->orderBy('NgayBaoTri', 'asc')
            ->get();
        $lichsuachua = LichSuaChua::whereDate('created_at', now()->format('Y-m-d'))->where('trangthai', '0')->get();
        $yeucausuachua = YeuCauSuaChua::whereDate('ThoiGianYeuCau', now()->format('Y-m-d'))->where('trangthai', '0')->get();
        $phieunhap = PhieuNhap::where('trangthai', '0')->get();
        $phieuthanhly = PhieuThanhLy::where('trangthai', '0')->get();

        $linhkienCanhBao = LinhKien::where('SoLuong', '<', 5)->orderBy('SoLuong', 'asc')->get();
        $mayHetBaoHanh = May::where('TrangThai', '!=', '1')
            ->whereRaw("
                DATE_ADD(`ThoiGianDuaVaoSuDung`, INTERVAL `ThoiGianBaoHanh` MONTH) > CURDATE()
                AND DATE_ADD(`ThoiGianDuaVaoSuDung`, INTERVAL `ThoiGianBaoHanh` MONTH) <= DATE_ADD(CURDATE(), INTERVAL 15 DAY)
            ")->get();
        $maySapHetKhauHao = May::where('TrangThai', '!=', '1')
            ->whereRaw("
                DATE_ADD(`ThoiGianDuaVaoSuDung`, INTERVAL `ThoiGianKhauHao` YEAR) > CURDATE()
                AND DATE_ADD(`ThoiGianDuaVaoSuDung`, INTERVAL `ThoiGianKhauHao` YEAR) <= DATE_ADD(CURDATE(), INTERVAL 15 DAY)
            ")->get();
        $mayDaHetKhauHao = May::where('TrangThai', '!=', '1')
            ->whereRaw("
                DATE_ADD(`ThoiGianDuaVaoSuDung`, INTERVAL `ThoiGianKhauHao` YEAR) <= CURDATE()
            ")->get();

        $labels_ycsc_7ngay = [];
        $data_ycsc_7ngay = [];
        $labels_ycsc_30ngay = [];
        $data_ycsc_30ngay = [];

        // 7 ngày gần nhất
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels_ycsc_7ngay[] = $date->format('d/m');
            $data_ycsc_7ngay[] = YeuCauSuaChua::whereDate('ThoiGianYeuCau', $date)->count();
        }

        // 30 ngày gần nhất
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels_ycsc_30ngay[] = $date->format('d/m');
            $data_ycsc_30ngay[] = YeuCauSuaChua::whereDate('ThoiGianYeuCau', $date)->count();
        }

        $ycscData = [
            '7ngay' => [
                'labels' => $labels_ycsc_7ngay,
                'data' => $data_ycsc_7ngay,
            ],
            '30ngay' => [
                'labels' => $labels_ycsc_30ngay,
                'data' => $data_ycsc_30ngay,
            ]
        ];
        // Tháng này: từng ngày
        $startThisMonth = Carbon::now()->startOfMonth();
        $endThisMonth = Carbon::now();
        $labels_this_month = [];
        $cost_nhapkho_this_month = [];
        $cost_baotri_this_month = [];
        $cost_suachua_this_month = [];
        for ($date = $startThisMonth->copy(); $date->lte($endThisMonth); $date->addDay()) {
            $labels_this_month[] = $date->format('d/m');
            $cost_nhapkho_this_month[] = PhieuNhap::whereDate('NgayNhap', $date)->sum('TongTien');
            $cost_baotri_this_month[] = PhieuBanGiaoBaoTri::whereDate('ThoiGianBanGiao', $date)->sum('TongTien');
            $cost_suachua_this_month[] = PhieuBanGiaoSuaChuaNCC::whereDate('ThoiGianBanGiao', $date)->sum('TongTien');
        }

        // Tháng trước: từng ngày
        $startLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endLastMonth = Carbon::now()->subMonth()->endOfMonth();
        $labels_last_month = [];
        $cost_nhapkho_last_month = [];
        $cost_baotri_last_month = [];
        $cost_suachua_last_month = [];
        for ($date = $startLastMonth->copy(); $date->lte($endLastMonth); $date->addDay()) {
            $labels_last_month[] = $date->format('d/m');
            $cost_nhapkho_last_month[] = PhieuNhap::whereDate('NgayNhap', $date)->sum('TongTien');
            $cost_baotri_last_month[] = PhieuBanGiaoBaoTri::whereDate('ThoiGianBanGiao', $date)->sum('TongTien');
            $cost_suachua_last_month[] = PhieuBanGiaoSuaChuaNCC::whereDate('ThoiGianBanGiao', $date)->sum('TongTien');
        }

        // 6 tháng gần nhất: từng tháng
        $labels_six_months = [];
        $cost_nhapkho_six_month = [];
        $cost_baotri_six_month = [];
        $cost_suachua_six_month = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $labels_six_months[] = $month->format('m/Y');
            $cost_nhapkho_six_month[] = PhieuNhap::whereYear('NgayNhap', $month->year)
                ->whereMonth('NgayNhap', $month->month)
                ->sum('TongTien');
            $cost_baotri_six_month[] = PhieuBanGiaoBaoTri::whereYear('ThoiGianBanGiao', $month->year)
                ->whereMonth('ThoiGianBanGiao', $month->month)
                ->sum('TongTien');
            $cost_suachua_six_month[] = PhieuBanGiaoSuaChuaNCC::whereYear('ThoiGianBanGiao', $month->year)
                ->whereMonth('ThoiGianBanGiao', $month->month)
                ->sum('TongTien');
        }

        $costData = [
            'thisMonth' => [
                'labels' => $labels_this_month,
                'nhapKho' => $cost_nhapkho_this_month,
                'baoTri' => $cost_baotri_this_month,
                'suaChua' => $cost_suachua_this_month,
            ],
            'lastMonth' => [
                'labels' => $labels_last_month,
                'nhapKho' => $cost_nhapkho_last_month,
                'baoTri' => $cost_baotri_last_month,
                'suaChua' => $cost_suachua_last_month,
            ],
            'sixMonths' => [
                'labels' => $labels_six_months,
                'nhapKho' => $cost_nhapkho_six_month,
                'baoTri' => $cost_baotri_six_month,
                'suaChua' => $cost_suachua_six_month,
            ]
        ];

        return view('vDashboard.dashboard', compact(
            'lichvanhanh',
            'lichbaotri',
            'lichsuachua',
            'yeucausuachua',
            'phieunhap',
            'phieuthanhly',
            'mayHetBaoHanh',
            'maySapHetKhauHao',
            'mayDaHetKhauHao',
            'linhkienCanhBao',
            'ycscData',
            'costData'
        ));
    }
}
