<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PhieuXuat;
use App\Models\NhanVien;
use App\Models\ChiTietPhieuXuat;
use App\Models\LinhKien;
use Barryvdh\DomPDF\Facade\Pdf;

class dsphieuXuatController extends Controller
{
    public function index(Request $request)
    {
        // Tạo query để lấy danh sách phiếu xuất
        $query = PhieuXuat::with(['nhanVienTao', 'nhanVienNhan']);
  
        if ($request->filled('MaHienThi')) {
            $query->where('MaHienThi', 'LIKE', '%' . $request->MaHienThi . '%');
        }

        if ($request->filled('NgayXuat')) {
            $query->whereDate('NgayXuat', $request->NgayXuat);
        }

        if ($request->filled('TenNhanVienTao')) {
            $query->whereHas('nhanVienTao', function ($q) use ($request) {
                $q->where('TenNhanVien', 'LIKE', '%' . $request->TenNhanVienTao . '%');
            });
        }

        if ($request->filled('TenNhanVienNhan')) {
            $query->whereHas('nhanVienNhan', function ($q) use ($request) {
                $q->where('TenNhanVien', 'LIKE', '%' . $request->TenNhanVienNhan . '%');
            });
        }
        $query->orderBy('NgayXuat', 'desc');
   
        $dsPhieuXuat = $query->paginate(10);

        return view('vPXuat.dsphieuxuat', compact('dsPhieuXuat'));
    }
    public function show($MaPhieuXuat)
    {
        
        $phieuXuat = PhieuXuat::with(['chiTietPhieuXuat.linhKien', 'nhanVienTao', 'nhanVienNhan'])
            ->findOrFail($MaPhieuXuat);
        return view('vPXuat.detailphieuxuat', compact('phieuXuat'));
    }
    public function create()
    {
        $nhanViens = NhanVien::where('MaBoPhan', 3)->get();

        return view('vPXuat.addphieuxuat', compact('nhanViens'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'NgayXuat' => 'required|date',
            'MaNhanVienTao' => 'required|exists:nhanvien,MaNhanVien',
            'MaNhanVienNhan' => 'required|exists:nhanvien,MaNhanVien',
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

            // Kiểm tra số lượng tồn kho trước khi lưu
            $errors = [];
            foreach ($validatedData['MaLinhKien'] as $index => $maLinhKien) {
                $linhKien = LinhKien::where('MaLinhKien', $maLinhKien)->first();

                if ($linhKien) {
                    if ($linhKien->SoLuong < $validatedData['SoLuong'][$index]) {     
                        $errors[] = 'Số lượng tồn kho không đủ cho linh kiện: ' . $linhKien->TenLinhKien;
                    }
                }
            }

            // Nếu có lỗi, rollback transaction và trả về view với lỗi
            if (!empty($errors)) {
                return redirect()->back()
                    ->withInput() // Giữ lại dữ liệu đã nhập
                    ->with('error', implode('<br>', $errors));
            }

            $phieuXuat = PhieuXuat::create([
                'NgayXuat' => $validatedData['NgayXuat'],
                'MaNhanVienTao' => $validatedData['MaNhanVienTao'],
                'MaNhanVienNhan' => $validatedData['MaNhanVienNhan'],
                'TongSoLuong' => $validatedData['TongSoLuong'],
                'GhiChu' => $validatedData['GhiChu'],
            ]);

            // Lưu chi tiết phiếu xuất và trừ số lượng tồn kho
            foreach ($validatedData['MaLinhKien'] as $index => $maLinhKien) {
                $linhKien = LinhKien::where('MaLinhKien', $maLinhKien)->first();

                $linhKien->SoLuong -= $validatedData['SoLuong'][$index];
                $linhKien->save();

                ChiTietPhieuXuat::create([
                    'MaPhieuXuat' => $phieuXuat->MaPhieuXuat,
                    'MaLinhKien' => $maLinhKien,
                    'SoLuong' => $validatedData['SoLuong'][$index],
                ]);
            }
            \DB::commit();
            return redirect()->route('dsphieuxuat')->with('success', 'Phiếu xuất mới đã được thêm vào danh sách!');
        } catch (\Exception $e) {
            // Rollback transaction nếu có lỗi
            \DB::rollBack();

            // Ghi log lỗi để kiểm tra
            \Log::error('Lỗi khi lưu phiếu xuất: ' . $e->getMessage());

            return redirect()->back()->withInput()->with('error', 'Đã xảy ra lỗi khi lưu phiếu xuất. Vui lòng thử lại!');
        }
    }
    public function exportPDF($MaPhieuXuat)
    {
        
            $phieuXuat = PhieuXuat::with(['nhanVienTao', 'nhanVienNhan', 'chiTietPhieuXuat.linhKien.donViTinh'])
                ->findOrFail($MaPhieuXuat);

            // Tạo file PDF từ view
            $pdf = Pdf::loadView('vPXuat.export', compact('phieuXuat'));

            // Trả về file PDF để xem trực tiếp
            return $pdf->stream('Phieu_Xuat_' . $phieuXuat->MaPhieuXuat . '.pdf');
       
    }
}
