<style>
    body {
        font-family: 'DejaVu Sans', sans-serif;
    }
    table {
        font-family: 'DejaVu Sans', sans-serif;
    }
</style>

<h2>PHIẾU NHẬP KHO</h2>
<p><strong>Mã Phiếu Nhập:</strong> {{ $phieuNhap->MaPhieuNhap }}</p>
<p><strong>Nhà Cung Cấp:</strong> {{ $phieuNhap->nhaCungCap->TenNhaCungCap }}</p>
<p><strong>Nhân Viên Nhập (Bộ phận: Kho):</strong> {{ $phieuNhap->nhanVien->TenNhanVien }}</p>
<p><strong>Tổng Số Lượng Nhập:</strong> {{ $phieuNhap->TongSoLuong }}</p>
<p><strong>Ngày Nhập:</strong> {{ \Carbon\Carbon::parse($phieuNhap->NgayNhap)->format('d/m/Y H:i:s') }}</p>

<h3>Danh Sách Linh Kiện</h3>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Mã Linh Kiện</th>
            <th>Tên Linh Kiện</th>
            <th>Đơn Vị Tính</th>
            <th>Số Lượng</th>
            <th>Giá Nhập</th>
            <th>Thành Tiền</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($phieuNhap->chiTietPhieuNhap as $chiTiet)
            <tr>
                <td>{{ $chiTiet->linhKien->MaLinhKien }}</td>
                <td>{{ $chiTiet->linhKien->TenLinhKien }}</td>
                <td>{{ $chiTiet->linhKien->donViTinh->TenDonViTinh ?? 'Không xác định' }}</td>
                <td>{{ $chiTiet->SoLuong }}</td>
                <td>{{ number_format($chiTiet->GiaNhap, 0, ',', '.') }} VND</td>
                <td>{{ number_format($chiTiet->TongCong, 0, ',', '.') }} VND</td>
            </tr>
        @endforeach
    </tbody>
</table>

<p><strong>Tổng Tiền:</strong> {{ number_format($phieuNhap->TongTien, 0, ',', '.') }} VND</p>
<p><strong>Ghi Chú:</strong> {{ $phieuNhap->GhiChu ?? 'Không có ghi chú' }}</p>
<p><strong>Trạng Thái:</strong>
    @if ($phieuNhap->TrangThai == 0)
        <span class="badge bg-warning text-dark">Chờ duyệt</span>
    @elseif ($phieuNhap->TrangThai == 1)
        <span class="badge bg-success text-white">Đã nhập kho</span>
    @endif
</p>