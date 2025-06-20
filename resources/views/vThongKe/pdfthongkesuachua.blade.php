<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thống kê sửa chữa</title>
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
        .suachua-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 13px;
        }
        .suachua-table th, .suachua-table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }
        .suachua-table th {
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
        .summary {
            margin-top: 10px;
            text-align: right;
            font-weight: bold;
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
        <h3>THỐNG KÊ SỬA CHỮA VÀ BẢO TRÌ</h3>
        <em>Từ ngày {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} đến {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</em>
    </div>

    <h4>I. Thông tin chung</h4>
    <table class="info-table">
        <tr>
            <td class="label">Khoảng thời gian:</td>
            <td>{{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td class="label">Ngày lập:</td>
            <td>{{ $ngayLap }}</td>
        </tr>
        <tr>
            <td class="label">Người lập:</td>
            <td>{{ $nguoiTao }}</td>
        </tr>
    </table>

    <h4>II. Danh sách máy sửa chữa và bảo trì</h4>
    <table class="suachua-table">
        <thead>
            <tr>
                <th>STT</th>
                <th>Mã máy</th>
                <th>Tên máy</th>
                <th>Số lần sửa chữa</th>
                <th>Tổng chi phí sửa chữa</th>
                <th>Số lần bảo trì</th>
                <th>Tổng chi phí bảo trì</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($thongKeMay as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->MaMay2 ?? 'Không rõ' }}</td>
                    <td>{{ $item->TenMay ?? 'Không rõ' }}</td>
                    <td>{{ $item->SoLanSuaChua ?? 0 }}</td>
                    <td>{{ number_format($item->TongChiPhiSuaChua ?? 0, 0, ',', '.') }} đ</td>
                    <td>{{ $item->SoLanBaoTri ?? 0 }}</td>
                    <td>{{ number_format($item->TongChiPhiBaoTri ?? 0, 0, ',', '.') }} đ</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center"><i>Không có dữ liệu sửa chữa hoặc bảo trì trong khoảng thời gian này.</i></td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        Tổng số sửa chữa: {{ $tongSoYeuCauSuaChua }}
    </div>
      <div class="summary">
        Tổng số bảo trì: {{ $tongSoBaoTri }}
    </div>

    <h4>III. Ghi chú</h4>
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
