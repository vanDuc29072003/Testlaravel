<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'TenTaiKhoan' => 'required',
            'MatKhau' => 'required'
        ]);
    
        if (Auth::attempt(['TenTaiKhoan' => $credentials['TenTaiKhoan'], 'password' => $credentials['MatKhau']])) {
            $request->session()->regenerate();
    
            $user = Auth::user();
    
            // Lấy MaBoPhan từ quan hệ với bảng nhanvien
            $maBoPhan = $user->nhanVien->MaBoPhan ?? null;
    
            // Chuyển hướng dựa theo mã bộ phận
            switch ($maBoPhan) {
                case 1:
                    return redirect()->route('thongkesuachua')->with('success', 'Chào mừng quay trở lại!');

                case 2:
                    return redirect()->route('lichvanhanh')->with('success', 'Chào mừng quay trở lại!');
                case 3:
                    return redirect()->route('lichsuachua.index')->with('success', 'Chào mừng quay trở lại!');
                    case 4:
                    return redirect()->route('linhkien')->with('success', 'Chào mừng quay trở lại!');
                case 5:
                    return redirect()->route('taikhoan.index')->with('success', 'Chào mừng quay trở lại!');
                default:
                    return redirect()->route('auth.login')->with('error', 'Bộ phận không được xác định');
            }
        }
    
        return back()
            ->with('error', 'Tài khoản hoặc mật khẩu không đúng.')
            ->withInput();
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}

