<style>
    body {
        font-family: 'DejaVu Sans', sans-serif;
        margin: 20px;
        font-size: 14px;
    }

    .header-table {
        width: 100%;
        border: none;
    }

    .header-table td.logo-cell {
        width: 100px;
    }

    .header-table img.logo {
        max-width: 100px;
        height: auto;
    }

    .company-info {
        text-align: right;
        font-size: 14px;
    }

    .title {
        text-align: center;
        margin: 20px 0;
    }

    .title h3,
    .title em {
        margin: 0;
    }

    .info-table {
        width: 100%;
        border-collapse: collapse;
    }

    .info-table td {
        padding: 5px;
        vertical-align: top;
    }

    .info-table .label {
        width: 30%;
        font-weight: bold;
    }

    .section {
        margin-top: 20px;
    }

    .linhkien-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .linhkien-table th,
    .linhkien-table td {
        border: 1px solid #000;
        padding: 8px;
        text-align: center;
    }

    .linhkien-table th {
        background-color: #f2f2f2;
    }

    .note {
        margin-top: 30px;
        font-size: 12px;
        font-style: italic;
    }

    .totals {
        margin-top: 10px;
        text-align: right;
    }

    .signature-table {
        width: 100%;
        font-weight: bold;
        margin-top: 80px;
        text-align: center;
        border: none;
    }

    .signature-table td {
        width: 50%;
    }
</style>

<table class="header-table">
    <tr>
        <td class="logo-cell">
            <img src="{{ public_path('img/logo.png') }}" alt="Logo" class="logo">
        </td>
        <td class="company-info">
            <strong>CÔNG TY TNHH IN TRÙNG KHOA</strong><br>
            Địa chỉ: 28 Nguyễn Chí Thanh, P. Thạch Thang, Q.Hải Châu, TP. Đà Nẵng<br>
            Tel: 0905181687
        </td>
    </tr>
</table>

<div class="title">
    <h3>PHIẾU NHẬP KHO</h3>
    <em>Mã Phiếu: {{ $phieuNhap->MaHienThi }} ({{ \Carbon\Carbon::parse($phieuNhap->NgayNhap)->format('d/m/Y') }})</em>
</div>

<h4>I, Thông tin chung</h4>

<table class="info-table">
    <tr>
        <td class="label">Ngày lập phiếu:</td>
        <td>{{ \Carbon\Carbon::parse($phieuNhap->NgayNhap)->format('H:i d/m/Y') }}</td>
    </tr>
    <tr>
        <td class="label">Người lập phiếu:</td>
        <td>{{ $phieuNhap->nhanVien->TenNhanVien ?? 'Không xác định' }}</td>
    </tr>
    <tr>
        <td class="label">Nhà cung cấp:</td>
        <td>
            {{ $phieuNhap->nhaCungCap->TenNhaCungCap ?? 'Không xác định' }} <br>
            Địa chỉ: {{ $phieuNhap->nhaCungCap->DiaChi ?? 'Không xác định' }} <br>
            SĐT: {{ $phieuNhap->nhaCungCap->SDT ?? 'Không xác định' }} <br>
            Email: {{ $phieuNhap->nhaCungCap->Email ?? 'Không xác định' }}
        </td>
    </tr>
</table>

<h4>II, Danh sách hàng hoá</h4>

<table class="linhkien-table">
    <thead>
        <tr>
            <th>STT</th>
            <th>Mã linh kiện</th>
            <th>Tên linh kiện</th>
            <th>ĐVT</th>
            <th>Số lượng</th>
            <th>Giá nhập</th>
            <th>Thành tiền</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($phieuNhap->chiTietPhieuNhap as $index => $chiTiet)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $chiTiet->linhKien->MaLinhKien }}</td>
                <td>{{ $chiTiet->linhKien->TenLinhKien }}</td>
                <td>{{ $chiTiet->linhKien->donViTinh->TenDonViTinh ?? 'Không xác định' }}</td>
                <td>{{ $chiTiet->SoLuong }}</td>
                <td>{{ number_format($chiTiet->GiaNhap, 0, ',', '.') }}</td>
                <td>{{ number_format($chiTiet->TongCong, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="totals">
    <p><strong>TỔNG CỘNG:</strong> {{ number_format($phieuNhap->TongTien, 0, ',', '.') }} VND</p>
</div>

<h4>III, Ghi chú</h4>

<p><em>Ghi chú:</em> {{ $phieuNhap->GhiChu ?? 'Không có ghi chú' }}</p>

<p class="note">
    Tôi xin cam đoan rằng các thông tin nêu trên là đầy đủ và chính xác, và chịu trách nhiệm về tính xác thực của nội dung trong phiếu nhập kho này.
</p>

<table class="signature-table">
    <tr>
        <td>NHÀ CUNG CẤP</td>
        <td>NHÂN VIÊN KHO</td>
    </tr>
</table>
