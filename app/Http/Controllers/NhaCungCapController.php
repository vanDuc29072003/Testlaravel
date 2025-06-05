<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NhaCungCap;

class NhaCungCapController extends Controller
{

    // Hiển thị danh sách nhà cung cấp

    public function NhaCungCap(Request $request)
    {
        $query = NhaCungCap::query();

        // Danh sách các trường cần lọc
        $filters = [
            'MaNhaCungCap' => 'like',
            'TenNhaCungCap' => 'like',
            'SDT' => 'like',
            'MaSoThue' => 'like',

        ];

        // Áp dụng các điều kiện lọc
        foreach ($filters as $field => $operator) {
            if ($request->filled($field)) {
                $value = $operator === 'like' ? '%' . $request->$field . '%' : $request->$field;
                $query->where($field, $operator, $value);
            }
        }

        // Lấy danh sách máy với phân trang (mặc định 10 bản ghi mỗi trang)
        $dsNhaCungCap = $query->paginate(10);

        return view('vNCC.nhacungcap', compact('dsNhaCungCap'));
    }


    public function detailNhaCungCap($MaNhaCungCap)
    {
        $nhaCungCap = NhaCungCap::findOrFail($MaNhaCungCap); // Tìm nhà cung cấp theo ID
        return view('vNCC.detailnhacungcap', compact('nhaCungCap'));
    }
    // Hiển thị form chỉnh sửa nhà cung cấp
    public function form_editNhaCungCap($MaNhaCungCap)
    {
        $nhaCungCap = NhaCungCap::findOrFail($MaNhaCungCap); // Tìm nhà cung cấp theo ID
        return view('vNCC.editnhacungcap', compact('nhaCungCap'));
    }

    // Xử lý chỉnh sửa nhà cung cấp
    public function editNhaCungCap(Request $request, $MaNhaCungCap)
    {
        $nhaCungCap = NhaCungCap::findOrFail($MaNhaCungCap); // Tìm nhà cung cấp theo ID
        $nhaCungCap->update($request->all()); // Cập nhật thông tin nhà cung cấp
        return redirect()->route('nhacungcap.detail', ['MaNhaCungCap' => $MaNhaCungCap])->with('success', 'Cập nhật nhà cung cấp thành công!');
    }

