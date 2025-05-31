@extends('layouts.main')

@section('title', 'Thống kê linh kiện xuất')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-9">
                <div>
                    <div class="d-flex justify-content-between align-items-center mb-0">
                        <h3 class="mb-0">Thống kê linh kiện đã xuất</h3>
                        <a href="{{ route('thongkelinhkienxuat.pdf', request()->all()) }}" class="btn btn-black btn-border">
                            <i class="fas fa-file-download"></i> Xuất FILE PDF
                        </a>
                    </div>
                    <p class="fst-italic">Từ ngày {{ $startDate }} - Đến ngày {{ $endDate }}</p>
                </div>
            </div>

            <div class="col-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="fas fa-dolly-flatbed"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                @php
                                    $tongSoLuongXuat = $thongKe->sum('TongXuat');
                                @endphp

                                <div class="numbers">
                                    <strong>Tổng số linh kiện đã xuất</strong>
                                    <h4 class="card-title">{{ $tongSoLuongXuat }}</h4>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bảng thống kê -->
            <div class="col-9">
                @if ($thongKe->isNotEmpty())
                    <table class="table table-responsive table-bordered table-striped">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>Mã linh kiện</th>
                                <th>Tên linh kiện</th>
                                <th>Đơn vị tính</th>
                                <th>Số lượng xuất</th>
                                <th>Chi Tiết</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($thongKe as $item)
                                <tr>
                                    <td>{{ $item->MaLinhKien }}</td>
                                    <td>{{ $item->TenLinhKien }}</td>
                                    <td>{{ $item->TenDonViTinh }}</td>
                                    <td class="text-end">{{ $item->TongXuat }}</td>
                                    <td>
                                       <a href="{{ route('thongke.chitietxuat', array_merge(request()->all(), ['ma_linh_kien' => $item->MaLinhKien])) }}" 
                                            class="btn btn-sm btn-info"> Chi Tiết
                                        </a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                @else
                    <div class="alert alert-info text-center" role="alert">
                        <p class="fst-italic m-0">Không có dữ liệu xuất kho trong khoảng thời gian này.</p>
                    </div>
                @endif
            </div>

            <!-- Form lọc thời gian -->
            <div class="col-3">
                <form method="GET" action="{{ route('thongkelinhkienxuat') }}" class="border rounded p-3">
                    <h5 class="mb-3">Bộ lọc</h5>
                    <div class="mb-3">
                        <select name="ma_dvt" class="form-select">
                            <option value="">-- Chọn đơn vị tính --</option>
                            @foreach ($danhSachDonViTinh as $dvt)
                                <option value="{{ $dvt->MaDonViTinh }}" {{ request('ma_dvt') == $dvt->MaDonViTinh ? 'selected' : '' }}>
                                    {{ $dvt->TenDonViTinh }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="mb-3">
                        <label for="ten_linh_kien" class="form-label">Tên linh kiện</label>
                        <input type="text" name="ten_linh_kien" class="form-control" placeholder="Nhập tên..." value="{{ request('ten_linh_kien') }}">
                    </div>

                    <div class="mb-3">
                        <label for="sort_quantity" class="form-label">Sắp xếp theo số lượng</label>
                       <select class="form-select" name="sort_quantity">
                        <option value="">-- Không sắp xếp --</option>
                        <option value="asc" {{ request('sort_quantity') == 'asc' ? 'selected' : '' }}>Tăng dần</option>
                        <option value="desc" {{ request('sort_quantity', 'desc') == 'desc' ? 'selected' : '' }}>Giảm dần</option>
                    </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Thời gian</label>
                        @php $time_filter = request('time_filter', 'today'); @endphp
                        @foreach([
                            'today' => 'Hôm nay',
                            'yesterday' => 'Hôm qua',                        
                            'this_month' => 'Tháng này',
                            'custom' => 'Tùy chọn khác',
                        ] as $key => $label)
                            <div class="form-check p-0">
                                <input type="radio" class="form-check-input" name="time_filter" id="{{ $key }}" value="{{ $key }}" {{ $time_filter == $key ? 'checked' : '' }}>
                                <label class="form-check-label" for="{{ $key }}">{{ $label }}</label>
                            </div>
                        @endforeach
                    </div>

                    <div id="custom-date-range" class="mb-3">
                        <label for="start_date" class="form-label">Từ ngày</label>
                        <input type="date" class="form-control" name="start_date" id="start_date" value="{{ request('start_date') }}">
                        <label for="end_date" class="form-label mt-2">Đến ngày</label>
                        <input type="date" class="form-control" name="end_date" id="end_date" value="{{ request('end_date') }}">
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
    // Hiển thị/ẩn ô chọn ngày khi chọn "Lựa chọn khác"
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
