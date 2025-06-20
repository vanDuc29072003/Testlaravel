<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DonViTinh;

class DonViTinhController extends Controller
{
    public function index(Request $request)
    {
        $query = DonViTinh::query()->withSum('linhKiens', 'SoLuong');

        $filters = [
            'TenDonViTinh' => 'like',
        ];

        foreach ($filters as $field => $operator) {
            if ($request->filled($field)) {
                $value = $operator === 'like' ? '%' . $request->$field . '%' : $request->$field;
                $query->where($field, $operator, $value);
            }
        }

        $dsDonvitinh = $query->paginate(10);

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
        try {
            $request->validate([
                'TenDonViTinh' => 'required|string|max:255|unique:donvitinh,TenDonViTinh',
            ], [
                'TenDonViTinh.unique' => 'Tên đơn vị tính đã tồn tại trong hệ thống.',
            ]);

            DonViTinh::create([
                'TenDonViTinh' => $request->TenDonViTinh,
            ]);

            return redirect()->route('donvitinh.index')->with('success', 'Đã thêm đơn vị tính thành công.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withInput()->with('error', $e->validator->errors()->first());
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Thêm mới đơn vị tính không tính công, vui lòng kiểm tra lại.');
        }
    }

    // Xóa bộ phận
    public function destroy($id)
    {
        try {
            $dsDonvitinh = DonViTinh::findOrFail($id);
            $dsDonvitinh->delete();

            return redirect()->back()->with('success', 'Xóa đơn vị tính thành công.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('error', 'Không thể xóa đơn vị tính này vì nó đang được sử dụng.');
        }
    }

    public function createDVTfromLinhKien()
    {
        return view('vDonViTinh.createDVTfromLinhKien');
    }
    public function storeDVTfromLinhKien(Request $request)
    {
        try {
            $request->validate([
                'TenDonViTinh' => 'required|string|max:255|unique:donvitinh,TenDonViTinh',
            ], [
                'TenDonViTinh.unique' => 'Tên đơn vị tính đã tồn tại trong hệ thống.',
            ]);

            DonViTinh::create([
                'TenDonViTinh' => $request->TenDonViTinh,
            ]);

            return redirect()->route('linhkien.add')->with('success', 'Đã thêm đơn vị tính thành công.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withInput()->with('error', $e->validator->errors()->first());
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Thêm mới đơn vị tính không thành công, vui lòng kiểm tra lại.');
        }
    }
}
