<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PhieuBanGiaoNoiBo;
use App\Models\ChiTietPhieuBanGiaoNoiBo;
use App\Models\LichSuaChua;
use App\Models\LinhKien;
use App\Models\PhieuBanGiaoSuaChuaNCC;
use App\Models\PhieuBanGiaoNCC;
use App\Models\ChiTietPhieuSuaNCC;
use App\Models\YeuCauSuaChua;
use App\Models\ChiTietPhieuBanGiaoNCC;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\PhieuBanGiaoBaoTri;
use App\Models\ChiTietPhieuBanGiaoBaoTri;
use App\Models\LichBaoTri;

class PhieuBanGiaoController extends Controller
{

    public function store(Request $request)
    {
        // Validate phần chung (không liên quan đến linh kiện)
        $rules = [
            'MaLichSuaChua' => 'required|exists:lichsuachua,MaLichSuaChua',
            'ThoiGianBanGiao' => 'required|date',
            'BienPhapXuLy' => 'nullable|string|max:255',
            'GhiChu' => 'nullable|string|max:255',
        ];

        // Nếu có nhập linh kiện thì validate thêm
        if ($request->has('MaLinhKien') && is_array($request->MaLinhKien)) {
            $rules['MaLinhKien'] = 'required|array';
            $rules['SoLuong'] = 'required|array';
            $rules['MaLinhKien.*'] = 'exists:linhkiensuachua,MaLinhKien';
            $rules['SoLuong.*'] = 'integer|min:1';
        }

        // Thực hiện validate
        $request->validate($rules);

        // Tạo phiếu bàn giao nội bộ
        $phieuBanGiaoNoiBo = new PhieuBanGiaoNoiBo();
        $phieuBanGiaoNoiBo->MaPhieuBanGiaoNoiBo = $request->MaLichSuaChua;
        $phieuBanGiaoNoiBo->MaLichSuaChua = $request->MaLichSuaChua;
        $phieuBanGiaoNoiBo->ThoiGianBanGiao = $request->ThoiGianBanGiao;
        $phieuBanGiaoNoiBo->BienPhapXuLy = $request->BienPhapXuLy;
        $phieuBanGiaoNoiBo->GhiChu = $request->GhiChu;
        $phieuBanGiaoNoiBo->save();

        // Nếu có linh kiện, lưu chi tiết phiếu bàn giao
        if ($request->has('MaLinhKien') && is_array($request->MaLinhKien)) {
            foreach ($request->MaLinhKien as $index => $maLinhKien) {
                ChiTietPhieuBanGiaoNoiBo::create([
                    'MaPhieuBanGiaoNoiBo' => $phieuBanGiaoNoiBo->MaLichSuaChua,
                    'MaLinhKien' => $maLinhKien,
                    'SoLuong' => $request->SoLuong[$index],
                ]);
            }
        }

        // Cập nhật trạng thái của lịch sửa chữa
        $lichSuaChua = LichSuaChua::findOrFail($request->MaLichSuaChua);
        $lichSuaChua->TrangThai = 1;
        $lichSuaChua->save();

        return redirect()->route('lichsuachua.dahoanthanh')
            ->with('success', 'Phiếu bàn giao nội bộ đã được tạo thành công!');
    }



