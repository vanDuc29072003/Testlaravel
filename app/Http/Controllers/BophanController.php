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

        $bophans = BoPhan::withCount('nhanviens');


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
        $bophan = BoPhan::findOrFail($id);
        $bophan->delete();

        return redirect()->route('bophan.index')->with('success', 'Xóa bộ phận thành công.');
    }
}