    // Hiển thị form thêm nhà cung cấp
    public function addNhaCungCap()
    {
        return view('vNCC.addnhacungcap');
    }
    public function addNhaCungCap2()
    {
        return view('vNCC.addnhacungcap2');
    }
    public function createNCCfromMay()
    {
        return view('vNCC.addNCCfromMay');
    }
      public function createNCCfromPN()
    {
        return view('vNCC.addNCCfromPN');
    }
    // Xử lý thêm nhà cung cấp
    public function storeNCCfromMay(Request $request)
    {
        try {
            $request->validate([
                'TenNhaCungCap' => 'required|string|max:255|unique:nhacungcap,TenNhaCungCap',
                'DiaChi' => 'required|string|max:255|unique:nhacungcap,DiaChi',
                'SDT' => 'required|numeric|digits_between:10,12|unique:nhacungcap,SDT',
                'Email' => 'required|email|max:255|unique:nhacungcap,Email',
                'MaSoThue' => 'required|numeric|digits_between:10,15|unique:nhacungcap,MaSoThue',
            ], [

                'TenNhaCungCap.unique' => 'Nhà cung cấp đã tồn tại.',
                'SDT.digits_between' => 'Số Điện Thoại phải có độ dài từ 10 đến 12 chữ số.',
                'DiaChi.unique' => 'Địa chỉ này đã tồn tại ở công ty khác.',
                'Email.email' => 'Email phải là một địa chỉ email hợp lệ.',
                'Email.unique' => 'Email đã tồn tại.',

                'MaSoThue.numeric' => 'Mã Số Thuế phải là số.',
                'MaSoThue.digits_between' => 'Mã Số Thuế phải có độ dài từ 10 đến 15 chữ số.',
                'MaSoThue.unique' => 'Mã Số Thuế đã tồn tại.',
            ]);
            // Tạo mới nhà cung cấp
            NhaCungCap::create([
                'TenNhaCungCap' => $request->TenNhaCungCap,
                'DiaChi' => $request->DiaChi,
                'SDT' => $request->SDT,
                'Email' => $request->Email,
                'MaSoThue' => $request->MaSoThue,
            ]);

            return redirect()->route('may.add')->with('success', 'Thêm nhà cung cấp thành công!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->with('error', $e->validator->errors()->first()) // Lấy lỗi đầu tiên     
                ->withInput();
        }
    }
     public function storeNCCfromPN(Request $request)
    {
        try {
            $request->validate([
                'TenNhaCungCap' => 'required|string|max:255|unique:nhacungcap,TenNhaCungCap',
                'DiaChi' => 'required|string|max:255|unique:nhacungcap,DiaChi',
                'SDT' => 'required|numeric|digits_between:10,12|unique:nhacungcap,SDT',
                'Email' => 'required|email|max:255|unique:nhacungcap,Email',
                'MaSoThue' => 'required|numeric|digits_between:10,15|unique:nhacungcap,MaSoThue',
            ], [

                'TenNhaCungCap.unique' => 'Nhà cung cấp đã tồn tại.',
                'SDT.digits_between' => 'Số Điện Thoại phải có độ dài từ 10 đến 12 chữ số.',
                'DiaChi.unique' => 'Địa chỉ này đã tồn tại ở công ty khác.',
                'Email.email' => 'Email phải là một địa chỉ email hợp lệ.',
                'Email.unique' => 'Email đã tồn tại.',

                'MaSoThue.numeric' => 'Mã Số Thuế phải là số.',
                'MaSoThue.digits_between' => 'Mã Số Thuế phải có độ dài từ 10 đến 15 chữ số.',
                'MaSoThue.unique' => 'Mã Số Thuế đã tồn tại.',
            ]);
            // Tạo mới nhà cung cấp
            NhaCungCap::create([
                'TenNhaCungCap' => $request->TenNhaCungCap,
                'DiaChi' => $request->DiaChi,
                'SDT' => $request->SDT,
                'Email' => $request->Email,
                'MaSoThue' => $request->MaSoThue,
            ]);

            return redirect()->route('dsphieunhap.add')->with('success', 'Thêm nhà cung cấp thành công,hãy tiếp tục tạo phiếu');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->with('error', $e->validator->errors()->first()) // Lấy lỗi đầu tiên     
                ->withInput();
        }
    }
    public function storeNhaCungCap(Request $request)
    {
        try {
            $request->validate([
                'TenNhaCungCap' => 'required|string|max:255|unique:nhacungcap,TenNhaCungCap',
                'DiaChi' => 'required|string|max:255|unique:nhacungcap,DiaChi',
                'SDT' => 'required|numeric|digits_between:10,12|unique:nhacungcap,SDT',
                'Email' => 'required|email|max:255|unique:nhacungcap,Email',
                'MaSoThue' => 'required|numeric|digits_between:10,15|unique:nhacungcap,MaSoThue',
            ], [

                'TenNhaCungCap.unique' => 'Nhà cung cấp đã tồn tại.',
                'SDT.digits_between' => 'Số Điện Thoại phải có độ dài từ 10 đến 12 chữ số.',
                'DiaChi.unique' => 'Địa chỉ này đã tồn tại ở công ty khác.',
                'Email.email' => 'Email phải là một địa chỉ email hợp lệ.',
                'Email.unique' => 'Email đã tồn tại.',

                'MaSoThue.numeric' => 'Mã Số Thuế phải là số.',
                'MaSoThue.digits_between' => 'Mã Số Thuế phải có độ dài từ 10 đến 15 chữ số.',
                'MaSoThue.unique' => 'Mã Số Thuế đã tồn tại.',
            ]);
            // Tạo mới nhà cung cấp
            NhaCungCap::create([
                'TenNhaCungCap' => $request->TenNhaCungCap,
                'DiaChi' => $request->DiaChi,
                'SDT' => $request->SDT,
                'Email' => $request->Email,
                'MaSoThue' => $request->MaSoThue,
            ]);

            return redirect()->route('nhacungcap')->with('success', 'Thêm nhà cung cấp thành công!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->with('error', $e->validator->errors()->first()) // Lấy lỗi đầu tiên     
                ->withInput();
        }
    }
    public function storeNhaCungCap2(Request $request)
    {
        try {
            $request->validate([
                'TenNhaCungCap' => 'required|string|max:255|unique:nhacungcap,TenNhaCungCap',
                'DiaChi' => 'required|string|max:255|unique:nhacungcap,DiaChi',
                'SDT' => 'required|numeric|digits_between:10,12|unique:nhacungcap,SDT',
                'Email' => 'required|email|max:255|unique:nhacungcap,Email',
                'MaSoThue' => 'required|numeric|digits_between:10,15|unique:nhacungcap,MaSoThue',
            ], [

                'TenNhaCungCap.unique' => 'Nhà cung cấp đã tồn tại.',
                'SDT.unique' => 'Số Điện Thoại đã tồn tại.',
                'SDT.digits_between' => 'Số Điện Thoại phải có độ dài từ 10 đến 12 chữ số.',
                'DiaChi.unique' => 'Địa chỉ này đã tồn tại ở công ty khác.',
                'Email.email' => 'Email phải là một địa chỉ email hợp lệ.',
                'Email.unique' => 'Email đã tồn tại.',

                'MaSoThue.numeric' => 'Mã Số Thuế phải là số.',
                'MaSoThue.digits_between' => 'Mã Số Thuế phải có độ dài từ 10 đến 15 chữ số.',
                'MaSoThue.unique' => 'Mã Số Thuế đã tồn tại.',
            ]);
            // Tạo mới nhà cung cấp
            NhaCungCap::create([
                'TenNhaCungCap' => $request->TenNhaCungCap,
                'DiaChi' => $request->DiaChi,
                'SDT' => $request->SDT,
                'Email' => $request->Email,
                'MaSoThue' => $request->MaSoThue,
            ]);
            $maLinhKien = session('editing_linhkien_id');
            $formData = session('formData');
            if ($maLinhKien) {
                return redirect()->route('linhkien.edit', $maLinhKien)
                    ->with('success', 'Đã thêm nhà cung cấp thành công!')
                    ->with('formData', $formData);
            } else {

                return redirect()->route('nhacungcap')->with('success', 'Thêm nhà cung cấp thành công!');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->with('error', $e->validator->errors()->first()) // Lấy lỗi đầu tiên     
                ->withInput();
        }
    }
    // Xóa nhà cung cấp
    public function deleteNhaCungCap($MaNhaCungCap)
    {
        try{
        $nhaCungCap = NhaCungCap::findOrFail($MaNhaCungCap); // Tìm nhà cung cấp theo ID
        $nhaCungCap->delete(); // Xóa nhà cung cấp
        return redirect()->back()->with('success', 'Xóa nhà cung cấp thành công!');
    } catch (\Illuminate\Database\QueryException $e) {
            
            return redirect()->back()->with('error', 'Không thể xóa nhà cung cấp vì đang được sử dụng');
        }
    }

    public function createNCCfromLinhKien()
    {
        return view('vNCC.createNCCfromLinhKien');
    }
    public function storeNCCfromLinhKien(Request $request)
    {
                try {
            $request->validate([
                'TenNhaCungCap' => 'required|string|max:255|unique:nhacungcap,TenNhaCungCap',
                'DiaChi' => 'required|string|max:255|unique:nhacungcap,DiaChi',
                'SDT' => 'required|numeric|digits_between:10,12|unique:nhacungcap,SDT',
                'Email' => 'required|email|max:255|unique:nhacungcap,Email',
                'MaSoThue' => 'required|numeric|digits_between:10,15|unique:nhacungcap,MaSoThue',
            ], [

                'TenNhaCungCap.unique' => 'Nhà cung cấp đã tồn tại.',
                'SDT.digits_between' => 'Số Điện Thoại phải có độ dài từ 10 đến 12 chữ số.',
                'DiaChi.unique' => 'Địa chỉ này đã tồn tại ở công ty khác.',
                'Email.email' => 'Email phải là một địa chỉ email hợp lệ.',
                'Email.unique' => 'Email đã tồn tại.',

                'MaSoThue.numeric' => 'Mã Số Thuế phải là số.',
                'MaSoThue.digits_between' => 'Mã Số Thuế phải có độ dài từ 10 đến 15 chữ số.',
                'MaSoThue.unique' => 'Mã Số Thuế đã tồn tại.',
            ]);
            // Tạo mới nhà cung cấp
            NhaCungCap::create([
                'TenNhaCungCap' => $request->TenNhaCungCap,
                'DiaChi' => $request->DiaChi,
                'SDT' => $request->SDT,
                'Email' => $request->Email,
                'MaSoThue' => $request->MaSoThue,
            ]);

            return redirect()->route('linhkien.add')->with('success', 'Thêm nhà cung cấp thành công!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->with('error', $e->validator->errors()->first()) // Lấy lỗi đầu tiên     
                ->withInput();
        }
    }
}