@extends('layouts.main')

@section('title', 'Thống kê kho')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-9">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-0">
                            <h3 class="mb-0">Thống kê Kho</h3>
                            <a href="{{ route('thongkekho.pdf', request()->all()) }}" class="btn btn-black btn-border">
                                <i class="fas fa-file-download"></i> Xuất FILE PDF
                            </a>
                        </div>
                        <p class="fst-italic">Từ ngày {{ $startDate }} - Đến ngày {{ $endDate }}</p>
                    </div>
                </div>
                <div class="col-3"></div>
                <div class="col-9">
                    <table class="table table-responsive table-bordered table-striped">
                        <thead class="text-center bg-light">
                            <tr>
                                <th rowspan="2">Mã hàng</th>
                                <th rowspan="2">Tên hàng</th>
                                <th rowspan="2">ĐVT</th>
                                <th rowspan="2">Nhập</th>
                                <th colspan="2">Xuất</th>
                                <th rowspan="2">Bàn giao</th>
                                <th rowspan="2">Chênh lệch</th>
                                <th rowspan="2">Tồn kho</th>
                            </tr>
                            <tr>
                                <!-- Nhập -->
                                <th>Xuất</th>
                                <th>Trả kho</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($thongKe as $item)
                                <tr>
                                    <td>{{ $item['MaHang'] }}</td>
                                    <td>{{ $item['TenHang'] }}</td>
                                    <td>{{ $item['DVT'] }}</td>
                                    <td class="text-end">{{ $item['TongNhap'] }}</td>
                                    <td class="text-end">{{ $item['TongXuat'] }}</td>
                                    <td class="text-end">{{ $item['TongTraKho'] }}</td>
                                    <td class="text-end">{{ $item['TongBanGiao'] }}</td>
                                    <td class="text-end">{{ $item['ChenhLech'] }}</td>
                                    <td class="text-end">{{ $item['TonKho'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Form lọc -->
                <div class="col-3">
                    <form method="GET" action="{{ route('thongkekho') }}" class="p-3 border rounded">
                        <h5 class="mb-3">Bộ lọc</h5>
                        <div class="mb-3">
                            <div class="form-check p-0">
                                <input class="form-check-input" type="radio" name="time_filter" id="today" value="today" {{ request('time_filter') == 'today' ? 'checked' : '' }}>
                                <label class="form-check-label" for="today">Hôm nay</label>
                            </div>
                            <div class="form-check p-0">
                                <input class="form-check-input" type="radio" name="time_filter" id="yesterday"
                                    value="yesterday" {{ request('time_filter') == 'yesterday' ? 'checked' : '' }}>
                                <label class="form-check-label" for="yesterday">Hôm qua</label>
                            </div>
                            <div class="form-check p-0">
                                <input class="form-check-input" type="radio" name="time_filter" id="last_7_days"
                                    value="last_7_days" {{ request('time_filter') == 'last_7_days' ? 'checked' : '' }}>
                                <label class="form-check-label" for="last_7_days">7 ngày trước</label>
                            </div>
                            <div class="form-check p-0">
                                <input class="form-check-input" type="radio" name="time_filter" id="this_month"
                                    value="this_month" checked>
                                <label class="form-check-label" for="this_month">Tháng này</label>
                            </div>
                            <div class="form-check p-0">
                                <input class="form-check-input" type="radio" name="time_filter" id="last_month"
                                    value="last_month" {{ request('time_filter') == 'last_month' ? 'checked' : '' }}>
                                <label class="form-check-label" for="last_month">Tháng trước</label>
                            </div>
                            <div class="form-check p-0">
                                <input class="form-check-input" type="radio" name="time_filter" id="this_quarter"
                                    value="this_quarter" {{ request('time_filter') == 'this_quarter' ? 'checked' : '' }}>
                                <label class="form-check-label" for="this_quarter">Quý này</label>
                            </div>
                            <div class="form-check p-0">
                                <input class="form-check-input" type="radio" name="time_filter" id="custom" value="custom"
                                    {{ request('time_filter') == 'custom' ? 'checked' : '' }}>
                                <label class="form-check-label" for="custom">Lựa chọn khác</label>
                            </div>
                        </div>

                        <!-- Ngày bắt đầu và kết thúc (ẩn nếu không chọn "Lựa chọn khác") -->
                        <div id="custom-date-range" class="mb-3">
                            <label for="start_date" class="form-label">Từ ngày</label>
                            <input type="date" name="start_date" id="start_date" class="form-control"
                                value="{{ request('start_date') }}">
                            <label for="end_date" class="form-label mt-2">Đến ngày</label>
                            <input type="date" name="end_date" id="end_date" class="form-control"
                                value="{{ request('end_date') }}">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fa fa-filter"></i> Lọc
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection