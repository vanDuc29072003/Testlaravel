@extends('layouts.main')

@section('title', 'Thống kê sửa chữa')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <!-- Tiêu đề và nút xuất PDF -->
            <div class="col-md-9">
                <div class="d-flex justify-content-between align-items-center mb-0">
                    <h3 class="mb-0">Thống Kê Sửa Chữa & Bảo Trì</h3>
                    <a href="{{ route('thongkesuachua.pdf', request()->all()) }}" class="btn btn-black btn-border">
                        <i class="fas fa-file-download"></i> Xuất FILE PDF
                    </a>
                </div>
                <p class="fst-italic">Từ ngày {{ $startDate }} - Đến ngày {{ $endDate }}</p>
            </div>

            <!-- Tổng số yêu cầu sửa chữa (nếu có biến này từ controller) -->
            @isset($tongSoYeuCauSuaChua)
            <div class="col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="fas fa-tools"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <strong>Tổng số yêu cầu sửa chữa</strong>
                                    <h4 class="card-title">{{ $tongSoYeuCauSuaChua }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endisset

            <!-- Bảng thống kê -->
            <div class="col-md-9 mt-4">
                @if ($thongKeMay->isNotEmpty())
                <table class="table table-responsive table-bordered table-hover">
                    <thead class="text-center">
                        <tr>
                            <th>Mã máy</th>
                            <th>Tên máy</th>
                            @if($filterType != 'maintenance')
                             <th>Số lần sửa chữa</th>
                           
                                <th>Tổng Chi phí sửa chữa</th>
                                <th>Chi tiết SC</th>
                            @endif

                            @if($filterType != 'repair')
                                <th>Số lần bảo trì</th>
                                <th>Tổng Chi phí bảo trì</th>
                                <th>Chi tiết BT</th>
                            @endif

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($thongKeMay as $item)
                            <td class="text-center">{{ $item->MaMay2 }}</td>
                            <td>{{ $item->TenMay }}</td>
                             @if($filterType != 'maintenance')
                            <td class="text-center">{{ $item->SoLanSuaChua }}</td>
                           
                                <td class="text-end">{{ number_format($item->TongChiPhiSuaChua, 0, ',', '.') }} ₫</td>
                                <td class="text-center">
                                    <a href="{{ route('thongkesuachua.detailSC', [
                                        'maMay' => $item->MaMay,
                                        'time_filter' => request('time_filter'),
                                        'start_date' => request('start_date'),
                                        'end_date' => request('end_date')
                                    ]) }}" class="btn btn-sm btn-info">Chi Tiết</a>
                                </td>
                            @endif
                            @if($filterType != 'repair')
                                <td class="text-center">{{ $item->SoLanBaoTri }}</td>
                                <td class="text-end">{{ number_format($item->TongChiPhiBaoTri, 0, ',', '.') }} ₫</td>
                                <td class="text-center">
                                    <a href="{{ route('thongkesuachua.detailBT', [
                                        'maMay' => $item->MaMay,
                                        'time_filter' => request('time_filter'),
                                        'start_date' => request('start_date'),
                                        'end_date' => request('end_date')
                                    ]) }}" class="btn btn-sm btn-info">Chi Tiết</a>
                                </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="alert alert-info text-center" role="alert">
                    <p class="fst-italic m-0">Không có dữ liệu trong khoảng thời gian đã chọn.</p>
                </div>
                @endif
            </div>

            <!-- Form lọc -->
            <div class="col-md-3 mt-4">
                <form method="GET" action="{{ route('thongkesuachua') }}" class="p-3 border rounded">
                    <h5 class="mb-3">Bộ lọc</h5>

                    <!-- Lọc theo loại máy -->
                    <!-- Lọc theo loại thống kê -->
                    <div class="mb-3">
                        <label for="filter_type" class="form-label">Loại thống kê</label>
                        <select name="filter_type" id="filter_type" class="form-select">
                            <option value="all" {{ request('filter_type', 'all') == 'all' ? 'selected' : '' }}>Cả Sửa chữa & Bảo trì</option>
                            <option value="repair" {{ request('filter_type') == 'repair' ? 'selected' : '' }}>Chỉ Sửa chữa</option>
                            <option value="maintenance" {{ request('filter_type') == 'maintenance' ? 'selected' : '' }}>Chỉ Bảo trì</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="loai_may" class="form-label">Loại máy</label>
                        <select name="loai_may" id="loai_may" class="form-select">
                            <option value="">-- Tất cả loại máy --</option>
                            @foreach ($dsLoaiMay as $loai)
                            <option value="{{ $loai->MaLoai }}" {{ request('loai_may') == $loai->MaLoai ? 'selected' : '' }}>
                                {{ $loai->TenLoai }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Lọc theo tên máy -->
                    <div class="mb-3">
                        <label for="ten_may" class="form-label">Tên máy</label>
                        <input type="text" name="ten_may" id="ten_may" class="form-control"
                            value="{{ request('ten_may') }}" placeholder="Nhập tên máy...">
                    </div>

                    <!-- Sắp xếp -->
                    <div class="mb-3">
                        <label for="sort_order" class="form-label">Sắp xếp theo số lần sửa chữa</label>
                        <select name="sort_order" id="sort_order" class="form-select">
                            <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Giảm dần (nhiều nhất)</option>
                            <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Tăng dần (ít nhất)</option>
                        </select>
                    </div>

                    <!-- Lọc theo thời gian -->
                    <div class="mb-3">
                        <label class="form-label">Thời gian</label>
                        @php
                            $time_filter = request('time_filter', 'today');
                        @endphp
                        @foreach ([
                            'today' => 'Hôm nay',
                            'yesterday' => 'Hôm qua',
                            'this_month' => 'Tháng này',
                            'custom' => 'Tùy chọn khác',
                        ] as $key => $label)
                        <div class="form-check p-0">
                            <input class="form-check-input" type="radio" name="time_filter" id="{{ $key }}"
                                value="{{ $key }}" {{ $time_filter == $key ? 'checked' : '' }}>
                            <label class="form-check-label" for="{{ $key }}">{{ $label }}</label>
                        </div>
                        @endforeach
                    </div>

                    <!-- Ngày bắt đầu/kết thúc -->
                    <div id="custom-date-range" class="mb-3" style="{{ $time_filter === 'custom' ? '' : 'display:none;' }}">
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
<script>
    // Hiển thị/ẩn chọn ngày khi chọn "Tùy chọn khác"
    document.addEventListener("DOMContentLoaded", function () {
        function toggleDateRange() {
            const isCustom = document.getElementById('custom').checked;
            document.getElementById('custom-date-range').style.display = isCustom ? 'block' : 'none';
        }

        const radios = document.querySelectorAll('input[name="time_filter"]');
        radios.forEach(r => r.addEventListener('change', toggleDateRange));
        toggleDateRange(); // Gọi khi load trang
    });
</script>
@endsection
