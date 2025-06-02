<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
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
    </style>
</head>
<body>

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
    <h3>PHIẾU BÀN GIAO TRƯỚC BẢO TRÌ</h3>
    <em>Mã Phiếu: {{ $lich->MaLichBaoTri }} ({{ \Carbon\Carbon::parse($lich->NgayBaoTri)->format('d/m/Y') }})</em>
</div>

<h4>I, Thông tin nhà cung cấp</h4>

<table class="info-table">
    <tr>
        <td class="label">Nhà Cung Cấp:</td>
        <td>{{ $lich->may->nhaCungCap->TenNhaCungCap ?? 'Không có' }}</td>
    </tr>
    <tr>
        <td class="label">Mã Số Thuế:</td>
        <td>{{ $lich->may->nhaCungCap->MaSoThue ?? 'Không có' }}</td>
    </tr>
    <tr>
        <td class="label">Địa Chỉ:</td>
        <td>{{ $lich->may->nhaCungCap->DiaChi ?? 'Không có' }}</td>
    </tr>
    <tr>
        <td class="label">SĐT:</td>
        <td>{{ $lich->may->nhaCungCap->SDT ?? 'Không có' }}</td>
    </tr>
    <tr>
        <td class="label">Email:</td>
        <td>{{ $lich->may->nhaCungCap->Email ?? 'Không có' }}</td>
    </tr>
</table>

<h4>II, Thông tin bàn giao</h4>

<table class="info-table">
    <tr>
        <td class="label">Tên Máy:</td>
        <td>{{ $lich->may->TenMay }}</td>
    </tr>
    <tr>
        <td class="label">Seri Máy:</td>
        <td>{{ $lich->may->SeriMay }}</td>
    </tr>
    <tr>
        <td class="label">Ngày Đưa Vào Sử Dụng:</td>
        <td>{{ \Carbon\Carbon::parse($lich->may->ThoiGianDuaVaoSuDung)->format('d/m/Y') }}</td>
    </tr>
    <tr>
        <td class="label">Thời Gian Bảo Hành:</td>
        <td>{{ $lich->may->ThoiGianBaoHanh }} tháng</td>
    </tr>
    <tr>
        <td class="label">Công việc cần làm:</td>
        <td>{{ $lich->MoTa ?? 'Không có mô tả' }}</td>
    </tr>
</table>

<p class="note">
    <strong>Ghi chú:</strong><br>
    - Thiết bị được bàn giao đúng nguyên trạng như thông tin mô tả tại Mục II của phiếu này.<br>
    - Bên nhận (nhà cung cấp) có trách nhiệm kiểm tra, xác nhận tình trạng thiết bị trước khi tiến hành bảo trì.<br>
    - Mọi thay đổi về nội dung bảo trì, linh kiện thay thế hoặc can thiệp kỹ thuật khác đều phải có sự xác nhận của bên giao.<br>
    - Trong trường hợp phát hiện lỗi khác ngoài phạm vi ban đầu, bên nhận phải thông báo kịp thời để hai bên thống nhất phương án xử lý.<br>
    - Bên nhận cam kết không sử dụng thiết bị vào mục đích khác ngoài phạm vi bảo trì, đồng thời bảo quản nguyên vẹn trong suốt quá trình tiếp nhận.<br>
    - Phiếu này được lập thành 02 bản, mỗi bên giữ 01 bản và có giá trị pháp lý như nhau để làm căn cứ kiểm tra, đối chiếu khi cần thiết.
</p>

<table class="signature-table">
    <tr>
        <td>BÊN GIAO</td>
        <td>BÊN NHẬN (NHÀ CUNG CẤP)</td>
    </tr>
</table>

</body>
</html>
