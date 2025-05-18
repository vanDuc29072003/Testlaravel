<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thống kê linh kiện xuất (PDF)</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
        }

        h2, p {
            text-align: center;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
            text-align: center;
        }

        .text-end {
            text-align: right;
        }

        .summary {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h2>THỐNG KÊ LINH KIỆN ĐÃ XUẤT</h2>
    <p><i>Từ ngày {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} đến {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</i></p>

    <table>
        <thead>
            <tr>
                <th>Mã linh kiện</th>
                <th>Tên linh kiện</th>
                <th>Đơn vị tính</th>
                <th>Số lượng xuất</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($thongKe as $item)
                <tr>
                    <td>{{ $item->MaLinhKien }}</td>
                    <td>{{ $item->TenLinhKien }}</td>
                    <td>{{ $item->TenDonViTinh }}</td>
                    <td class="text-end">{{ $item->TongXuat }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center"><i>Không có dữ liệu</i></td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p class="summary"><strong>Tổng số loại linh kiện:</strong> {{ $thongKe->count() }}</p>
</body>
</html>
