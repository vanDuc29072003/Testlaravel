<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Phiếu Bàn Giao Nội Bộ</title>
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
    <div class="header">
        <h2>PHIẾU BÀN GIAO NỘI BỘ</h2>
    </div>

    <p><strong>Mã Yêu Cầu Sửa Chữa:</strong> {{ $phieuBanGiaoNoiBo->lichSuaChua->yeuCauSuaChua->MaYeuCauSuaChua }}</p>
    <p><strong>Mã Lịch Sửa Chữa:</strong> {{ $phieuBanGiaoNoiBo->lichSuaChua->MaLichSuaChua }}</p>
    <p><strong>Mã Phiếu Bàn Giao:</strong> {{ $phieuBanGiaoNoiBo->MaPhieuBanGiaoNoiBo }}</p>
    <p><strong>Máy cần sửa chữa:</strong> {{ $phieuBanGiaoNoiBo->lichSuaChua->yeuCauSuaChua->may->TenMay }}</p>
    <p><strong>Thời Gian Yêu Cầu:</strong> {{ \Carbon\Carbon::parse($phieuBanGiaoNoiBo->lichSuaChua->yeuCauSuaChua->ThoiGianYeuCau)->format('H:i d/m/Y') }}</p>
    <p><strong>Thời Gian Bàn Giao:</strong> {{ \Carbon\Carbon::parse($phieuBanGiaoNoiBo->ThoiGianBanGiao)->format('H:i d/m/Y') }}</p>
    <p><strong>Nhân Viên Yêu Cầu:</strong> {{ $phieuBanGiaoNoiBo->lichSuaChua->yeuCauSuaChua->nhanVien->TenNhanVien }}</p>
    <p><strong>Nhân Viên Kỹ Thuật:</strong> {{ $phieuBanGiaoNoiBo->lichSuaChua->nhanVienKyThuat->TenNhanVien }}</p>
    <p><strong>Biện Pháp Xử Lý:</strong> {{ $phieuBanGiaoNoiBo->BienPhapXuLy ?? 'Không có' }}</p>
    <p><strong>Ghi Chú:</strong> {{ $phieuBanGiaoNoiBo->GhiChu ?? 'Không có' }}</p>

    <div class="section-title">Thông Tin Linh Kiện Sửa Chữa</div>

    <table>
        <thead>
            <tr>
                <th>Mã Linh Kiện</th>
                <th>Tên Linh Kiện</th>
                <th>Đơn Vị Tính</th>
                <th>Số Lượng</th>
            </tr>
        </thead>
        <tbody>
            @foreach($phieuBanGiaoNoiBo->chiTietPhieuBanGiaoNoiBo as $chiTiet)
                <tr>
                    <td>{{ $chiTiet->LinhKienSuaChua->MaLinhKien }}</td>
                    <td>{{ $chiTiet->LinhKienSuaChua->TenLinhKien }}</td>
                    <td>{{ $chiTiet->LinhKienSuaChua->donViTinh->TenDonViTinh }}</td>
                    <td>{{ $chiTiet->SoLuong }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 50px; text-align: right;">
        <p><strong>Ngày xuất phiếu:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
    </div>
</body>
</html>
