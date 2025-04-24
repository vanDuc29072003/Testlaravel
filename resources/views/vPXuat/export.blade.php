<style>
    body {
        font-family: 'DejaVu Sans', sans-serif;
    }
    table {
        font-family: 'DejaVu Sans', sans-serif;
    }
</style>

<h2>PHIẾU XUẤT KHO</h2>
<p><strong>Mã Phiếu Xuất:</strong> {{ $phieuXuat->MaPhieuXuat }}</p>
<p><strong>Nhân Viên Tạo (Bộ phận: Kho):</strong> {{ $phieuXuat->nhanVienTao->TenNhanVien ?? 'Không xác định' }}</p>
<p><strong>Nhân Viên Nhận (Bộ phận: Kĩ Thuật):</strong> {{ $phieuXuat->nhanVienNhan->TenNhanVien ?? 'Không xác định' }}</p>
<p><strong>Tổng Số Lượng Xuất:</strong> {{ $phieuXuat->TongSoLuong }}</p>
<p><strong>Ngày Xuất:</strong> {{ \Carbon\Carbon::parse($phieuXuat->NgayXuat)->format('d/m/Y H:i:s') }}</p>

<h3>Danh Sách Linh Kiện</h3>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Mã Linh Kiện</th>
            <th>Tên Linh Kiện</th>
            <th>Đơn Vị Tính</th>
            <th>Số Lượng</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($phieuXuat->chiTietPhieuXuat as $chiTiet)
            <tr>
                <td>{{ $chiTiet->linhKien->MaLinhKien }}</td>
                <td>{{ $chiTiet->linhKien->TenLinhKien }}</td>
                <td>{{ $chiTiet->linhKien->donViTinh->TenDonViTinh ?? 'Không xác định' }}</td>
                <td>{{ $chiTiet->SoLuong }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<p><strong>Ghi Chú:</strong> {{ $phieuXuat->GhiChu ?? 'Không có ghi chú' }}</p>