<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Cảnh Báo Nhập Hàng - PDF</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        h2 {
            text-align: center;
        }
        p {
            margin: 0 0 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }
        .danger {
            background-color: #f8d7da;
        }
        .warning {
            background-color: #fff3cd;
        }
    </style>
</head>
<body>
    <h2>Danh Sách Cảnh Báo Nhập Hàng</h2>
    <p><strong>Ngày lập:</strong> {{ $ngayLap }}</p>
    <p><strong>Người xuất:</strong> {{ $nguoiTao }}</p>
    <p><strong >Màu đỏ : Cần bổ sung gấp</strong></p> 
    <p><strong >Màu vàng : Cần có kế hoạch bổ sung</strong></p>
    <br>
    <table>
        <thead>
            <tr>
                <th>Mã Linh Kiện</th>
                <th>Tên Linh Kiện</th>
                <th>Đơn Vị Tính</th>
                <th>Số Lượng Tồn</th>
            </tr>
        </thead>
        <tbody>
            @foreach($canhBaoList as $item)
                @php
                    $rowClass = $item['MucDo'] === 'danger' ? 'danger' : ($item['MucDo'] === 'warning' ? 'warning' : '');
                @endphp
                <tr class="{{ $rowClass }}">
                    <td>{{ $item['MaLinhKien'] }}</td>
                    <td>{{ $item['TenLinhKien'] }}</td>
                    <td>{{ $item['DVT'] }}</td>
                    <td>{{ $item['SoLuong'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
