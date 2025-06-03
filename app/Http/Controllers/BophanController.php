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
        $validated = $request->validate([
            'TenBoPhan' => 'required|string|max:255|unique:bophan,TenBoPhan|regex:/^[\p{L}0-9\s]+$/u',
            'TenRutGon' => 'required|string|min:2|max:50|unique:bophan,TenRutGon|regex:/^[\p{L}0-9\s]+$/u',
        ], [
            'TenBoPhan.required' => 'Tên bộ phận không được để trống.',
            'TenBoPhan.max' => 'Tên bộ phận không được vượt quá 255 ký tự.',
            'TenBoPhan.unique' => 'Tên bộ phận đã tồn tại.',
            'TenBoPhan.regex' => 'Tên bộ phận chỉ được chứa chữ cái, số và khoảng trắng.',

            'TenRutGon.required' => 'Tên rút gọn không được để trống.',
            'TenRutGon.min' => 'Tên rút gọn phải có ít nhất 2 ký tự.',
            'TenRutGon.max' => 'Tên rút gọn không được vượt quá 50 ký tự.',
            'TenRutGon.unique' => 'Tên rút gọn đã tồn tại.',
            'TenRutGon.regex' => 'Tên rút gọn chỉ được chứa chữ cái, số và khoảng trắng.',
        ]);

        try {
            BoPhan::create([
                'TenBoPhan' => $validated['TenBoPhan'],
                'TenRutGon' => $validated['TenRutGon'],
            ]);

            return redirect()->route('bophan.index')->with('success', 'Đã thêm bộ phận thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage())->withInput();
        }
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
