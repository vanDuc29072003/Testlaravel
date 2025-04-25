<?php

namespace App\Http\Controllers;

use App\Events\eventUpdateTable;
use App\Models\LichSuaChua;
use Illuminate\Http\Request;
use App\Models\YeuCauSuaChua;
use App\Models\NhanVien;
use App\Models\ThongBao;
use App\Events\eventUpdateUI;
use Carbon\Carbon;

class LichSuaChuaController extends Controller
{

    public function index(Request $request)
    {
        $queryChuaHoanThanh = LichSuaChua::query();
        $dsNhanVien = NhanVien::all();

        // Danh sách các trường cần lọc
        $filters = [
            'MaLichSuaChua' => '=',
            'MaYeuCauSuaChua' => '=',
            'MaNhanVienKyThuat' => '='
        ];
        foreach ($filters as $field => $operator) {
            if ($request->filled($field)) {
                $value = $operator === 'like' ? '%' . $request->$field . '%' : $request->$field;
                $queryChuaHoanThanh->where($field, $operator, $value);
            }
        }

        $dsLSCChuaHoanThanh = $queryChuaHoanThanh->where('TrangThai', '0')
            ->with(['yeuCauSuaChua', 'nhanVienKyThuat'])
            ->orderBy('updated_at', 'desc')
            ->get();

        $dsLSCtheongay = $dsLSCChuaHoanThanh->groupBy(function ($item) {
            return Carbon::parse($item->yeuCauSuaChua->ThoiGianYeuCau)->format('d-m-Y');
        });

        ThongBao::where('Icon', 'fa-solid fa-calendar-days')->update(['TrangThai' => 1]);

        return view('vLichSuaChua.lichsuachua', compact('dsLSCChuaHoanThanh', 'dsNhanVien', 'dsLSCtheongay'));
    }

    public function lichSuDaHoanThanh(Request $request)
    {
        $queryDaHoanThanh = LichSuaChua::query();
        $dsNhanVien = NhanVien::all();

        // Lọc theo các trường nếu cần
        $filters = [
            'MaLichSuaChua' => '=',
            'MaYeuCauSuaChua' => '=',
            'MaNhanVienKyThuat' => '='
        ];
        foreach ($filters as $field => $operator) {
            if ($request->filled($field)) {
                $value = $operator === 'like' ? '%' . $request->$field . '%' : $request->$field;
                $queryDaHoanThanh->where($field, $operator, $value);
            }
        }

        $dsLSCDaHoanThanh = $queryDaHoanThanh->whereIn('TrangThai', ['1', '2'])
            ->with(['yeuCauSuaChua', 'nhanVienKyThuat'])
            ->orderBy('updated_at', 'desc')
            ->paginate(10, ['*'], 'da_hoan_thanh');

            return view('vLichSu.lichsusuachua', compact('dsLSCDaHoanThanh', 'dsNhanVien'));    }
    public function lienhencc($MaLichSuaChua)
    {
        $lichSuaChua = LichSuaChua::findOrFail($MaLichSuaChua);
        $lichSuaChua->TrangThai = '2';
        $lichSuaChua->save();

        event(new eventUpdateTable());
        event(new eventUpdateUI());
        return redirect()->route('lichsuachua.index');
    }
}
