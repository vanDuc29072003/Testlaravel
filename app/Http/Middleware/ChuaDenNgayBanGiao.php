<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\LichBaoTri;

class ChuaDenNgayBanGiao
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        $nhanVien = $user->nhanVien;

        $maLichBaoTri = $request->route('MaLichBaoTri');
        $lichBaoTri = LichBaoTri::find($maLichBaoTri);

        if (!$lichBaoTri || !$nhanVien) {
            return abort(403, 'Không tìm thấy lịch bảo trì hoặc thông tin nhân viên.');
        }

        $maBoPhan = $nhanVien->MaBoPhan;

        if ($maBoPhan == '1') {
            
            // Kiểm tra ngày hiện tại với NgayBaoTri
            $today = Carbon::today();
            $ngayBaoTri = Carbon::parse($lichBaoTri->NgayBaoTri);

            if ($today->lt($ngayBaoTri)) {
                // Nếu chưa đến ngày bàn giao
                Session::flash('error', 'Chưa đến ngày bàn giao lịch bảo trì.');
                return redirect()->back();
            }

            return $next($request);
        }

        Session::flash('error', 'Bạn không có quyền thực hiện tác vụ này.');
        return redirect()->back();
    }
}
