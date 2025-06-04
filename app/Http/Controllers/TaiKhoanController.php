<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaiKhoan;
use App\Models\NhanVien;
use Illuminate\Support\Facades\Hash;
use App\Models\Bophan;

class TaiKhoanController extends Controller
{
    public function index(Request $request)
    {
        $taikhoans = TaiKhoan::query();
    
        // Lọc theo tên nhân viên (nếu có)
        if ($request->filled('TenNhanVien')) {
            $taikhoans->whereHas('nhanvien', function ($query) use ($request) {
                $query->where('TenNhanVien', 'like', '%' . $request->TenNhanVien . '%');
            });
        }
    
        // Lọc theo mã bộ phận (nếu có)
        if ($request->filled('MaBoPhan')) {
            $taikhoans->whereHas('nhanvien', function ($query) use ($request) {
                $query->where('MaBoPhan', $request->MaBoPhan);
            });
        }
    
        // Lấy danh sách kết quả sau khi lọc
        $taikhoans = $taikhoans->get();
    
        // Dữ liệu cho dropdown lọc
        $nhanviens = NhanVien::all(); 
        $bophans = BoPhan::all();     
    
        return view('Vtaikhoan.taikhoan', compact('taikhoans', 'nhanviens', 'bophans'));
    }
    
    




    // Form thêm tài khoản
    public function create()
    {
        $bophans = Bophan::all(); 
        // Lấy danh sách nhân viên để chọn
        $maNhanVien = NhanVien::max('MaNhanVien')+1;
        return view('Vtaikhoan.createTaiKhoan', compact('maNhanVien','bophans'));
    }

