<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\NhanVien;
use App\Models\Bophan;
use Illuminate\Validation\Rule;

class DetailuserController extends Controller
{
    public function detailuser()
    {
        $user = Auth::user();

        // Lấy thông tin nhân viên từ quan hệ
        $nhanvien = $user->nhanvien;

        // Lấy thông tin bộ phận từ quan hệ của nhân viên
        $bophan = Bophan::find($nhanvien->MaBoPhan) ?? null;
        return view('vUser.detailuser', compact('user', 'nhanvien','bophan'));

    }
    public function showInforUser()
    {
        $user = Auth::user();

        $nhanvien = $user->nhanvien;

        $bophan = Bophan::all();
        return view('vUser.edituser', compact('user', 'nhanvien','bophan'));
    }
    public function update(Request $request)
    {
        $user = Auth::user();
        $nhanvien = $user->nhanvien;
        try {
            $request->validate([
            'TenNhanVien' => 'required|string|max:255',
            'Email' => 'required|email|unique:nhanvien,Email,' . $nhanvien->MaNhanVien . ',MaNhanVien',
            'SDT' => 'required|digits:10|unique:nhanvien,SDT,' . $nhanvien->MaNhanVien . ',MaNhanVien',
            'DiaChi' => 'required|string|max:255',
            'NgaySinh' => 'nullable|date',
            'GioiTinh' => 'required|in:Nam,Nữ',
            'MaBoPhan' => 'required|exists:bophan,MaBoPhan',
            'MatKhauChuaMaHoa' => 'required|string|min:6',
            ], [
            'TenNhanVien.required' => 'Tên nhân viên là bắt buộc.',
            'Email.unique' => 'Email đã tồn tại.',
            'SDT.digits' => 'Số điện thoại phải có 10 chữ số.',
            'SDT.unique' => 'Số điện thoại đã tồn tại.',
            'MatKhauChuaMaHoa.required' => 'Mật khẩu là bắt buộc.',
            'MatKhauChuaMaHoa.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            ]
            );

            // Cập nhật thông tin nhân viên
            $nhanvien->TenNhanVien = $request->TenNhanVien;
            $nhanvien->Email = $request->Email;
            $nhanvien->SDT = $request->SDT;
            $nhanvien->DiaChi = $request->DiaChi;
            $nhanvien->NgaySinh = $request->NgaySinh;
            $nhanvien->GioiTinh = $request->GioiTinh;
            $nhanvien->MaBoPhan = $request->MaBoPhan;
            if ($request->has('MatKhauChuaMaHoa') && !empty($request->MatKhauChuaMaHoa)) {
                $user->MatKhauChuaMaHoa = $request->MatKhauChuaMaHoa;
                $user->MatKhau = bcrypt($request->MatKhauChuaMaHoa);
            }
            $nhanvien->save();

            return redirect()->route('detailuser')->with('success', 'Thông tin đã được cập nhật thành công.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withInput()->with('error', 'Đã xảy ra lỗi khi cập nhật thông tin: ' . $e->validator->errors()->first());
        }
    }
}
