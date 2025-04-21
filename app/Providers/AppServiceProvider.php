<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\YeuCauSuaChua;
use App\Models\LichSuaChua;
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
    
                $count_ycsc = YeuCauSuaChua::where('TrangThai', '=', '0')->count();
                $count_lichsc = LichSuaChua::where('TrangThai', '=', '0')->count();
    
                $view->with('header_TenNhanVien', $header_TenNhanVien)
                     ->with('header_TenBoPhan', $header_TenBoPhan)
                     ->with('count_ycsc', $count_ycsc)
                     ->with('count_lichsc', $count_lichsc);
            } else {
                // Gán mặc định để tránh lỗi khi chưa đăng nhập
                $view->with('header_TenNhanVien', '')
                     ->with('header_TenBoPhan', '')
                     ->with('count_ycsc', 0)
                     ->with('count_lichsc', 0);
            }
        });
    }
}
