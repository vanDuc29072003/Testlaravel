<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NhaCungCap;

class NhaCungCapController extends Controller
{

    public function NhaCungCap(Request $request)
    {
        $query = NhaCungCap::query();

        $filters = [
            'MaNhaCungCap' => '=',
            'TenNhaCungCap' => 'like',
            'SDT' => 'like',
            'MaSoThue' => 'like',
            'Email' => 'like',
        ];

        foreach ($filters as $field => $operator) {
            if ($request->filled($field)) {
                $value = $operator === 'like' ? '%' . $request->$field . '%' : $request->$field;
                $query->where($field, $operator, $value);
            }
        }

        $dsNhaCungCap = $query->paginate(10);

        return view('vNCC.nhacungcap', compact('dsNhaCungCap'));
    }


    public function detailNhaCungCap($MaNhaCungCap)
    {
        $nhaCungCap = NhaCungCap::findOrFail($MaNhaCungCap);
        return view('vNCC.detailnhacungcap', compact('nhaCungCap'));
    }

    public function form_editNhaCungCap($MaNhaCungCap)
    {
        $nhaCungCap = NhaCungCap::findOrFail($MaNhaCungCap);
        return view('vNCC.editnhacungcap', compact('nhaCungCap'));
    }

    public function editNhaCungCap(Request $request, $MaNhaCungCap)
    {
        try {
            $request->validate([
                'TenNhaCungCap' => 'required|string|max:255|unique:nhacungcap,TenNhaCungCap,' . $MaNhaCungCap . ',MaNhaCungCap',
                'DiaChi' => 'required|string|max:255|unique:nhacungcap,DiaChi,' . $MaNhaCungCap . ',MaNhaCungCap',
                'SDT' => 'required|numeric|digits_between:10,12|unique:nhacungcap,SDT,' . $MaNhaCungCap . ',MaNhaCungCap',
                'Email' => 'required|email|max:255|unique:nhacungcap,Email,' . $MaNhaCungCap . ',MaNhaCungCap',
                'MaSoThue' => 'required|numeric|digits_between:10,15|unique:nhacungcap,MaSoThue,' . $MaNhaCungCap . ',MaNhaCungCap',
            ], [
                'TenNhaCungCap.unique' => 'Tên nhà cung cấp đã tồn tại trong hệ thống.',
                'SDT.digits_between' => 'Số điện thoại phải có độ dài từ 10 đến 12 chữ số.',
                'SDT.unique' => 'Số điện thoại này đã tồn tại trong hệ thống.',
                'DiaChi.unique' => 'Địa chỉ này đã tồn tại ở công ty khác.',
                'Email.email' => 'Email phải là một địa chỉ email hợp lệ.',
                'Email.unique' => 'Email đã tồn tại trong hệ thống.',
                'MaSoThue.digits_between' => 'Mã số thuế phải có độ dài từ 10 đến 15 chữ số.',
                'MaSoThue.unique' => 'Mã số thuế đã tồn tại trong hệ thống.',
            ]);

            $nhaCungCap = NhaCungCap::findOrFail($MaNhaCungCap);
            $nhaCungCap->update([
                'TenNhaCungCap' => $request->TenNhaCungCap,
                'DiaChi' => $request->DiaChi,
                'SDT' => $request->SDT,
                'Email' => $request->Email,
                'MaSoThue' => $request->MaSoThue,
            ]);

            return redirect()->route('nhacungcap.detail', ['MaNhaCungCap' => $MaNhaCungCap])->with('success', 'Cập nhật nhà cung cấp thành công!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withInput()->with('error', $e->validator->errors()->first());
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Cập nhật thông tin không thành công, vui lòng kiểm tra lại.');
        }
    }

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
                'TenNhaCungCap.unique' => 'Tên nhà cung cấp đã tồn tại trong hệ thống.',
                'SDT.digits_between' => 'Số điện thoại phải có độ dài từ 10 đến 12 chữ số.',
                'DiaChi.unique' => 'Địa chỉ này đã tồn tại ở công ty khác.',
                'Email.email' => 'Email phải là một địa chỉ email hợp lệ.',
                'Email.unique' => 'Email đã tồn tại trong hệ thống.',
                'MaSoThue.digits_between' => 'Mã số thuế phải có độ dài từ 10 đến 15 chữ số.',
                'MaSoThue.unique' => 'Mã số thuế đã tồn tại trong hệ thống.',
            ]);
            
            NhaCungCap::create([
                'TenNhaCungCap' => $request->TenNhaCungCap,
                'DiaChi' => $request->DiaChi,
                'SDT' => $request->SDT,
                'Email' => $request->Email,
                'MaSoThue' => $request->MaSoThue,
            ]);

            return redirect()->route('may.add')->with('success', 'Thêm nhà cung cấp thành công!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->with('error', $e->validator->errors()->first())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Thêm nhà cung cấp không thành công, vui lý kiểm tra lại.')->withInput();
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
                'TenNhaCungCap.unique' => 'Tên nhà cung cấp đã tồn tại trong hệ thống.',
                'SDT.digits_between' => 'Số điện thoại phải có độ dài từ 10 đến 12 chữ số.',
                'DiaChi.unique' => 'Địa chỉ này đã tồn tại ở công ty khác.',
                'Email.email' => 'Email phải là một địa chỉ email hợp lệ.',
                'Email.unique' => 'Email đã tồn tại trong hệ thống.',
                'MaSoThue.digits_between' => 'Mã số thuế phải có độ dài từ 10 đến 15 chữ số.',
                'MaSoThue.unique' => 'Mã số thuế đã tồn tại trong hệ thống.',
            ]);

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
                ->with('error', $e->validator->errors()->first())
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Thêm nhà cung cấp không thành công, vui lý kiểm tra lại.')->withInput();
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
                'TenNhaCungCap.unique' => 'Tên nhà cung cấp đã tồn tại trong hệ thống.',
                'SDT.digits_between' => 'Số điện thoại phải có độ dài từ 10 đến 12 chữ số.',
                'DiaChi.unique' => 'Địa chỉ này đã tồn tại ở công ty khác.',
                'Email.email' => 'Email phải là một địa chỉ email hợp lệ.',
                'Email.unique' => 'Email đã tồn tại trong hệ thống.',
                'MaSoThue.digits_between' => 'Mã số thuế phải có độ dài từ 10 đến 15 chữ số.',
                'MaSoThue.unique' => 'Mã số thuế đã tồn tại trong hệ thống.',
            ]);

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
                ->with('error', $e->validator->errors()->first())
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Thêm nhà cung cấp không thành công, vui lý kiểm tra lại.')->withInput();
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
                'TenNhaCungCap.unique' => 'Tên nhà cung cấp đã tồn tại trong hệ thống.',
                'SDT.digits_between' => 'Số điện thoại phải có độ dài từ 10 đến 12 chữ số.',
                'DiaChi.unique' => 'Địa chỉ này đã tồn tại ở công ty khác.',
                'Email.email' => 'Email phải là một địa chỉ email hợp lệ.',
                'Email.unique' => 'Email đã tồn tại trong hệ thống.',
                'MaSoThue.digits_between' => 'Mã số thuế phải có độ dài từ 10 đến 15 chữ số.',
                'MaSoThue.unique' => 'Mã số thuế đã tồn tại trong hệ thống.',
            ]);

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
                ->with('error', $e->validator->errors()->first())
                ->withInput();
        }
    }

    public function deleteNhaCungCap($MaNhaCungCap)
    {
        try {
            $nhaCungCap = NhaCungCap::findOrFail($MaNhaCungCap);
            $nhaCungCap->delete();
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
                'TenNhaCungCap.unique' => 'Tên nhà cung cấp đã tồn tại trong hệ thống.',
                'SDT.digits_between' => 'Số điện thoại phải có độ dài từ 10 đến 12 chữ số.',
                'DiaChi.unique' => 'Địa chỉ này đã tồn tại ở công ty khác.',
                'Email.email' => 'Email phải là một địa chỉ email hợp lệ.',
                'Email.unique' => 'Email đã tồn tại trong hệ thống.',
                'MaSoThue.digits_between' => 'Mã số thuế phải có độ dài từ 10 đến 15 chữ số.',
                'MaSoThue.unique' => 'Mã số thuế đã tồn tại trong hệ thống.',
            ]);

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
                ->with('error', $e->validator->errors()->first())
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Thêm nhà cung cấp không thành công, vui lòng kiểm tra lại.');
        }
    }
}