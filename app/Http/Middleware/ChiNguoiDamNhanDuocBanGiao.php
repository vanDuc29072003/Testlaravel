<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\LichSuaChua;

class ChiNguoiDamNhanDuocBanGiao
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        $nhanVien = $user->nhanVien;

        $maLichSuaChua = $request->route('MaLichSuaChua');
        $lichSuaChua = LichSuaChua::find($maLichSuaChua);
        
        if (!$lichSuaChua || !$nhanVien) {
            return abort(403, 'Không tìm thấy lịch sửa chữa hoặc thông tin nhân viên.');
        }

        $maBoPhan = $nhanVien->MaBoPhan;

        if ($maBoPhan == '1') {
            return $next($request);
        }
        if ($maBoPhan == '3' && $nhanVien->MaNhanVien   == $lichSuaChua->MaNhanVienKyThuat){
            return $next($request);
        }
        
        session()->flash('error', 'Bạn không có quyền thực hiện tác vụ này đâu.');
        return redirect()->back();
    }
}