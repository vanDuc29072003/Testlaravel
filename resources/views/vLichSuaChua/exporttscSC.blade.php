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
        font-size: 12px;
        font-style: italic;
        margin-top: 20px;
    }

    .signature-table {
        width: 100%;
        font-weight: bold;
        text-align: center;
        border: none;
        margin-top: 50px;
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
    <h3>PHIẾU BÀN GIAO TIỀN SỬA CHỮA</h3>
    <em>Mã Phiếu: {{ $lichSuaChua->MaLichSuaChua }} ({{ \Carbon\Carbon::parse($lichSuaChua->yeuCauSuaChua->ThoiGianYeuCau )->format('d/m/Y') }})</em>
</div>

<h4>I, Thông tin nhà cung cấp</h4>

<table class="info-table">
    <tr>
        <td class="label">Nhà Cung Cấp:</td>
        <td>{{ $lichSuaChua->yeuCauSuaChua->may->nhaCungCap->TenNhaCungCap }}</td>
    </tr>
    <tr>
        <td class="label">Mã Số Thuế:</td>
        <td>{{ $lichSuaChua->yeuCauSuaChua->may->nhaCungCap->MaSoThue ?? 'Không có' }}</td>
    </tr>
    <tr>
        <td class="label">Địa Chỉ:</td>
        <td>{{ $lichSuaChua->yeuCauSuaChua->may->nhaCungCap->DiaChi ?? 'Không có' }}</td>
    </tr>
    <tr>
        <td class="label">SĐT:</td>
        <td>{{ $lichSuaChua->yeuCauSuaChua->may->nhaCungCap->SoDienThoai ?? 'Không có' }}</td>
    </tr>
    <tr>
        <td class="label">Email:</td>
        <td>{{ $lichSuaChua->yeuCauSuaChua->may->nhaCungCap->Email ?? 'Không có' }}</td>
    </tr>
</table>

<h4>II, Thông tin bàn giao</h4>

<table class="info-table">
    <tr>
        <td class="label">Tên Máy:</td>
        <td>{{ $lichSuaChua->yeuCauSuaChua->may->TenMay }}</td>
    </tr>
    <tr>
        <td class="label">Seri Máy:</td>
        <td>{{ $lichSuaChua->yeuCauSuaChua->may->SeriMay }}</td>
    </tr>
    <tr>
        <td class="label">Ngày Nhập:</td>
        <td>{{ \Carbon\Carbon::parse($lichSuaChua->yeuCauSuaChua->may->ThoiGianDuaVaoSuDung)->format('d/m/Y') }}</td>
    </tr>
    <tr>
        <td class="label">Thời Gian Bảo Hành:</td>
        <td>{{ $lichSuaChua->yeuCauSuaChua->may->ThoiGianBaoHanh }} tháng</td>
    </tr>
    <tr>
        <td class="label">Tình Trạng:</td>
        <td>{{ $lichSuaChua->yeuCauSuaChua->MoTa }}</td>
    </tr>
</table>

<p class="note">
    <strong>Ghi chú:</strong><br>
    - Thiết bị được bàn giao đúng nguyên trạng như thông tin mô tả tại Mục II của phiếu này.<br>
    - Bên nhận (nhà cung cấp) có trách nhiệm kiểm tra, xác nhận tình trạng thiết bị trước khi tiến hành sửa chữa.<br>
    - Mọi thay đổi về nội dung sửa chữa, linh kiện thay thế hoặc can thiệp kỹ thuật khác đều phải có sự xác nhận của bên giao.<br>
    - Trong trường hợp phát hiện lỗi khác ngoài phạm vi ban đầu, bên nhận phải thông báo kịp thời để hai bên thống nhất phương án xử lý.<br>
    - Bên nhận cam kết không sử dụng thiết bị vào mục đích khác ngoài phạm vi sửa chữa, đồng thời bảo quản nguyên vẹn trong suốt quá trình tiếp nhận.<br>
    - Phiếu này được lập thành 02 bản, mỗi bên giữ 01 bản và có giá trị pháp lý như nhau để làm căn cứ kiểm tra, đối chiếu khi cần thiết.
</p>


<table class="signature-table">
    <tr>
        <td>BÊN GIAO</td>
        <td>BÊN NHẬN (NHÀ CUNG CẤP)</td>
    </tr>
</table>
