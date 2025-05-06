<?php

namespace App\Http\Controllers;
use App\Events\eventUpdateTable;
use Illuminate\Http\Request;
use App\Models\LoaiMay;
class LoaiMayController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
    
        $loaimays = LoaiMay::withCount('mays');
    
        if ($search) {
            $loaimays->where('TenLoai', 'like', '%' . $search . '%');
        }
    
        $loaimays = $loaimays->get(); // hoặc ->paginate(10) nếu muốn phân trang
    
        return view('vMay.loaiMay', compact('loaimays'));
    }
        public function create()
    {
        return view('vMay.createLoaiMay');
    }
    public function store(Request $request)
    {
        $request->validate([
            'TenLoai' => 'required|string|max:255',
            'MoTa' => 'nullable|string|max:1000',
        ]);
    
        LoaiMay::create([
            'TenLoai' => $request->TenLoai,
            'MoTa' => $request->MoTa,
        ]);
    
        return redirect()->route('loaimay.index')->with('success', 'Đã thêm loại máy thành công.');
    }
    public function destroy($id)
    {
        $loaimay = LoaiMay::findOrFail($id);
        $loaimay->delete();
        event(new eventUpdateTable());
        return redirect()->route('loaimay.index')->with('success', 'Xóa loại máy thành công.');
    }
}
