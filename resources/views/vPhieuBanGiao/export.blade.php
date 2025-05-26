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
        text-align: left;
    }

    .linhkien-table th {
        background-color: #f2f2f2;
    }

    .note {
        margin-top: 30px;
        font-size: 12px;
        font-style: italic;
    }

    .signature-table {
        width: 100%;
        font-weight: bold;
        margin-top: 30px;
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
    <h3>PHIẾU BÀN GIAO NỘI BỘ</h3>
    <em>Mã Phiếu: {{ $phieuBanGiaoNoiBo->MaPhieuBanGiaoNoiBo }}
        ({{ \Carbon\Carbon::parse($phieuBanGiaoNoiBo->ThoiGianBanGiao)->format('d/m/Y') }})</em>
</div>

<h4>I, Thông tin yêu cầu sửa chữa</h4>

<table class="info-table">
    <tr>
        <td class="label">Người Lập Phiếu:</td>
        <td>{{ $phieuBanGiaoNoiBo->nhanVienTao->TenNhanVien }}</td>
    </tr>
    <tr>
        <td class="label">Nhân Viên Yêu Cầu:</td>
        <td>{{ $phieuBanGiaoNoiBo->lichSuaChua->yeuCauSuaChua->nhanVien->TenNhanVien ?? 'Không xác định' }}</td>
    </tr>
    <tr>
        <td class="label">Thời Gian Yêu Cầu:</td>
        <td>{{ \Carbon\Carbon::parse($phieuBanGiaoNoiBo->lichSuaChua->yeuCauSuaChua->ThoiGianYeuCau)->format('H:i d/m/Y') }}
        </td>
    </tr>
    <tr>
        <td class="label">Mã máy:</td>
        <td>{{ $phieuBanGiaoNoiBo->lichSuaChua->yeuCauSuaChua->may->MaMay }}</td>   
    </tr>
    <tr>
        <td class="label">Tên Máy:</td>
        <td>{{ $phieuBanGiaoNoiBo->lichSuaChua->yeuCauSuaChua->may->TenMay }}</td>
    </tr>
    <tr>
        <td class="label">Seri Máy:</td>
        <td>{{ $phieuBanGiaoNoiBo->lichSuaChua->yeuCauSuaChua->may->SeriMay }}</td>
    </tr>
    <tr>
        <td class="label">Ngày Nhập:</td>
        <td>{{ \Carbon\Carbon::parse($phieuBanGiaoNoiBo->lichSuaChua->yeuCauSuaChua->may->ThoiGianDuaVaoSuDung)->format('d/m/Y') }}</td>
    </tr>
    <tr>
        <td class="label">Thời Gian Bảo Hành:</td>
        <td>{{ $phieuBanGiaoNoiBo->lichSuaChua->yeuCauSuaChua->may->ThoiGianBaoHanh }} tháng</td>
    </tr>
    <tr>
        <td class="label">Tình Trạng:</td>
        <td>{{ $phieuBanGiaoNoiBo->lichSuaChua->yeuCauSuaChua->MoTa }}</td>
    </tr>
</table>

<h4>II, Thông tin bàn giao thiết bị</h4>

<table class="info-table">
    <tr>
        <td class="label">Nhân Viên Kỹ Thuật:</td>
        <td>{{ $phieuBanGiaoNoiBo->lichSuaChua->nhanVienKyThuat->TenNhanVien }}</td>
    </tr>
    <tr>
        <td class="label">Thời Gian Bàn Giao:</td>
        <td>{{ \Carbon\Carbon::parse($phieuBanGiaoNoiBo->ThoiGianBanGiao)->format('H:i d/m/Y') }}</td>
    </tr>
    <tr>
        <td class="label">Biện Pháp Xử Lý:</td>
        <td>{{ $phieuBanGiaoNoiBo->BienPhapXuLy ?? '.....................................................................................................' }}
        </td>
    </tr>
    <tr>
        <td class="label">Ghi Chú:</td>
        <td>{{ $phieuBanGiaoNoiBo->GhiChu ?? '.....................................................................................................' }}
        </td>
    </tr>
</table>

<h4>III, Linh kiện sử dụng</h4>

<table class="linhkien-table">
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

<p class="note">
    Tôi xin cam đoan rằng các thông tin nêu trên là đầy đủ và chính xác, và chịu trách nhiệm về tính xác thực của nội dung trong phiếu bàn giao này.
</p>

<table class="signature-table">
    <tr>
        <td>NGƯỜI LẬP PHIẾU</td>
        <td>NHÂN VIÊN YÊU CẦU</td>
        <td>NHÂN VIÊN KỸ THUẬT</td>
    </tr>
</table>