<?php

namespace App\Http\Controllers;

use App\Events\eventUpdateTable;
use App\Events\eventUpdateUI;
use Illuminate\Http\Request;
use App\Models\PhieuNhap;
use App\Models\NhaCungCap;
use App\Models\NhanVien;
use App\Models\ChiTietPhieuNhap;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\LienKetLKNCC;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Events\eventPhieuNhap;
use App\Models\ThongBao;
use Auth;


class dsphieuNhapController extends Controller
{

    public function index(Request $request)
    {
        $query = PhieuNhap::query(); // Khởi tạo query
        $dsNhaCungCap = NhaCungCap::all();
        $dsNhanVien = NhanVien::where('MaBoPhan', 4)->get();

        // Danh sách các trường cần lọc
        $filters = [
            'MaHienThi' => '=',
            'NgayNhap' => 'like',
            'MaNhanVien' => '=',
            'TongSoLuong' => 'like',
            'TongTien' => 'like',
            'GhiChu' => 'like',
        ];

        // Áp dụng các điều kiện lọc chỉ cho dsPhieuNhapDaDuyet
        foreach ($filters as $field => $operator) {
            if ($request->filled($field)) {
                $value = $operator === 'like' ? '%' . $request->$field . '%' : $request->$field;
                $query->where($field, $operator, $value);
            }
        }
        if ($request->filled('TenNhaCungCap')) {
            $query->whereHas('nhaCungCap', function ($q) use ($request) {
                $q->where('TenNhaCungCap', 'like', '%' . $request->TenNhaCungCap . '%');
            });
        }

        // Lấy danh sách phiếu nhập đã duyệt
        $dsPhieuNhapDaDuyet = $query
            ->where('TrangThai', '!=', 0)
            ->with('nhaCungCap', 'nhanVien')
            ->orderBy('MaHienThi', 'desc')
            ->paginate(10, ['*'], 'da_duyet');

        // Lấy danh sách phiếu nhập chờ duyệt (không áp dụng tìm kiếm)
        $dsPhieuNhapChoDuyet = PhieuNhap::where('TrangThai', '0')
            ->with('nhaCungCap', 'nhanVien')
            ->orderBy('MaHienThi', 'desc')
            ->paginate(10, ['*'], 'cho_duyet');

        ThongBao::where('Icon', 'fas fa-pen')->update(['TrangThai' => 1]);

        return view('vPNhap.dsphieunhap', compact('dsPhieuNhapChoDuyet', 'dsPhieuNhapDaDuyet', 'dsNhaCungCap', 'dsNhanVien'));
    }
    public function saveSession(Request $request)
    {
        $data = $request->all();

        $phieuNhapSession = [
            'MaNhaCungCap' => $data['MaNhaCungCap'],
            'NgayNhap' => $data['NgayNhap'],
            'GhiChu' => $data['GhiChu'],
            'TongSoLuong' => $data['TongSoLuong'],
            'TongThanhTien' => $data['TongThanhTien'],
            'LinhKienList' => $data['LinhKienList']
        ];

        session(['phieuNhapSession' => $phieuNhapSession]);

        return response()->json(['status' => 'saved']);
    }


    public function create(Request $request)
    {

        if ($request->has('new')) {
            session()->forget('phieuNhapSession');
        }

        $nhaCungCaps = NhaCungCap::all();
        $nhanViens = NhanVien::all();


        $phieuNhapSession = session()->get('phieuNhapSession', []);

        return view('vPNhap.addphieunhap', compact('nhaCungCaps', 'nhanViens', 'phieuNhapSession'));
    }






