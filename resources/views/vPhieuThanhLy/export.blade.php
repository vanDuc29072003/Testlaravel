<style>
    body {
        font-family: 'DejaVu Sans', sans-serif;
        font-size: 12px;
        margin: 20px;
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
    <h3>PHIẾU THANH LÝ</h3>
    <em>Mã Phiếu: {{ $phieuThanhLy->MaHienThi }}
        ({{ \Carbon\Carbon::parse($phieuThanhLy->NgayLapPhieu)->format('d/m/Y') }})</em>
</div>

<h4>I, Thông tin chung</h4>

<table class="info-table">
    <tr>
        <td class="label">Ngày lập phiếu:</td>
        <td>{{ \Carbon\Carbon::parse($phieuThanhLy->NgayLapPhieu)->format('H:i d/m/Y') }}</td>
    </tr>
    <tr>
        <td class="label">Người lập phiếu:</td>
        <td>{{ $phieuThanhLy->nhanVien->TenNhanVien ?? 'Không xác định' }}</td>
    </tr>
</table>

<h4>II, Thông tin máy móc cần thanh lý</h4>

<table class="info-table">
    <tr>
        <td class="label">Tên máy:</td>
        <td>{{ $phieuThanhLy->may->TenMay ?? 'Không xác định' }}</td>
    </tr>
    <tr>
        <td class="label">Mã máy:</td>
        <td>{{ $phieuThanhLy->may->MaMay ?? 'Không xác định' }}</td>
    </tr>
    <tr>
        <td class="label">Loại máy:</td>
        <td>{{ $phieuThanhLy->may->loaiMay->TenLoai ?? 'Không xác định' }}</td>
    </tr>
    <tr>
        <td class="label">Nhà cung cấp:</td>
        <td>{{ $phieuThanhLy->may->nhaCungCap->TenNhaCungCap ?? 'Không xác định' }}</td>
    </tr>
    <tr>
        <td class="label">Năm sản xuất:</td>
        <td>{{ $phieuThanhLy->may->NamSanXuat ?? 'Không xác định' }}</td>
    </tr>
    <tr>
        <td class="label">Ngày nhập:</td>
        <td>{{ $phieuThanhLy->may->ThoiGianDuaVaoSuDung ? \Carbon\Carbon::parse($phieuThanhLy->may->ThoiGianDuaVaoSuDung)->format('d/m/Y') : 'Không xác định' }}</td>
    </tr>
    <tr>
        <td class="label">Thời gian bảo hành:</td>
        <td>{{ $phieuThanhLy->may->ThoiGianBaoHanh ?? 'Không xác định' }} năm</td>
    </tr>
    <tr>
        <td class="label">Thời gian khấu hao:</td>
        <td>{{ $phieuThanhLy->may->ThoiGianKhauHao ?? 'Không xác định' }} tháng</td>
    </tr>
    <tr>
        <td class="label">Giá trị ban đầu:</td>
        <td>{{ number_format($phieuThanhLy->GiaTriBanDau, 0, ',', '.') }} VND</td>
    </tr>
    <tr>
        <td class="label">Giá trị còn lại:</td>
        <td>{{ number_format($phieuThanhLy->GiaTriConLai, 0, ',', '.') }} VND</td>
    </tr>
</table>

<h4>III, Ý kiến của bộ phận sử dụng</h4>

<p class="danhgia"><strong>Đánh giá: </strong>{{ $phieuThanhLy->DanhGia }}</p>

<h4>IV, Kết luận của hội đồng thanh lý</h4>

<p class="danhgia"><strong>Kết luận: </strong>
    @if ($phieuThanhLy->TrangThai == '0')
        Phiếu thanh lý hiện đang được xem xét và chờ phê duyệt từ cấp có thẩm quyền.
    @elseif ($phieuThanhLy->TrangThai == '1')
        Tài sản nêu trên được phê duyệt thanh lý theo quy định hiện hành.
    @else
        Yêu cầu thanh lý tài sản nêu trên không được phê duyệt.
    @endif
</p>
<p class="danhgia"><strong>Ghi chú: </strong>{{ $phieuThanhLy->GhiChu ?? '...........................................................................................................................................................' }}

<p class="note">Thông tin trên phiếu thanh lý này đã được kiểm tra, xác nhận và phản ánh đúng thực tế. Chúng tôi hoàn toàn chịu trách nhiệm về tính chính xác và trung thực của các nội dung đã kê khai.</p>

<table class="signature-table">
    <tr>
        <td>NGƯỜI LẬP PHIẾU</td>
        <td>XÁC NHẬN TỪ BAN QUẢN LÝ</td>
    </tr>
</table>