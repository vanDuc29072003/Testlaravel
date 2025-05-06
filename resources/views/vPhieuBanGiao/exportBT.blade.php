<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phiếu Bàn Giao Bảo Trì</title>
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
        <div class="card">
            <div class="card-header">
                Phiếu Bàn Giao Bảo Trì
            </div>
            <div class="card-body">
                <p><strong>Mã Lịch Bảo Trì:</strong> {{ $phieuBanGiao->lichBaoTri->MaLichBaoTri }}</p>
                <p><strong>Mã Phiếu Bàn Giao:</strong> {{ $phieuBanGiao->MaPhieuBanGiaoBaoTri }}</p>
                <p><strong>Ngày Bảo Trì:</strong> {{ \Carbon\Carbon::parse($phieuBanGiao->lichBaoTri->NgayBaoTri)->format('d/m/Y') }}</p>
                <p><strong>Thời Gian Bàn Giao:</strong> {{ \Carbon\Carbon::parse($phieuBanGiao->ThoiGianBanGiao)->format('d/m/Y H:i') }}</p>
                <p><strong>Máy:</strong> {{ $phieuBanGiao->lichBaoTri->may->TenMay }}</p>
                <p><strong>Nhà Cung Cấp:</strong> {{ $phieuBanGiao->lichBaoTri->may->nhaCungCap->TenNhaCungCap ?? 'Không có' }}</p>
                <p><strong>Địa Chỉ Nhà Cung Cấp:</strong> {{ $phieuBanGiao->lichBaoTri->may->nhaCungCap->DiaChi ?? 'Không có' }}</p>
                <p><strong>Số Điện Thoại:</strong> {{ $phieuBanGiao->lichBaoTri->may->nhaCungCap->SoDienThoai ?? 'Không có' }}</p>
                <p><strong>Email:</strong> {{ $phieuBanGiao->lichBaoTri->may->nhaCungCap->Email ?? 'Không có' }}</p>
                <p><strong>Nhân Viên Xác Nhận:</strong> {{ $phieuBanGiao->nhanVien->TenNhanVien ?? 'Không có' }}</p>
                <p><strong>Ghi Chú:</strong> {{ $phieuBanGiao->GhiChu ?? 'Không có' }}</p>

                <h5>Thông Tin Linh Kiện Bàn Giao</h5>
                <table class="table">
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
                        @foreach ($phieuBanGiao->chiTietPhieuBanGiaoBaoTri as $chiTiet)
                            <tr>
                                <td>{{ $chiTiet->TenLinhKien }}</td>
                                <td>{{ $chiTiet->DonViTinh }}</td>
                                <td>{{ $chiTiet->SoLuong }}</td>
                                <td>
                                    <input type="checkbox" {{ $chiTiet->BaoHanh == 1 ? 'checked' : '' }} disabled>
                                </td>
                                <td>{{ number_format($chiTiet->GiaThanh, 0, ',', '.') }} đ</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <p><strong>Tổng tiền phải thanh toán:</strong> {{ number_format($phieuBanGiao->TongTien, 0, ',', '.') }} đ</p>
            </div>
        </div>
        <div style="margin-top: 50px; text-align: right;">
            <p><strong>Ngày xuất phiếu:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
        </div>
    </div>
</body>
</html>
