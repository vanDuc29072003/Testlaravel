<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BoPhan;

class BoPhanController extends Controller
{
    // Hiển thị danh sách bộ phận
        public function index(Request $request)
    {
        $search = $request->input('search');

        $bophans = BoPhan::withCount([
            'nhanviens as active_nhanvien_count' => function ($query) {
                $query->whereHas('taikhoan'); // Chỉ đếm nhân viên có tài khoản
            }
        ]);

        if ($search) {
            $bophans->where('TenBoPhan', 'like', '%' . $search . '%');
        }

        $bophans = $bophans->get(); // hoặc ->paginate(10)

        return view('vBoPhan.bophan', compact('bophans'));
    }


    // Trả về view tạo mới
    public function create()
    {
        return view('vBoPhan.createBoPhan');
    }

    // Xử lý lưu dữ liệu mới
    public function store(Request $request)
    {
        $request->validate([
            'TenBoPhan' => 'required|string|max:255',
        ]);

        BoPhan::create([
            'TenBoPhan' => $request->TenBoPhan,
        ]);

        return redirect()->route('bophan.index')->with('success', 'Đã thêm bộ phận thành công.');
    }

    // Xóa bộ phận
    public function destroy($id)
    {
        try{
        $bophan = BoPhan::findOrFail($id);
        $bophan->delete();

        return redirect()->route('bophan.index')->with('success', 'Xóa bộ phận thành công.');
    } catch(\Illuminate\Database\QueryException $e){
            return redirect()->route('bophan.index')->with('error', 'Không thể xóa bộ phận này vì đang được sử dụng');
        }
    }
}
