<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PhieuTra;
use App\Models\NhanVien;
use App\Models\ChiTietPhieuTra;
use App\Models\LinhKien;
use Barryvdh\DomPDF\Facade\Pdf;
class dsphieuTraController extends Controller
{
    public function index(Request $request)
    {
        // Tạo query để lấy danh sách phiếu trả với các quan hệ liên quan
        $query = PhieuTra::with(['nhanVienTao', 'nhanVienTra']);

        if ($request->filled('MaHienThi')) {
            $query->where('MaHienThi', 'LIKE', '%' . $request->MaHienThi . '%');
        }

        if ($request->filled('NgayTra')) {
            $query->whereDate('NgayTra', $request->NgayTra);
        }

        if ($request->filled('TenNhanVienTao')) {
            $query->whereHas('nhanVienTao', function ($q) use ($request) {
                $q->where('TenNhanVien', 'LIKE', '%' . $request->TenNhanVienTao . '%');
            });
        }

        if ($request->filled('TenNhanVienTra')) {
            $query->whereHas('nhanVienTra', function ($q) use ($request) {
                $q->where('TenNhanVien', 'LIKE', '%' . $request->TenNhanVienTra  . '%');
            });
        }

        $dsPhieuTra = $query->paginate(10);

        return view('vTra.dsphieutra', compact('dsPhieuTra'));
    }

    public function show($MaPhieuTra)
    {
    
        $phieuTra = PhieuTra::with(['chiTietPhieuTra.linhKien', 'nhanVienTao', 'nhanVienTra'])
            ->findOrFail($MaPhieuTra);

        
        return view('vTra.detailphieutra', compact('phieuTra'));
    }

    public function create()
    {
        
        $nhanViens = NhanVien::where('MaBoPhan', 2)->get();

        return view('vTra.addphieutra', compact('nhanViens'));
    }

    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'NgayTra' => 'required|date',
            'MaNhanVienTao' => 'required|exists:nhanvien,MaNhanVien',
            'MaNhanVienTra' => 'required|exists:nhanvien,MaNhanVien',
            'TongSoLuong' => 'required|integer|min:1',
            'GhiChu' => 'nullable|string|max:255',
            'MaLinhKien' => 'required|array|min:1',
            'MaLinhKien.*' => 'required|string|exists:linhkiensuachua,MaLinhKien',
            'SoLuong' => 'required|array|min:1',
            'SoLuong.*' => 'required|integer|min:1',
        ]);

        try {
          
            // Bắt đầu transaction để đảm bảo tính toàn vẹn dữ liệu
            \DB::beginTransaction();

            $phieuTra = PhieuTra::create([
                'NgayTra' => $validatedData['NgayTra'],
                'MaNhanVienTao' => $validatedData['MaNhanVienTao'],
                'MaNhanVienTra' => $validatedData['MaNhanVienTra'],
                'TongSoLuong' => $validatedData['TongSoLuong'],
                'GhiChu' => $validatedData['GhiChu'],
            ]);

            // Lưu chi tiết phiếu trả và cập nhật số lượng tồn kho
            foreach ($validatedData['MaLinhKien'] as $index => $maLinhKien) {
                $linhKien = LinhKien::where('MaLinhKien', $maLinhKien)->first();

                if ($linhKien) {
                    $linhKien->SoLuong += $validatedData['SoLuong'][$index];
                    $linhKien->save();
                    ChiTietPhieuTra::create([
                        'MaPhieuTra' => $phieuTra->MaPhieuTra,
                        'MaLinhKien' => $maLinhKien,
                        'SoLuong' => $validatedData['SoLuong'][$index],
                    ]);
                }
            }

            // Commit transaction
            \DB::commit();

            return redirect()->route('dsphieutra')->with('success', 'Phiếu trả mới đã được thêm vào danh sách!');
        } catch (\Exception $e) {
            // Rollback transaction nếu có lỗi
            \DB::rollBack();

            // Ghi log lỗi để kiểm tra
            \Log::error('Lỗi khi lưu phiếu trả: ' . $e->getMessage());

            return redirect()->back()->withInput()->with('error', 'Đã xảy ra lỗi khi lưu phiếu trả. Vui lòng thử lại!');
        }
    }
    public function exportPDF($MaPhieuTra)
    {
        
            $phieuTra = PhieuTra::with(['nhanVienTao', 'nhanVienTra', 'chiTietPhieuTra.linhKien.donViTinh'])
                ->findOrFail($MaPhieuTra);

            $pdf = Pdf::loadView('vTra.export', compact('phieuTra'));

            return $pdf->stream('Phieu_Tra_' . $phieuTra->MaPhieuTra . '.pdf');
       
    }
   
}

