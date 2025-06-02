<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Cảnh Báo Nhập Hàng - PDF</title>
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

        .canhbao-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 13px;
        }

        .canhbao-table th,
        .canhbao-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        .canhbao-table th {
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
        <h3>DANH SÁCH CẢNH BÁO NHẬP HÀNG</h3>
    </div>

    <h4>I, Thông tin chung</h4>
    <table class="info-table">
        <tr>
            <td class="label">Ngày lập:</td>
            <td>{{ $ngayLap }}</td>
        </tr>
        <tr>
            <td class="label">Người xuất:</td>
            <td>{{ $nguoiTao }}</td>
        </tr>
    </table>

    <h4>II, Danh sách cảnh báo</h4>
    <table class="canhbao-table">
        <thead>
            <tr>
                <th>STT</th>
                <th>Mã Linh Kiện</th>
                <th>Tên Linh Kiện</th>
                <th>Đơn Vị Tính</th>
                <th>Số Lượng Tồn</th>
                <th>Cảnh báo cần nhập</th>
            </tr>
        </thead>
        <tbody>
            @forelse($canhBaoList as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item['MaLinhKien'] }}</td>
                    <td>{{ $item['TenLinhKien'] }}</td>
                    <td>{{ $item['DVT'] }}</td>
                    <td>{{ $item['SoLuong'] }}</td>
                    <td>
                        @if($item['MucDo'] === 'danger')
                            Cần nhập gấp
                        @elseif($item['MucDo'] === 'warning')
                            Cần có kế hoạch nhập 
                        @else
                            <!-- Không cảnh báo -->
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6"><i>Không có dữ liệu cảnh báo</i></td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h4>III, Ghi chú</h4>
    <p class="note">
        Báo cáo này được lập dựa trên số liệu tồn kho thực tế tại thời điểm xuất báo cáo.<br>
        Tôi xin cam đoan rằng các thông tin nêu trên là đầy đủ và chính xác, và chịu trách nhiệm về tính xác thực của
        nội dung trong báo cáo này.
    </p>

    <table class="signature-table">
        <tr>
            <td></td>
            <td>NGƯỜI LẬP BÁO CÁO</td>
        </tr>
    </table>
</body>

</html>