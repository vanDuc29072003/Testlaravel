<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DonViTinh;

class DonViTinhController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = DonViTinh::withCount('linhKiens');


        if ($search) {
            $query->where('TenDonViTinh', 'like', '%' . $search . '%');
        }

        $dsDonvitinh = $query->get(); // hoặc ->paginate(10)

        return view('vDonViTinh.donvitinh', compact('dsDonvitinh'));
    }

    // Trả về view tạo mới
    public function create()
    {
        return view('vDonViTinh.createdonvitinh');
    }

    // Xử lý lưu dữ liệu mới
    public function store(Request $request)
    {
        $request->validate([
            'TenDonViTinh' => 'required|string|max:255|unique:donvitinh,TenDonViTinh',
        ]);

        DonViTinh::create([
            'TenDonViTinh' => $request->TenDonViTinh,
        ]);

        return redirect()->route('donvitinh.index')->with('success', 'Đã thêm đơn vị tính thành công.');
    }

    // Xóa bộ phận
    public function destroy($id)
    {
        $dsDonvitinh = DonViTinh::findOrFail($id);
        $dsDonvitinh->delete();

        return redirect()->route('donvitinh.index')->with('success', 'Xóa đơn vị tính thành công.');
    }
}
