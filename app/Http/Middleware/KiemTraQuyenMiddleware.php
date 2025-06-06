<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use App\Models\PhanQuyen;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KiemTraQuyenMiddleware
{
    public function handle($request, Closure $next, $requiredMaPhanQuyen)
    {
        $user = Auth::user();
        $nhanVien = $user->nhanVien;

        if (!$user || !$nhanVien || !$nhanVien->MaBoPhan) {
            return abort(403, 'Bạn không có quyền thực hiện tác vụ này.');
        }

        $maPhanQuyens = PhanQuyen::whereHas('boPhans', function ($query) use ($nhanVien) {
            $query->where('bophan.MaBoPhan', $nhanVien->MaBoPhan);
        })->pluck('MaPhanQuyen')->toArray();

        if (!in_array((int) $requiredMaPhanQuyen, $maPhanQuyens)) {
            session()->flash('error', 'Bạn không có quyền thực hiện tác vụ này.');
            return redirect()->back();
        }

        return $next($request);
    }



}
