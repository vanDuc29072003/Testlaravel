<?php

namespace App\Providers;

use App\Models\PhieuNhap;
use App\Models\PhieuThanhLy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\YeuCauSuaChua;
use App\Models\LichSuaChua;
use App\Models\LichBaoTri;
use App\Models\ThongBao;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $header_TenNhanVien = Auth::user()->nhanvien->TenNhanVien ?? 'Chưa xác định';
                $header_TenBoPhan = Auth::user()->nhanvien->bophan->TenBoPhan ?? 'Chưa xác định';
    
                $count_ycsc = YeuCauSuaChua::where('TrangThai', '0')->count();
                $count_lichsc = LichSuaChua::where('TrangThai', '0')->count();
                $count_lichbt = LichBaoTri::where('trangthai', '0')
                    ->whereBetween('NgayBaoTri', [now()->format('Y-m-d'), now()->addDays(7)->format('Y-m-d')])
                    ->count();
                $count_phieunhap = PhieuNhap::where('TrangThai', '0')->count();
                $count_phieuthanhly = PhieuThanhLy::where('TrangThai', '0')->count();

                $dsThongBao = ThongBao::orderBy('created_at', 'desc')->take(10)->get(); // Lấy 10 thông báo mới nhất
                $chuadocCount = ThongBao::where('TrangThai', '=','0')->count(); // Đếm thông báo chưa đọc
    
                $view->with('header_TenNhanVien', $header_TenNhanVien)
                     ->with('header_TenBoPhan', $header_TenBoPhan)
                     ->with('count_ycsc', $count_ycsc)
                     ->with('count_lichsc', $count_lichsc)
                     ->with('count_lichbt', $count_lichbt)
                     ->with('count_phieunhap', $count_phieunhap)
                     ->with('count_phieuthanhly', $count_phieuthanhly)
                     ->with('dsThongBao', $dsThongBao)
                     ->with('chuadocCount', $chuadocCount);
            }
        });
    }
}
