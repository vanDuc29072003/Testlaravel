<style>
    body {
        font-family: 'DejaVu Sans', sans-serif;
        margin: 20px;
        font-size: 12px;
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

    .thanhtien {
        text-align: right;
    }

    .danhgia {
        margin-left: 5px;
    }

    .note {
        margin-top: 30px;
        font-size: 12px;
        font-style: italic;
    }

    .signature-table {
        width: 100%;
        font-weight: bold;
        margin-top: 20px;
        text-align: center;
        border: none;
    }

    .signature-table td {
        width: 50%;
    }

    .linhkien-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .linhkien-table th, .linhkien-table td {
        border: 1px solid #000;
        padding: 8px;
        text-align: left;
    }

    .linhkien-table th {
        background-color: #f2f2f2;
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
    <h3>PHIẾU BÀN GIAO SỬA CHỮA NHÀ CUNG CẤP</h3>
    <em>Mã Phiếu: {{ $phieuBanGiao->MaPhieuBanGiaoSuaChua }} ({{ \Carbon\Carbon::parse($phieuBanGiao->ThoiGianBanGiao)->format('d/m/Y') }})</em>
</div>

<h4>I, Thông tin bàn giao</h4>

<table class="info-table">
        <tr>
        <td class="label">Nhân Viên Yêu Cầu:</td>
        <td>{{ $phieuBanGiao->lichSuaChua->yeuCauSuaChua->nhanVien->TenNhanVien }}</td>
    </tr>
    <tr>
        <td class="label">Thời Gian Yêu Cầu:</td>
        <td>{{ \Carbon\Carbon::parse($phieuBanGiao->lichSuaChua->yeuCauSuaChua->ThoiGianYeuCau)->format('H:i d/m/Y') }}
        </td>
    </tr>
    <tr>
        <td class="label">Mã máy:</td>
        <td>{{ $phieuBanGiao->lichSuaChua->yeuCauSuaChua->may->MaMay }}</td>   
    </tr>
    <tr>
        <td class="label">Tên Máy:</td>
        <td>{{ $phieuBanGiao->lichSuaChua->yeuCauSuaChua->may->TenMay }}</td>
    </tr>
    <tr>
        <td class="label">Seri Máy:</td>
        <td>{{ $phieuBanGiao->lichSuaChua->yeuCauSuaChua->may->SeriMay }}</td>
    </tr>
    <tr>
        <td class="label">Tình Trạng:</td>
        <td>{{ $phieuBanGiao->lichSuaChua->yeuCauSuaChua->MoTa }}</td>
    </tr>
</table>

<h4>II, Thông tin nhà cung cấp</h4>

<table class="info-table">
    <tr>
        <td class="label">Nhà Cung Cấp:</td>
        <td>{{ $phieuBanGiao->nhaCungCap->TenNhaCungCap }}</td>
    </tr>
    <tr>
        <td class="label">Địa Chỉ:</td>
        <td>{{ $phieuBanGiao->nhaCungCap->DiaChi ?? 'Không có' }}</td>
    </tr>
    <tr>
        <td class="label">SĐT:</td>
        <td>{{ $phieuBanGiao->nhaCungCap->SoDienThoai ?? 'Không có' }}</td>
    </tr>
    <tr>
        <td class="label">Email:</td>
        <td>{{ $phieuBanGiao->nhaCungCap->Email ?? 'Không có' }}</td>
    </tr>
</table>

<h4>III, Nội dung bàn giao</h4>

<p class="danhgia"><strong>Biện pháp xử lý:</strong> {{ $phieuBanGiao->BienPhapXuLy ?? 'Không có' }}</p>

<h4>IV, Linh kiện bàn giao</h4>

<table class="linhkien-table">
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
                <td><input type="checkbox" {{ $chiTiet->BaoHanh == 1 ? 'checked' : '' }} disabled></td>
                <td>{{ number_format($chiTiet->GiaThanh, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<p class="thanhtien"><strong>THÀNH TIỀN:</strong> {{ number_format($phieuBanGiao->TongTien ?? 0, 0, ',', '.') }} VND</p>

<p class="danhgia"><strong>Ghi chú:</strong> {{ $phieuBanGiao->GhiChu ?? '...........................................................................................................................................................' }}</p>

<p class="note">
    Thông tin trên phiếu bàn giao đã được xác nhận giữa các bên và là căn cứ để tiến hành sửa chữa hoặc thanh toán theo hợp đồng dịch vụ.
</p>

<table class="signature-table">
    <tr>
        <td>NGƯỜI BÀN GIAO</td>
        <td>ĐẠI DIỆN NHÀ CUNG CẤP</td>
    </tr>
</table>
