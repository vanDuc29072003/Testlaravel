<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phiếu Bàn Giao Nhà Cung Cấp</title>
    <style>
         body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 20px; }
        .section-title { margin-top: 20px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="title">Thông Tin Phiếu Bàn Giao Nhà Cung Cấp</h2>

        <p><strong>Mã Phiếu Bàn Giao:</strong> {{ $phieuBanGiao->MaPhieuBanGiaoSuaChua }}</p>
        <p><strong>Mã Yêu Cầu Sửa Chữa:</strong> {{ $phieuBanGiao->yeuCauSuaChua->MaYeuCauSuaChua }}</p>
        <p><strong>Mã Lịch Sửa Chữa:</strong> {{ $phieuBanGiao->lichSuaChua->MaLichSuaChua }}</p>
        <p><strong><strong>Thời Gian Yêu Cầu:</strong> {{ \Carbon\Carbon::parse($phieuBanGiao->lichSuaChua->yeuCauSuaChua->ThoiGianYeuCau)->format('H:i d/m/Y') }}</p>
        <p><strong>Thời Gian Bàn Giao:</strong> {{ \Carbon\Carbon::parse($phieuBanGiao->ThoiGianBanGiao)->format('H:i d/m/Y') }}</p>
        <p><strong>Nhân Viên Yêu Cầu:</strong> {{ $phieuBanGiao->lichSuaChua->yeuCauSuaChua->nhanVien->TenNhanVien }}</p>
        <p><strong>Nhân Viên Kỹ Thuật:</strong> {{ $phieuBanGiao->lichSuaChua->nhanVienKyThuat->TenNhanVien }}</p>
        <p><strong>Máy Cần Sửa Chữa:</strong> {{ $phieuBanGiao->yeuCauSuaChua->may->TenMay }}</p>
        <p><strong>Nhà Cung Cấp:</strong> {{ $phieuBanGiao->nhaCungCap->TenNhaCungCap }}</p>
        <p><strong>Địa Chỉ Nhà Cung Cấp:</strong> {{ $phieuBanGiao->nhaCungCap->DiaChi ?? 'Không có' }}</p>
        <p><strong>Số Điện Thoại:</strong> {{ $phieuBanGiao->nhaCungCap->SoDienThoai ?? 'Không có' }}</p>
        <p><strong>Email:</strong> {{ $phieuBanGiao->nhaCungCap->Email ?? 'Không có' }}</p>

        <p><strong>Biện Pháp Xử Lý:</strong> {{ $phieuBanGiao->BienPhapXuLy ?? 'Không có' }}</p>
        <p><strong>Ghi Chú:</strong> {{ $phieuBanGiao->GhiChu ?? 'Không có' }}</p>

        <h3 class="section-title">Thông Tin Linh Kiện Bàn Giao</h3>
        <table class="info-table">
            <thead>
                <tr>
                    <th>Tên Linh Kiện</th>
                    <th>Đơn Vị Tính</th>
                    <th>Số Lượng</th>
                    <th>Bảo Hành</th>
                    <th>Giá Thành</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($phieuBanGiao->chiTietPhieuBanGiaoSuaChuaNCC as $chiTiet)
                    <tr>
                        <td>{{ $chiTiet->TenLinhKien }}</td>
                        <td>{{ $chiTiet->DonViTinh }}</td>
                        <td>{{ $chiTiet->SoLuong }}</td>
                        <td>
                            <input type="checkbox" {{ $chiTiet->BaoHanh == 1 ? 'checked' : '' }} disabled>
                        </td>
                        <td>{{ number_format($chiTiet->GiaThanh, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p><strong>Tổng tiền phải thanh toán:</strong> {{ number_format($phieuBanGiao->TongTien ?? 0, 0, ',', '.') }}</p>
        
        
    </div>
    <div style="margin-top: 50px; text-align: right;">
        <p><strong>Ngày xuất phiếu:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
    </div>
</body>
</html>
