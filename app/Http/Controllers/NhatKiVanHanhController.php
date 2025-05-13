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

    if ($timeFilter === 'today') {
        $query->whereDate('NgayVanHanh', Carbon::today());
    } elseif ($timeFilter === 'yesterday') {
        $query->whereDate('NgayVanHanh', Carbon::yesterday());
    } elseif ($timeFilter === 'last_7_days') {
        $query->whereBetween('NgayVanHanh', [Carbon::now()->subDays(6)->startOfDay(), Carbon::now()->endOfDay()]);
    } elseif ($timeFilter === 'this_month') {
        $query->whereMonth('NgayVanHanh', Carbon::now()->month)
              ->whereYear('NgayVanHanh', Carbon::now()->year);
    } elseif ($timeFilter === 'last_month') {
        $query->whereMonth('NgayVanHanh', Carbon::now()->subMonth()->month)
              ->whereYear('NgayVanHanh', Carbon::now()->subMonth()->year);
    } elseif ($timeFilter === 'this_quarter') {
        $start = Carbon::now()->firstOfQuarter();
        $end = Carbon::now()->lastOfQuarter();
        $query->whereBetween('NgayVanHanh', [$start, $end]);
    } elseif ($timeFilter === 'custom') {
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('NgayVanHanh', [$start, $end]);
        }
    } else {
        // Mặc định: hôm nay
        $query->whereDate('NgayVanHanh', Carbon::today());
    }

    $thongke = $query->orderBy('NgayVanHanh', 'desc')->get();

    // Dữ liệu dropdown nếu bạn cần cho các bộ lọc nâng cao
    $may = DB::table('may')->get();
    $nhanvien = DB::table('nhanvien')->get();

    return view('Vthongke.thongkevanhanh', compact('thongke', 'may', 'nhanvien'));
}

    public function show($id)
    {
        $lich = LichVanHanh::with(['may', 'nhanVien'])->findOrFail($id);

        return view('Vthongke.chitietnhatki', compact('lich'));
    }
}
