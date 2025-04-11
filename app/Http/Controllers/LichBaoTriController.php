<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LichBaoTri;

class LichBaoTriController extends Controller
{
    public function index(Request $request)
    {
    
        $query = LichBaoTri::query();
        if($request->filled('nam')){
            $query->whereYear('NgayBaoTri', $request->input('nam'));
        }
        if($request->filled('quy')){
            $batdau= ($request->input('quy')-1)*3+1;
            $ketthuc= $batdau+2;
            $query->whereMonth('NgayBaoTri', '>=', $batdau)
                  ->whereMonth('NgayBaoTri', '<=', $ketthuc);
        }
        // Lấy danh sách lịch bảo trì từ cơ sở dữ liệu
        $lichbaotri = $query->with('may')->orderBy('NgayBaoTri', 'asc')->get();
        return view('lichbaotri', compact('lichbaotri'));
    }

}