    public function store(Request $request)
    {
        // dd($request->all());
        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'NgayNhap' => 'required|date',
            'MaNhaCungCap' => 'required|exists:nhacungcap,MaNhaCungCap',
            'MaNhanVien' => 'required|exists:nhanvien,MaNhanVien',
            'TongSoLuong' => 'required|string', // Tạm để string để xử lý dấu chấm
            'TongTien' => 'required|string',
            'GhiChu' => 'nullable|string|max:255',
            'MaLinhKien' => 'required|array|min:1',
            'MaLinhKien.*' => 'required|string|exists:linhkiensuachua,MaLinhKien',
            'SoLuong' => 'required|array|min:1',
            'SoLuong.*' => 'required|string', // Tạm để string để xử lý dấu chấm
            'GiaNhap' => 'required|array|min:1',
            'GiaNhap.*' => 'required|string', // Tạm để string để xử lý dấu chấm
        ]);

        try {
           
            $tongSoLuong = (int) str_replace('.', '', $validatedData['TongSoLuong']);
            $tongTien = (float) str_replace('.', '', $validatedData['TongTien']);
            $soLuongList = array_map(fn($v) => (int) str_replace('.', '', $v), $validatedData['SoLuong']);
            $giaNhapList = array_map(fn($v) => (float) str_replace('.', '', $v), $validatedData['GiaNhap']);

            // Lưu phiếu nhập
            $phieuNhap = PhieuNhap::create([
                'NgayNhap' => $validatedData['NgayNhap'],
                'MaNhaCungCap' => $validatedData['MaNhaCungCap'],
                'MaNhanVien' => $validatedData['MaNhanVien'],
                'TongTien' => $tongTien,
                'TongSoLuong' => $tongSoLuong,
                'GhiChu' => $validatedData['GhiChu'],
                'TrangThai' => 0, // Mặc định trạng thái là chờ duyệt
            ]);

            // Lưu chi tiết phiếu nhập
            foreach ($validatedData['MaLinhKien'] as $index => $maLinhKien) {
                ChiTietPhieuNhap::create([
                    'MaPhieuNhap' => $phieuNhap->MaPhieuNhap,
                    'MaLinhKien' => $maLinhKien,
                    'SoLuong' => $soLuongList[$index],
                    'GiaNhap' => $giaNhapList[$index],
                    'TongCong' => $soLuongList[$index] * $giaNhapList[$index],
                ]);
            }

            ThongBao::create([
                'NoiDung' => Auth()->user()->nhanvien->TenNhanVien . ' đã tạo một phiếu nhập mới cần duyệt',
                'Loai' => 'info',
                'Icon' => 'fas fa-pen',
                'Route' => 'dsphieunhap'
            ]);

            event(new eventPhieuNhap());
            event(new eventUpdateTable());
            event(new eventUpdateUI());

            return redirect()->route('dsphieunhap')->with('success', 'Phiếu nhập mới đã được thêm vào danh sách chờ duyệt!');
        } catch (\Exception $e) {
            // Ghi log lỗi để kiểm tra
            Log::error('Lỗi khi lưu phiếu nhập: ' . $e->getMessage());

            return redirect()->back()->withInput()->with('error', 'Đã xảy ra lỗi khi lưu phiếu nhập. Vui lòng thử lại!');
        }
    }


    public function show($MaPhieuNhap)
    {
        // Lấy thông tin phiếu nhập cùng với nhà cung cấp, nhân viên và danh sách chi tiết phiếu nhập
        $phieuNhap = PhieuNhap::with(['chiTietPhieuNhap.linhKien.donViTinh', 'nhaCungCap', 'nhanVien', 'nhanVienDuyet'])->findOrFail($MaPhieuNhap);

        // Trả về view chi tiết phiếu nhập
        return view('vPNhap.detailphieunhap', compact('phieuNhap'));
    }


    public function edit(Request $request, $MaPhieuNhap)
    {
        $isNew = $request->query('new');

        // Nếu đang tạo mới lại thì xóa session cũ (nếu có)
        if ($isNew === 'true') {
            session()->forget('phieuNhapSession1');
        }

        // Lấy dữ liệu session nếu có và không phải đang tạo mới
        $phieuNhapSession1 = session()->get('phieuNhapSession1');

        if (!$isNew && $phieuNhapSession1 && isset($phieuNhapSession1['MaPhieuNhap']) && $phieuNhapSession1['MaPhieuNhap'] == $MaPhieuNhap) {
            $nhaCungCaps = NhaCungCap::all();
            $nhanViens = NhanVien::all();
            $phieuNhap = (object) $phieuNhapSession1;

            return view('vPNhap.editPhieunhap', compact('phieuNhap', 'nhaCungCaps', 'nhanViens', 'phieuNhapSession1', 'isNew'));
        }

        // Lấy dữ liệu từ DB
        $phieuNhap = PhieuNhap::with(['chiTietPhieuNhap.linhKien.donViTinh', 'nhaCungCap', 'nhanVien'])->findOrFail($MaPhieuNhap);

        $nhaCungCaps = NhaCungCap::all();
        $nhanViens = NhanVien::all();

        return view('vPNhap.editPhieunhap', compact('phieuNhap', 'nhaCungCaps', 'nhanViens', 'isNew'));
    }



    public function saveSession1(Request $request)
    {
        $data = $request->all();

        $phieuNhapSession1 = [
            'MaPhieuNhap' => $data['MaPhieuNhap'],
            'MaNhaCungCap' => $data['MaNhaCungCap'],
            'MaNhanVien' => $data['MaNhanVien'],
            'TenNhanVien' => $data['TenNhanVien'],
            'NgayNhap' => $data['NgayNhap'],
            'GhiChu' => $data['GhiChu'],
            'TongSoLuong' => $data['TongSoLuong'],
            'TongThanhTien' => $data['TongThanhTien'],
            'LinhKienList' => $data['LinhKienList']
        ];

        session(['phieuNhapSession1' => $phieuNhapSession1]);

        return response()->json(['status' => 'saved']);
    }
    public function update(Request $request, $MaPhieuNhap)
    {
        $validatedData = $request->validate([
            'NgayNhap' => 'required|date',
            'MaNhaCungCap' => 'required|exists:nhacungcap,MaNhaCungCap',
            'TongSoLuong' => 'required|string', // để xử lý dấu chấm
            'TongTien' => 'required|string',
            'GhiChu' => 'nullable|string|max:255',
            'MaLinhKien' => 'required|array|min:1',
            'MaLinhKien.*' => 'required|string|exists:linhkiensuachua,MaLinhKien',
            'SoLuong' => 'required|array|min:1',
            'SoLuong.*' => 'required|string',
            'GiaNhap' => 'required|array|min:1',
            'GiaNhap.*' => 'required|string',
        ]);

        try {
         
            $tongSoLuong = (int) str_replace('.', '', $validatedData['TongSoLuong']);
            $tongTien = (float) str_replace('.', '', $validatedData['TongTien']);
            $soLuongList = array_map(fn($v) => (int) str_replace('.', '', $v), $validatedData['SoLuong']);
            $giaNhapList = array_map(fn($v) => (float) str_replace('.', '', $v), $validatedData['GiaNhap']);

            // Cập nhật phiếu nhập
            $phieuNhap = PhieuNhap::findOrFail($MaPhieuNhap);
            $phieuNhap->update([
                'NgayNhap' => $validatedData['NgayNhap'],
                'MaNhaCungCap' => $validatedData['MaNhaCungCap'],
                'TongTien' => $tongTien,
                'TongSoLuong' => $tongSoLuong,
                'GhiChu' => $validatedData['GhiChu'],
            ]);

            // Xóa chi tiết cũ và thêm chi tiết mới
            $phieuNhap->chiTietPhieuNhap()->delete();
            foreach ($validatedData['MaLinhKien'] as $index => $maLinhKien) {
                ChiTietPhieuNhap::create([
                    'MaPhieuNhap' => $phieuNhap->MaPhieuNhap,
                    'MaLinhKien' => $maLinhKien,
                    'SoLuong' => $soLuongList[$index],
                    'GiaNhap' => $giaNhapList[$index],
                    'TongCong' => $soLuongList[$index] * $giaNhapList[$index],
                ]);
            }

            return redirect()->route('phieunhap.show', ['MaPhieuNhap' => $phieuNhap->MaPhieuNhap])
                ->with('success', 'Phiếu nhập đã được cập nhật thành công!');

        } catch (\Exception $e) {
            Log::error('Lỗi khi cập nhật phiếu nhập: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Đã xảy ra lỗi khi cập nhật phiếu nhập.');
        }
    }

    public function exportPDF($MaPhieuNhap)
    {
        // Lấy thông tin phiếu nhập cùng với nhà cung cấp, nhân viên và danh sách chi tiết phiếu nhập
        $phieuNhap = PhieuNhap::with(['chiTietPhieuNhap.linhKien.donViTinh', 'nhaCungCap', 'nhanVien'])->findOrFail($MaPhieuNhap);

        // Tạo file PDF từ view
        $pdf = Pdf::loadView('vPNhap.export', compact('phieuNhap'));

        // Trả về file PDF để xem trực tiếp
        return $pdf->stream('Phieu_Nhap_' . $phieuNhap->MaPhieuNhap . '.pdf');
    }
    public function destroy($MaPhieuNhap)
    {
        $phieuNhap = PhieuNhap::findOrFail($MaPhieuNhap);

        // Kiểm tra trạng thái phiếu nhập (chỉ cho phép xóa nếu trạng thái là "Chờ duyệt")
        if ($phieuNhap->TrangThai != 0) {
            return redirect()->route('dsphieunhap')->with('error', 'Chỉ có thể xóa phiếu nhập ở trạng thái "Chờ duyệt".');
        }

        $phieuNhap->TrangThai = 2;
        $phieuNhap->MaNhanVienDuyet = Auth::user()->MaNhanVien;
        $phieuNhap->save();

        return redirect()->route('dsphieunhap')->with('success', 'Phiếu nhập này đã bị từ chối nhập vào kho!');
    }


    public function approve($MaPhieuNhap)
    {
        $phieuNhap = PhieuNhap::with('chiTietPhieuNhap.linhKien')->findOrFail($MaPhieuNhap);
        try {
            // Bắt đầu transaction để đảm bảo tính toàn vẹn dữ liệu
            DB::beginTransaction();

            // Cập nhật số lượng tồn kho cho từng linh kiện
            foreach ($phieuNhap->chiTietPhieuNhap as $chiTiet) {
                $linhKien = $chiTiet->linhKien; // Lấy thông tin linh kiện
                if ($linhKien) {
                    $linhKien->SoLuong += $chiTiet->SoLuong; // Cộng số lượng nhập vào tồn kho
                    $linhKien->save();

                    // Kiểm tra và thêm dữ liệu vào bảng liên kết
                    $exists = DB::table('nhacungcap_linhkien')
                        ->where('MaLinhKien', $linhKien->MaLinhKien)
                        ->where('MaNhaCungCap', $phieuNhap->MaNhaCungCap)
                        ->exists();

                    if (!$exists) {
                        // Nếu không tồn tại cả hai mã, thêm mới
                        LienKetLKNCC::create([
                            'MaLinhKien' => $linhKien->MaLinhKien,
                            'MaNhaCungCap' => $phieuNhap->MaNhaCungCap,
                        ]);
                    }
                }
            }

            // Cập nhật trạng thái phiếu nhập thành "Đã phê duyệt"
            $phieuNhap->update([
                'TrangThai' => 1, // 1: Đã phê duyệt
                'MaNhanVienDuyet' => Auth::user()->MaNhanVien
            ]);

            // Commit transaction
            DB::commit();

            return redirect()->route('dsphieunhap')->with('success', 'Phiếu nhập đã được phê duyệt và số lượng linh kiện đã được cập nhật!');
        } catch (\Exception $e) {
            // Rollback transaction nếu có lỗi
            DB::rollBack();

            // Ghi log lỗi để kiểm tra
            Log::error('Lỗi khi phê duyệt phiếu nhập: ' . $e->getMessage());

            return redirect()->route('dsphieunhap')->with('error', 'Đã xảy ra lỗi khi phê duyệt phiếu nhập. Vui lòng thử lại!');
        }
    }
}

