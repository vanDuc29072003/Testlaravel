<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Báo Cáo Thống Kê Kho</title>
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
        .title h3, .title em {
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
        .thongke-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .thongke-table th, .thongke-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
        .thongke-table th {
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
            margin-top: 80px;
            text-align: center;
            border: none;
        }
        .signature-table td {
            width: 50%;
        }
        .text-left {
            text-align: left;
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
        <h3>BÁO CÁO THỐNG KÊ KHO</h3>
        <em>{{ $startDate }} - {{ $endDate }}</em>
    </div>

    <h4>I, Thông tin chung</h4>
    <table class="info-table">
        <tr>
            <td class="label">Khoảng thời gian:</td>
            <td>{{ $startDate }} - {{ $endDate }}</td>
        </tr>
        <tr>
            <td class="label">Ngày lập:</td>
            <td>{{ $ngayLap }}</td>
        </tr>
        <tr>
            <td class="label">Người tạo:</td>
            <td>{{ $nguoiTao }}</td>
        </tr>
    </table>

    <h4>II, Thống kê hàng hóa</h4>
    <table class="thongke-table">
        <thead>
            <tr>
                <th>STT</th>
                <th>Mã hàng</th>
                <th>Tên hàng</th>
                <th>ĐVT</th>
                <th>Nhập</th>
                <th>Xuất</th>
                <th>Trả kho</th>
                <th>Bàn giao</th>
                <th>Chênh lệch</th>
                <th>Tồn kho</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($thongKe as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item['MaHang'] }}</td>
                    <td class="text-left">{{ $item['TenHang'] }}</td>
                    <td>{{ $item['DVT'] }}</td>
                    <td>{{ $item['TongNhap'] }}</td>
                    <td>{{ $item['TongXuat'] }}</td>
                    <td>{{ $item['TongTraKho'] }}</td>
                    <td>{{ $item['TongBanGiao'] }}</td>
                    <td>{{ $item['ChenhLech'] }}</td>
                    <td>{{ $item['TonKho'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>III, Ghi chú</h4>
    <p class="note">
        Báo cáo này được lập dựa trên số liệu thực tế trong khoảng thời gian đã chọn.<br>
        Tôi xin cam đoan rằng các thông tin nêu trên là đầy đủ và chính xác, và chịu trách nhiệm về tính xác thực của nội dung trong báo cáo này.
    </p>

    <table class="signature-table">
        <tr>
            <td></td>
            <td>NGƯỜI LẬP BÁO CÁO</td>
        </tr>
    </table>
</body>
</html>