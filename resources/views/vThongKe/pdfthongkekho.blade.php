
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống Kê Kho</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        .text-left {
            text-align: left;
        }
    </style>
</head>
<body>
    <h3 style="text-align: center;">BÁO CÁO THỐNG KÊ KHO</h3>
    <p><strong>Khoảng thời gian:</strong> {{ $startDate }} - {{ $endDate }}</p>
    <p><strong>Ngày lập:</strong> {{ $ngayLap }}</p>
    <p><strong>Người tạo:</strong> {{ $nguoiTao }}</p>

    <table>
        <thead>
            <tr>
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
            @foreach ($thongKe as $item)
                <tr>
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
</body>
</html>