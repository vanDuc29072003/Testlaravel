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
            'MaNhanVien' => 'required',
            'MatKhau' => 'required'
        ]);

        if (Auth::attempt(['MaNhanVien' => $credentials['MaNhanVien'], 'password' => $credentials['MatKhau']])) {
            $request->session()->regenerate();
            return redirect()->route('may')->with('success', 'Chào mừng quay trở lại!');
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

