<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phiếu Thanh Lý</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 20px;
            margin: 0;
        }
        .header p {
            margin: 5px 0;
        }
        .info {
            margin-bottom: 20px;
        }
        .info p {
            margin: 5px 0;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
        .signature {
            margin-top: 50px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>PHIẾU THANH LÝ</h1>
        <p>Mã phiếu: <strong>{{ $phieuThanhLy->MaPhieuThanhLy }}</strong></p>
    </div>

    <div class="info">
        <p><strong>Ngày lập phiếu:</strong> {{ \Carbon\Carbon::parse($phieuThanhLy->NgayLapPhieu)->format('d/m/Y') }}</p>
        <p><strong>Người lập phiếu:</strong> {{ $phieuThanhLy->nhanVien->TenNhanVien ?? 'Không xác định' }}</p>
        <p><strong>Máy thanh lý:</strong> {{ $phieuThanhLy->may->TenMay ?? 'Không xác định' }}</p>
        <p><strong>Số Seri:</strong> {{ $phieuThanhLy->may->SeriMay ?? 'Không xác định' }}</p>
        <p><strong>Loại máy:</strong> {{ $phieuThanhLy->may->loaiMay->TenLoai ?? 'Không xác định' }}</p>
        <p><strong>Nhà cung cấp:</strong> {{ $phieuThanhLy->may->nhaCungCap->TenNhaCungCap ?? 'Không xác định' }}</p>
        <p><strong>Giá trị ban đầu:</strong> {{ number_format($phieuThanhLy->GiaTriBanDau, 0, ',', '.') }} VND</p>
        <p><strong>Giá trị còn lại:</strong> {{ number_format($phieuThanhLy->GiaTriConLai, 0, ',', '.') }} VND</p>
        <p><strong>Trạng thái:</strong> 
            @if ($phieuThanhLy->TrangThai == '0')
                Chưa duyệt
            @elseif ($phieuThanhLy->TrangThai == '1')
                Đã duyệt
            @else
                Đã từ chối
            @endif
        </p>
        <p><strong>Năm sản xuất:</strong> {{ $phieuThanhLy->may->NamSanXuat ?? 'Không xác định' }}</p>
        <p><strong>Đánh giá:</strong> {{ $phieuThanhLy->DanhGia }}</p>
        <p><strong>Ghi chú:</strong> {{ $phieuThanhLy->GhiChu }}</p>
    </div>

    <div class="footer">
        <p>Ngày in: {{ now()->format('d/m/Y') }}</p>
        <div class="signature">
            <p><strong>Người lập phiếu</strong></p>
            <p>(Ký và ghi rõ họ tên)</p>
        </div>
    </div>
</body>
</html>