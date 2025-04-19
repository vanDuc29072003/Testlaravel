<?php

namespace App\Http\Controllers;

use App\Models\LichSuaChua;
use Illuminate\Http\Request;
use App\Models\YeuCauSuaChua;
use App\Models\NhanVien;

class LichSuaChuaController extends Controller
{
    public function index(Request $request) {
        $queryChuaHoanThanh = LichSuaChua::query();
        $queryDaHoanThanh = LichSuaChua::query();
        $query = LichSuaChua::query();
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
                $query->where($field, $operator, $value);
            }
        }

        $dsLSCChuaHoanThanh = $queryChuaHoanThanh->where('TrangThai', '0')
                                                ->with(['yeuCauSuaChua', 'nhanVienKyThuat'])
                                                ->paginate(10);

        $dsLSCDaHoanThanh = $queryDaHoanThanh->where('TrangThai', '1')
                                            ->with(['yeuCauSuaChua', 'nhanVienKyThuat'])
                                            ->paginate(10);
        return view('vLichSuaChua.lichsuachua', compact('dsLSCChuaHoanThanh', 'dsLSCDaHoanThanh', 'dsNhanVien'));
    }
}
