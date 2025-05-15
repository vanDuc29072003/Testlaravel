<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LichVanHanh;
use App\Models\May;
use App\Models\NhanVien;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class NhatKiVanHanhController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('lichvanhanh')
            ->join('may', 'lichvanhanh.MaMay', '=', 'may.MaMay')
            ->join('nhanvien', 'lichvanhanh.MaNhanVien', '=', 'nhanvien.MaNhanVien')
            ->select(
                'lichvanhanh.MaLichVanHanh',
                'lichvanhanh.NgayVanHanh',
                'lichvanhanh.updated_at',
                'may.TenMay',
                'nhanvien.TenNhanVien',
                'lichvanhanh.CaLamViec',
                'lichvanhanh.trangthai'
            )
            ->whereNotNull('lichvanhanh.NhatKi');

        // Xử lý lọc theo thời gian
        $timeFilter = $request->input('time_filter');
        $timeDescription = ''; // Chuỗi mô tả để truyền ra view

        if ($timeFilter === 'today') {
           $startDate = Carbon::today()->startOfDay();  // 00:00
            $endDate = Carbon::today()->endOfDay();  // 23:59
            $query->whereDate('NgayVanHanh', $startDate, $endDate);
            $timeDescription = 'Hôm nay';
        } elseif ($timeFilter === 'yesterday') {
            $startDate = $endDate = Carbon::yesterday();
            $endDate = Carbon::yesterday()->endOfDay();
            $query->whereDate('NgayVanHanh', $startDate, $endDate);
            $timeDescription = 'Hôm qua';
        } elseif ($timeFilter === 'last_7_days') {
            $startDate = Carbon::now()->subDays(6)->startOfDay();
            $endDate = Carbon::now()->endOfDay();
            $query->whereBetween('NgayVanHanh', [$startDate, $endDate]);
            $timeDescription = '7 ngày gần nhất';
        } elseif ($timeFilter === 'this_month') {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
            $query->whereBetween('NgayVanHanh', [$startDate, $endDate]);
            $timeDescription = 'Tháng này';
        } elseif ($timeFilter === 'last_month') {
            $startDate = Carbon::now()->subMonth()->startOfMonth();
            $endDate = Carbon::now()->subMonth()->endOfMonth();
            $query->whereBetween('NgayVanHanh', [$startDate, $endDate]);
            $timeDescription = 'Tháng trước';
        } elseif ($timeFilter === 'this_quarter') {
            $startDate = Carbon::now()->firstOfQuarter();
            $endDate = Carbon::now()->lastOfQuarter();
            $query->whereBetween('NgayVanHanh', [$startDate, $endDate]);
            $timeDescription = 'Quý này';
        } elseif ($timeFilter === 'custom') {
            if ($request->filled('start_date') && $request->filled('end_date')) {
                $startDate = Carbon::parse($request->start_date)->startOfDay();
                $endDate = Carbon::parse($request->end_date)->endOfDay();
                $query->whereBetween('NgayVanHanh', [$startDate, $endDate]);
                $timeDescription = 'Tùy chỉnh';
            }
        } else {
            $startDate = $endDate = Carbon::today();
            $query->whereDate('NgayVanHanh', $startDate);
            $timeDescription = 'Hôm nay';
        }

        $thongke = $query->orderBy('NgayVanHanh', 'desc')->get();

        // Dữ liệu dropdown nếu bạn cần cho các bộ lọc nâng cao
        $may = DB::table('may')->get();
        $nhanvien = DB::table('nhanvien')->get();

      return view('Vthongke.thongkevanhanh', compact('thongke', 'may', 'nhanvien', 'startDate', 'endDate', 'timeDescription'));

    }

    public function show($id)
    {
        $lich = LichVanHanh::with(['may', 'nhanVien'])->findOrFail($id);

        return view('Vthongke.chitietnhatki', compact('lich'));
    }
}
