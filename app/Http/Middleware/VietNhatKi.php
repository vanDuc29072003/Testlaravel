<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\LichVanHanh;



class VietNhatKi
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        $nhanVien = $user?->nhanVien;

        if (!$nhanVien) {
            return abort(403, 'Không có thông tin nhân viên.');
        }
        $maLichVanHanh = $request->route('id') ?? $request->query('ma_lich');
        
        if (!$maLichVanHanh) {
            return $next($request); 
        }

        // Có mã lịch thì kiểm tra quyền
        $lichVanHanh = LichVanHanh::find($maLichVanHanh);
        if (!$lichVanHanh) {
            return abort(403, 'Không tìm thấy lịch vận hành.');
        }
        $maBoPhan = $nhanVien->MaBoPhan;

        if ($maBoPhan == '1') {
            return $next($request);
        }

        if ($maBoPhan == '2' && $nhanVien->MaNhanVien == $lichVanHanh->MaNhanVien) {
            return $next($request);
        }

        session()->flash('error', 'Bạn không có quyền thực hiện thao tác này trên lịch vận hành.');
        return redirect()->back();
    }
}
