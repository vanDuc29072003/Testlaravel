<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaiKhoan;
use App\Models\NhanVien;
use Illuminate\Support\Facades\Hash;
use App\Models\BoPhan;

class TaiKhoanController extends Controller
{
    public function index(Request $request)
    {
        $taikhoans = TaiKhoan::query();
    
        // Lọc theo tên nhân viên
        if ($request->filled('TenNhanVien')) {
            $taikhoans->whereHas('nhanvien', function ($query) use ($request) {
                $query->where('TenNhanVien', 'like', '%' . $request->TenNhanVien . '%');
            });
        }
    
        // Lọc theo bộ phận
        if ($request->filled('MaBoPhan')) {
            $taikhoans->whereHas('nhanvien', function ($query) use ($request) {
                $query->where('MaBoPhan', $request->MaBoPhan);
            });
        }
    
        $taikhoans = $taikhoans->get();
    
        // Lấy danh sách nhân viên và bộ phận để lọc
        $nhanviens = NhanVien::all();
        $bophans = BoPhan::all();  // Giả sử bạn có model `BoPhan` để lấy danh sách bộ phận
    
        return view('Vtaikhoan.taikhoan', compact('taikhoans', 'nhanviens', 'bophans'));
    }
    




    // Form thêm tài khoản
    public function create()
    {
        // Lấy danh sách nhân viên để chọn
        $nhanviens = NhanVien::all();
        return view('Vtaikhoan.createTaiKhoan', compact('nhanviens'));
    }

    // Lưu tài khoản mới
    public function store(Request $request)
    {
        // Kiểm tra xem MaNhanVien đã tồn tại trong bảng taikhoan chưa
        $existingAccount = TaiKhoan::where('MaNhanVien', $request->MaNhanVien)->first();
        if ($existingAccount) {
            return redirect()->route('taikhoan.index')->with('error', 'Tài khoản cho nhân viên này đã tồn tại.');
        }

        // Validate dữ liệu đầu vào
        $request->validate([
            'MaNhanVien' => 'required|exists:nhanvien,MaNhanVien',
            'TenTaiKhoan' => 'required|unique:taikhoan,TenTaiKhoan',
            'MatKhauChuaMaHoa' => 'required|string|min:6',
        ]);

        // Lưu tài khoản vào cơ sở dữ liệu
        TaiKhoan::create([
            'MaNhanVien' => $request->MaNhanVien,
            'TenTaiKhoan' => $request->TenTaiKhoan,
            'MatKhauChuaMaHoa' => $request->MatKhauChuaMaHoa,
            'MatKhau' => Hash::make($request->MatKhauChuaMaHoa),
        ]);

        return redirect()->route('taikhoan.index')->with('success', 'Thêm tài khoản thành công.');
    }
    public function edit($TenTaiKhoan)
    {
        $taikhoan = TaiKhoan::with('nhanvien')->findOrFail($TenTaiKhoan);
        return view('Vtaikhoan.editTaiKhoan', compact('taikhoan'));
    }

    public function update(Request $request, $id)
{
    // Kiểm tra và xác thực dữ liệu
    $request->validate([
        'MatKhauChuaMaHoa' => 'required|string|min:6', // Đảm bảo mật khẩu mới dài ít nhất 6 ký tự
    ]);

    // Tìm tài khoản theo TenTaiKhoan (hoặc ID)
    $taikhoan = TaiKhoan::where('TenTaiKhoan', $id)->firstOrFail();

    // Cập nhật mật khẩu chưa mã hóa và mật khẩu mã hóa
    $taikhoan->update([
        'MatKhauChuaMaHoa' => $request->MatKhauChuaMaHoa,  // Lưu mật khẩu chưa mã hóa
        'MatKhau' => bcrypt($request->MatKhauChuaMaHoa),     // Mã hóa mật khẩu và lưu vào trường MatKhau
    ]);

    // Thông báo thành công và quay lại trang danh sách
    return redirect()->route('taikhoan.index')->with('success', 'Cập nhật mật khẩu thành công.');
}

    
    // Xóa tài khoản
    public function destroy($id)
    {
        $taikhoan = TaiKhoan::findOrFail($id);
        $taikhoan->delete();

        return redirect()->route('taikhoan.index')->with('success', 'Xóa tài khoản thành công.');
    }
}
