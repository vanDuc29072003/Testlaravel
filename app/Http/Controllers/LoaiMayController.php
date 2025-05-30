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
        try {
            $request->validate([
                'TenLoai' => 'required|string|max:255',
                'MoTa' => 'required|string|max:10|unique:loaimay,MoTa',
            ]);

            LoaiMay::create([
                'TenLoai' => $request->TenLoai,
                'MoTa' => $request->MoTa,
            ]);

            return redirect()->route('loaimay.index')->with('success', 'Đã thêm loại máy thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Tên viết tắt đã được sử dụng hoặc dữ liệu không hợp lệ');
        }
    }
    public function destroy($id)
    {
        try {
            $loaimay = LoaiMay::findOrFail($id);
            $loaimay->delete();
            event(new eventUpdateTable());
            return redirect()->route('loaimay.index')->with('success', 'Xóa loại máy thành công.');
        } catch (\Illuminate\Database\QueryException $e) {
            
            return redirect()->route('loaimay.index')->with('error', 'Không thể xóa loại máy vì đang được sử dụng.');
        }
    }

    public function createLoaiMayfromMay()
    {
        return view('vMay.createLoaiMayfromMay');
    }
    public function storeLoaiMayfromMay(Request $request)
    {
        try {
            $request->validate([
                'TenLoai' => 'required|string|max:255',
                'MoTa' => 'required|string|max:10|unique:loaimay,MoTa',
            ]);
            LoaiMay::create([
                'TenLoai' => $request->TenLoai,
                'MoTa' => $request->MoTa,
            ]);
            // Không xóa session ở đây
            return redirect()->route('may.add')->with('success', 'Thêm loại máy thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Tên viết tắt đã được sử dụng hoặc dữ liệu không hợp lệ');
        }
    }
}