    public function store1(Request $request)
    {
        try {
            // Validate input
            // Validate input
            $request->validate([
                'MaLichSuaChua' => 'required|exists:lichsuachua,MaLichSuaChua',
                'MaNhaCungCap' => 'required|exists:nhacungcap,MaNhaCungCap',
                'ThoiGianBanGiao' => 'required|date',
                'BienPhapXuLy' => 'nullable|string|max:255',
                'GhiChu' => 'nullable|string|max:255',
                'TenLinhKien' => ['required', 'array'],
                'TenLinhKien.*' => ['required', 'regex:/^[\pL\s]+$/u'],

                'DonViTinh' => ['required', 'array'],
                'DonViTinh.*' => ['required', 'regex:/^[\pL\s]+$/u'],
                'SoLuong' => 'required|array',
                'GiaThanh' => 'required|array',
                'ThanhTien' => 'required|array',
                'BaoHanh' => 'nullable|array', // BaoHanh có thể không tồn tại nếu không có checkbox nào được chọn
            ]);

            // Tạo phiếu bàn giao nhà cung cấp
            $phieuBanGiaoNCC = new PhieuBanGiaoSuaChuaNCC();
            $phieuBanGiaoNCC->MaPhieuBanGiaoSuaChua = $request->MaLichSuaChua; // Gán MaPhieuBanGiaoNCC bằng MaLichSuaChua
            $phieuBanGiaoNCC->MaLichSuaChua = $request->MaLichSuaChua;
            $phieuBanGiaoNCC->MaNhaCungCap = $request->MaNhaCungCap;
            $phieuBanGiaoNCC->ThoiGianBanGiao = $request->ThoiGianBanGiao;
            $phieuBanGiaoNCC->TongTien = $request->TongTien;
            $phieuBanGiaoNCC->BienPhapXuLy = $request->BienPhapXuLy;
            $phieuBanGiaoNCC->GhiChu = $request->GhiChu;
            $phieuBanGiaoNCC->save();

            // Lưu chi tiết phiếu bàn giao
            foreach ($request->TenLinhKien as $index => $tenLinhKien) {
                ChiTietPhieuSuaNCC::create([
                    'MaPhieuBanGiaoSuaChua' => $phieuBanGiaoNCC->MaLichSuaChua,
                    'TenLinhKien' => $tenLinhKien,
                    'DonViTinh' => $request->DonViTinh[$index],
                    'SoLuong' => $request->SoLuong[$index],
                    'GiaThanh' => $request->GiaThanh[$index],
                    'ThanhTien' => $request->ThanhTien[$index],
                    'BaoHanh' => $request->BaoHanh[$index] == '1' ? 1 : 0,// Kiểm tra nếu checkbox được chọn
                ]);
            }

            // Cập nhật trạng thái của lịch sửa chữa
            $lichSuaChua = LichSuaChua::findOrFail($request->MaLichSuaChua);
            $lichSuaChua->TrangThai = 2; // Cập nhật trạng thái
            $lichSuaChua->save();

            return redirect()->route('lichsuachua.dahoanthanh')->with('success', 'Phiếu bàn giao nhà cung cấp đã được tạo thành công!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator) // <== THÊM DÒNG NÀY để gửi lỗi validation
                ->withInput()
                ->with('error', 'Tên linh kiện và đơn vị tính không được nhập kí tự đặc biệt và số!');
        }
    }
    public function exportPDF($MaPhieuBanGiaoNoiBo)
    {
        // Lấy phiếu bàn giao
        $phieuBanGiaoNoiBo = PhieuBanGiaoNoiBo::with('chiTietPhieuBanGiaoNoiBo.LinhKienSuaChua')->findOrFail($MaPhieuBanGiaoNoiBo);

        // Xuất PDF logic ở đây
        $pdf = PDF::loadView('vPhieuBanGiao.export', compact('phieuBanGiaoNoiBo'));

        return $pdf->stream('phieu_ban_giao_noi_bo_' . $MaPhieuBanGiaoNoiBo . '.pdf');

    }
    public function exportPDF1($MaPhieuBanGiaoSuaChua)
    {
        // Lấy thông tin phiếu bàn giao từ cơ sở dữ liệu theo MaPhieuBanGiaoSuaChua
        $phieuBanGiao = PhieuBanGiaoSuaChuaNCC::with(['yeuCauSuaChua', 'nhaCungCap', 'chiTietPhieuBanGiaoSuaChuaNCC'])
            ->where('MaPhieuBanGiaoSuaChua', $MaPhieuBanGiaoSuaChua)
            ->firstOrFail();

        // Truyền dữ liệu sang view PDF
        $pdf = PDF::loadView('vPhieuBanGiao.export1', ['phieuBanGiao' => $phieuBanGiao]);

        // Trả về PDF cho người dùng tải về
        return $pdf->stream('phieu_ban_giao_' . $MaPhieuBanGiaoSuaChua . '.pdf');
    }

    public function storeBT(Request $request)
    {
        try {
            $request->validate([
                'MaLichBaoTri' => 'required|exists:lichbaotri,MaLichBaoTri',
                'MaNhanVien' => 'required|exists:nhanvien,MaNhanVien',
                'TongTien' => 'required|numeric|min:0',
                'ThoiGianBanGiao' => 'required|date',
                'LuuY' => 'nullable|string|max:255',
                'TenLinhKien' => ['required', 'array'],
                'TenLinhKien.*' => ['required', 'regex:/^[\pL\s]+$/u'],

                'DonViTinh' => ['required', 'array'],
                'DonViTinh.*' => ['required', 'regex:/^[\pL\s]+$/u'],

                'SoLuong' => ['required', 'array'],


                'GiaThanh' => ['required', 'array'],

                'BaoHanh' => 'nullable|array', // BaoHanh có thể không tồn tại nếu không có checkbox nào được chọn
            ]);


            // Tạo phiếu bàn giao bảo trì
            $phieuBanGiaoBaoTri = new PhieuBanGiaoBaoTri();
            $phieuBanGiaoBaoTri->MaPhieuBanGiaoBaoTri = $request->MaLichBaoTri; // Gán MaPhieuBanGiaoBaoTri bằng MaLichBaoTri
            $phieuBanGiaoBaoTri->MaNhanVien = $request->MaNhanVien;
            $phieuBanGiaoBaoTri->MaLichBaoTri = $request->MaLichBaoTri;
            $phieuBanGiaoBaoTri->ThoiGianBanGiao = $request->ThoiGianBanGiao;
            $phieuBanGiaoBaoTri->TongTien = $request->TongTien;
            $phieuBanGiaoBaoTri->LuuY = $request->LuuY;
            $phieuBanGiaoBaoTri->save();

            // Lưu chi tiết phiếu bàn giao
            foreach ($request->TenLinhKien as $index => $tenLinhKien) {
                ChiTietPhieuBanGiaoBaoTri::create([
                    'MaPhieuBanGiaoBaoTri' => $phieuBanGiaoBaoTri->MaLichBaoTri,
                    'TenLinhKien' => $tenLinhKien,
                    'DonViTinh' => $request->DonViTinh[$index],
                    'SoLuong' => $request->SoLuong[$index],
                    'GiaThanh' => $request->GiaThanh[$index],
                    'BaoHanh' => $request->BaoHanh[$index] == '1' ? 1 : 0, // Kiểm tra nếu checkbox được chọn
                ]);
            }
            $lichBaoTri = LichBaoTri::findOrFail($request->MaLichBaoTri);
            $lichBaoTri->TrangThai = 1; // Cập nhật trạng thái
            $lichBaoTri->save();

            return redirect()->route('lichbaotri.dabangiao')->with('success', 'Phiếu bàn giao bảo trì được tạo thành công!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator) // <== THÊM DÒNG NÀY để gửi lỗi validation
                ->withInput()
                ->with('error', 'Tên linh kiện và đơn vị tính không được nhập kí tự đặc biệt và số!');
        }
    }
    public function exportPDF2($MaPhieuBanGiaoBaoTri)
    {
        $phieuBanGiao = PhieuBanGiaoBaoTri::with(['lichBaoTri', 'nhanVien', 'chiTietPhieuBanGiaoBaoTri'])
            ->where('MaPhieuBanGiaoBaoTri', $MaPhieuBanGiaoBaoTri)
            ->firstOrFail();

        $pdf = PDF::loadView('vPhieuBanGiao.exportBT', ['phieuBanGiao' => $phieuBanGiao]);

        return $pdf->stream('phieu_ban_giao_' . $MaPhieuBanGiaoBaoTri . '.pdf');
    }

}
