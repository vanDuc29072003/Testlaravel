<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thống kê sửa chữa</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 16px;
        }
        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .subtitle {
            text-align: center;
            font-style: italic;
            margin-bottom: 20px;
        }
        .info {
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 6px;
            text-align: center;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
    </style>
</head>
<body>

    <div class="title">THỐNG KÊ SỬA CHỮA</div>
    <div class="subtitle">
        Từ ngày {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - 
        Đến ngày {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
    </div>

    <div class="info">
        <strong>Ngày lập:</strong> {{ $ngayLap }}<br>
        <strong>Người lập:</strong> {{ $nguoiTao }}
    </div>

    @if ($thongKeSuaChua->isNotEmpty())
        <table>
            <thead>
                <tr>
                    <th>Mã máy</th>
                    <th>Tên máy</th>
                    <th>Số lần yêu cầu sửa chữa</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($thongKeSuaChua as $item)
                    <tr>
                        <td>{{ $item['MaMay2'] }}</td>
                        <td>{{ $item['TenMay'] }}</td>
                        <td>{{ $item['SoLanSuaChua'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="info">
            <strong>Tổng số yêu cầu sửa chữa:</strong> {{ $tongSoYeuCauSuaChua }}
        </div>
    @else
        <div class="info" style="margin-top: 20px;">
            <strong>Không có yêu cầu sửa chữa nào trong khoảng thời gian này.</strong>
        </div>
    @endif

    <div class="footer" style="margin-top: 60px;">
        <em>Nhân viên xác nhận</em><br>
        <em>(Ký, họ tên)</em><br>

</body>
</html>
