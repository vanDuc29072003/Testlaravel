<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LichBaoTri;
use App\Models\May;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class LichBaoTriController extends Controller
{
    public function index(Request $request)
    {
        $query = LichBaoTri::query();
    
        // Lọc theo năm
        if ($request->filled('nam')) {
            $query->whereYear('NgayBaoTri', $request->input('nam'));
        }
    
        // Lọc theo quý
        if ($request->filled('quy')) {
            $batdau = ($request->input('quy') - 1) * 3 + 1;
            $ketthuc = $batdau + 2;
            $query->whereMonth('NgayBaoTri', '>=', $batdau)
                  ->whereMonth('NgayBaoTri', '<=', $ketthuc);
        }
    
        // Lấy danh sách lịch bảo trì từ cơ sở dữ liệu
        $lichbaotri = $query->with('may')->orderBy('NgayBaoTri', 'asc')->get();
    
        // Nhóm theo tháng (theo Y-m format)
        $lichbaotriGrouped = $lichbaotri->groupBy(function ($item) {return \Carbon\Carbon::parse($item->NgayBaoTri)->format('Y-m'); // Nhóm theo năm-tháng
        });
    
        return view('vLich.lichbaotri', compact('lichbaotriGrouped'));
    }
    
    public function create()
    {

        $machines = May::all(); // Lấy danh sách máy để hiển thị trong form
        return view('vLich.createlichbaotri', compact('machines'));
    }
    public function store(Request $request)
    {
    $validated = $request->validate([
        'MoTa' => 'required|string',
        'NgayBaoTri' => 'required|date',
        'MaMay' => 'required|exists:may,MaMay',
    ]);
    $chuKy = DB::table('may')->where('MaMay', $validated['MaMay'])->value('ChuKyBaoTri');
    $ngayBaoTri = Carbon::parse($validated['NgayBaoTri']);
    
    for ($i = 0; $i < 12; $i++) {
        LichBaoTri::create([
            'MoTa' => $validated['MoTa'],
            'NgayBaoTri' => $ngayBaoTri->format('Y-m-d'),  //
            'MaMay' => $validated['MaMay'],
        ]);

        $ngayBaoTri->addMonths($chuKy); 
    }

    return redirect()->route('lichbaotri')->with('success', 'Tạo lịch bảo trì thành công cho 12 tháng!');
    }
    function destroy($id)
    {
        $lichbaotri = LichBaoTri::findOrFail($id);
        $lichbaotri->delete();
        return redirect()->route('lichbaotri')->with('success', 'Xóa lịch bảo trì thành công!');
    }

}
