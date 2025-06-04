<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Otp;
use Carbon\Carbon;
use App\Models\TaiKhoan;
use Illuminate\Support\Facades\Hash;
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
            Auth::logout();

            $user = \App\Models\TaiKhoan::where('TenTaiKhoan', $credentials['TenTaiKhoan'])->first();
            $email = $user->nhanvien->Email ?? null;

            if (!$email) {
                return back()->with('error', 'Không tìm thấy email để gửi OTP.');
            }

            $otpCode = rand(100000, 999999);

            Otp::create([
                'TenTaiKhoan' => $credentials['TenTaiKhoan'],
                'otp_code' => $otpCode,
                'expires_at' => Carbon::now()->addMinutes(3),
            ]);

            Mail::raw("Mã OTP của bạn là: $otpCode", function ($message) use ($email) {
                $message->to($email)->subject('Xác thực đăng nhập - Mã OTP');
            });

            $request->session()->put('pending_user', $credentials['TenTaiKhoan']);

            return redirect()->route('otp.form')->with('success', 'Mã OTP đã được gửi tới email.');
        }

        return back()->with('error', 'Tài khoản hoặc mật khẩu không đúng.');
    }
    
    public function showOtpForm()
    {
        return view('auth.otp');
    }
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp_code' => 'required|digits:6',
        ]);

        $username = $request->session()->get('pending_user');
        if (!$username) {
            return redirect()->route('login')->with('error', 'Phiên đăng nhập hết hạn.');
        }

        
        // dd([
        //     'username' => $username,
        //     'entered_otp' => $request->otp_code,
        //     'current_time' => Carbon::now(),
        // ]);

        $otp = Otp::where('TenTaiKhoan', $username)
            ->where('otp_code', $request->otp_code)
            ->where('expires_at', '>', Carbon::now())
            ->orderBy('created_at', 'desc') // Đảm bảo lấy OTP mới nhất
            ->first();

       
        // dd([
        //     'queried_otp' => $otp,
        // ]);

        if (!$otp) {
            return back()->with('error', 'Mã OTP không hợp lệ hoặc đã hết hạn.');
        }

        // OTP đúng, đăng nhập
        $user = TaiKhoan::with('nhanvien')->where('TenTaiKhoan', $username)->first();

        
        // Debug: Kiểm tra thông tin user trước khi đăng nhập
        // dd([
        //     'user_found' => $user,
        // ]);

        Auth::login($user);
        $request->session()->forget('pending_user');
        $maBoPhan = $user->nhanvien->MaBoPhan ?? null;

       
            switch ((int) $maBoPhan) {
                case 1:
                    return redirect()->route('dashboard.index')->with('success', 'Đăng nhập thành công!');
                case 2:
                    return redirect()->route('lichvanhanh')->with('success', 'Đăng nhập thành công!');
                case 3:
                    return redirect()->route('lichsuachua.index')->with('success', 'Đăng nhập thành công!');
                case 4:
                    return redirect()->route('linhkien')->with('success', 'Đăng nhập thành công!');
                default:
                    return redirect()->route('taikhoan.index')->with('success', 'Đăng nhập thành công!');
            }
    }




    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
    public function resendOtp(Request $request)
    {
        $username = $request->session()->get('pending_user');
        if (!$username) {
            return redirect()->route('login')->with('error', 'Phiên đăng nhập hết hạn.');
        }

        $user = \App\Models\User::where('TenTaiKhoan', $username)->first();
        $email = $user->nhanVien->Email ?? null;

        if (!$email) {
            return back()->with('error', 'Không tìm thấy email.');
        }

        $otpCode = rand(100000, 999999);

        Otp::create([
            'TenTaiKhoan' => $username,
            'otp_code' => $otpCode,
            'expires_at' => Carbon::now()->addMinutes(1),
        ]);

        Mail::raw("Mã OTP của bạn là: $otpCode", function ($message) use ($email) {
            $message->to($email)->subject('Gửi lại mã OTP');
        });

        return back()->with('success', 'Mã OTP mới đã được gửi tới email.');
    }
    
    public function showForgotPasswordForm()
    {
        return view('auth.change_password'); // form nhập TenTaiKhoan
    }

   
    public function sendOtpForResetPassword(Request $request)
    {
        $request->validate([
            'TenTaiKhoan' => 'required',
        ]);

        $username = $request->TenTaiKhoan;
        $user = TaiKhoan::where('TenTaiKhoan', $username)->first();

        if (!$user) {
            return back()->with('error', 'Tài khoản không tồn tại.');
        }

        $email = $user->nhanVien->Email ?? null;
        if (!$email) {
            return back()->with('error', 'Không tìm thấy email của nhân viên.');
        }

        $otpCode = rand(100000, 999999);

        Otp::create([
            'TenTaiKhoan' => $username,
            'otp_code' => $otpCode,
            'expires_at' => \Carbon\Carbon::now()->addMinutes(3),
        ]);

        Mail::raw("Mã OTP đặt lại mật khẩu của bạn là: $otpCode", function ($message) use ($email) {
            $message->to($email)->subject('Mã OTP đặt lại mật khẩu');
        });

        session(['pending_user' => $username]);

        return view('auth.reset_password')->with('success', 'Mã OTP đã được gửi tới email.'); 
    }

    
    public function resetPassword(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
            'MatKhau' => 'required|min:6|confirmed',
        ]);

        $username = session('pending_user');
        if (!$username) {
            return redirect()->route('login')->with('error', 'Phiên đã hết hạn.');
        }

        $otp = Otp::where('TenTaiKhoan', $username)
            ->where('otp_code', $request->otp)
            ->where('expires_at', '>', \Carbon\Carbon::now())
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$otp) {
            return back()->with('error', 'Mã OTP không đúng hoặc đã hết hạn.');
        }

        $user = TaiKhoan::where('TenTaiKhoan', $username)->first();
        if (!$user) {
            return back()->with('error', 'Tài khoản không tồn tại.');
        }

        $user->MatKhau = Hash::make($request->MatKhau);
        $user->MatKhauChuaMaHoa = $request->MatKhau;
        $user->save();

        $request->session()->forget('pending_user');

        return redirect()->route('login')->with('success', 'Đổi mật khẩu thành công. Vui lòng đăng nhập lại.');
    }
}

