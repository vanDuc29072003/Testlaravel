<?php

namespace App\Http\Controllers;

use App\Models\LichSuaChua;
use Illuminate\Http\Request;
use App\Models\LichSuaChua;
use App\Models\YeuCauSuaChua;
use App\Models\NhanVien;

class LichSuaChuaController extends Controller
{
<<<<<<< HEAD
    public function index(Request $request) {
        $query = LichSuaChua::query();
    
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

        $dsLichSuaChua = $query->orderByDesc('MaLichSuaChua')->paginate(10);
        $dsNhanVien = NhanVien::all();
    
        return view('vLichSuaChua.lichsuachua', compact('dsLichSuaChua', 'dsNhanVien'));
=======
    public function index()
    {
        $lichsuachua = LichSuaChua::with(
            [
            'yeucau.nhanvienyeucau',
            'yeucau.may',
            'nhanvienkithuat'
            ]
        )->get();
            
        return view('lichsuachua', compact('lichsuachua'));
>>>>>>> 5096e39f7c9cc50257838bee1acdd0e531f451e1
    }
}