    // Lưu tài khoản mới
    public function store(Request $request)
    {
        try {
            // Validate dữ liệu
            $validated = $request->validate([
                'TenNhanVien' => 'required|string|max:100',
                'Email' => 'required|email|unique:nhanvien,Email',
                'GioiTinh' => 'required|in:Nam,Nữ',
                'NgaySinh' => 'required|date',
                'SDT' => 'required|digits:10|unique:nhanvien,SDT',
                'DiaChi' => 'required|string|max:255',
                'MaBoPhan' => 'required|exists:bophan,MaBoPhan',
                'MatKhauChuaMaHoa' => 'required|string|min:6',
            ],[
                'TenNhanVien.required' => 'Tên nhân viên là bắt buộc.',
                'Email.unique' => 'Email đã tồn tại.',
                'SDT.digits' => 'Số điện thoại phải có 10 chữ số.',
                'SDT.unique' => 'Số điện thoại đã tồn tại.',
            ]
        );

            // Tạo nhân viên
            $nhanvien = new NhanVien();
            $nhanvien->TenNhanVien = $validated['TenNhanVien'];
            $nhanvien->Email = $validated['Email'];
            $nhanvien->GioiTinh = $validated['GioiTinh'];
            $nhanvien->NgaySinh = $validated['NgaySinh'];
            $nhanvien->SDT = $validated['SDT'];
            $nhanvien->DiaChi = $validated['DiaChi'];
            $nhanvien->MaBoPhan = $validated['MaBoPhan'];
            $nhanvien->save(); // ;

            // Lấy TenRutGon
            $tenRutGon = BoPhan::find($validated['MaBoPhan'])->TenRutGon ?? 'XX';
            $tenTaiKhoan = $tenRutGon . $nhanvien->MaNhanVien;

            // Kiểm tra trùng tài khoản
            $base = $tenTaiKhoan;
            $suffix = 1;
            while (TaiKhoan::where('TenTaiKhoan', $tenTaiKhoan)->exists()) {
                $tenTaiKhoan = $base . '_' . $suffix++;
            }

            // Tạo tài khoản
            $matkhauMacDinh = 'TKhoa12345@';
            TaiKhoan::create([
                'MaNhanVien' => $nhanvien->MaNhanVien,
                'TenTaiKhoan' => $tenTaiKhoan,
                'MatKhau' => bcrypt($matkhauMacDinh),
                'MatKhauChuaMaHoa' => $matkhauMacDinh,
            ]);

            return redirect()->route('taikhoan.index')
                            ->with('success', 'Thêm tài khoản thành công!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withInput()
                        ->with('error', 'Đã xảy ra lỗi: ' . $e->validator->errors()->first());
        }
    }


        public function edit($MaNhanVien)
    {
        
        // Truy vấn tài khoản với mối quan hệ nhanvien
        $taikhoan = TaiKhoan::with('nhanvien')->findOrFail($MaNhanVien);
        
        // Trả về view sửa tài khoản
        return view('Vtaikhoan.editTaiKhoan', compact('taikhoan'));
    }
    
    public function editThongTin($TenTaiKhoan)
    {
        $taikhoan = TaiKhoan::with('nhanvien.bophan')->where('TenTaiKhoan', $TenTaiKhoan)->firstOrFail();
        $boPhans = BoPhan::all(); // Để hiển thị dropdown bộ phận
        return view('Vtaikhoan.editThongTin', compact('taikhoan', 'boPhans'));
    }
    public function updateThongTin(Request $request, $TenTaiKhoan)
    {
        $taikhoan = TaiKhoan::with('nhanvien')->where('TenTaiKhoan', $TenTaiKhoan)->firstOrFail();

        $request->validate([
            'TenNhanVien' => 'required|string|max:255',
            'Email' => 'required|email',
            'SDT' => 'nullable|string|max:20',
            'DiaChi' => 'nullable|string|max:255',
            'NgaySinh' => 'nullable|date',
            'GioiTinh' => 'required|in:Nam,Nữ',
            'MaBoPhan' => 'required|exists:bophan,MaBoPhan',
            'MatKhauChuaMaHoa' => 'nullable|string|min:6',
        ]);

        // Cập nhật thông tin nhân viên liên kết với tài khoản
        if ($taikhoan->nhanvien) {
            $nhanvien = $taikhoan->nhanvien;
            $nhanvien->TenNhanVien = $request->TenNhanVien;
            $nhanvien->Email = $request->Email;
            $nhanvien->SDT = $request->SDT;
            $nhanvien->DiaChi = $request->DiaChi;
            $nhanvien->NgaySinh = $request->NgaySinh;
            $nhanvien->GioiTinh = $request->GioiTinh;
            $nhanvien->MaBoPhan = $request->MaBoPhan;
            if ($request->has('MatKhauChuaMaHoa') && !empty($request->MatKhauChuaMaHoa)) {
                $taikhoan->MatKhauChuaMaHoa = $request->MatKhauChuaMaHoa;
                $taikhoan->MatKhau = Hash::make($request->MatKhauChuaMaHoa);
            }
            $nhanvien->save();
            $taikhoan->save();
        }
        return redirect()->route('taikhoan.show', $taikhoan->TenTaiKhoan)->with('success', 'Cập nhật thành công!');
    }

    public function update(Request $request, $id)
        {
            $request->validate([
                'MatKhauChuaMaHoa' => 'required|string|min:6',
            ]);

            $taikhoan = TaiKhoan::findOrFail($id); // Không cần where('TenTaiKhoan', ...)

            $taikhoan->MatKhauChuaMaHoa = $request->MatKhauChuaMaHoa;
            $taikhoan->MatKhau = Hash::make($request->MatKhauChuaMaHoa); // mã hóa đúng
            $taikhoan->save(); // dùng save thay vì update để đảm bảo model ghi đúng
            
            return redirect()->route('taikhoan.index')->with('success', 'Cập nhật mật khẩu thành công.');
        }

    

    public function show($TenTaiKhoan)
    {
        $taikhoan = TaiKhoan::where('TenTaiKhoan', $TenTaiKhoan)
            ->with(['nhanvien.bophan']) // eager load nhân viên và bộ phận
            ->firstOrFail();

        return view('Vtaikhoan.detailTaiKhoan', compact('taikhoan'));
    }
    // Xóa tài khoản
    public function destroy($TenTaiKhoan)
    {
        $taikhoan = TaiKhoan::where('TenTaiKhoan', $TenTaiKhoan)->firstOrFail();
        $taikhoan->delete();

        return redirect()->route('taikhoan.index')->with('success', 'Xóa tài khoản thành công!');
    }
}
