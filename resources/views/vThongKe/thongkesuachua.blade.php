@extends('layouts.main')

@section('title', 'Thống kê sửa chữa')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-9">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-0">
                            <h3 class="mb-0">Thống kê sửa chữa</h3>
                            <a href="{{ route('thongkesuachua.pdf', request()->all()) }}" class="btn btn-black btn-border">
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

                <!-- Bảng thống kê -->
               <div class="col-9">
                    @if ($thongKeSuaChua->isNotEmpty())
                        <table class="table table-responsive table-bordered table-hover table-striped">
                            <thead class="text-center bg-light">
                                <tr>
                                    <th>Mã máy</th>
                                    <th>Tên máy</th>
                                    <th>Số lần yêu cầu sửa chữa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($thongKeSuaChua as $item)
                                    <tr onclick="window.location='{{ route('thongkesuachua.detail', [
                                        'maMay' => $item['MaMay'],
                                        'time_filter' => request('time_filter'),
                                        'start_date' => request('start_date'),
                                        'end_date' => request('end_date')
                                    ]) }}'" style="cursor: pointer;">
                                        <td>{{ $item['MaMay2'] }}</td>
                                        <td>{{ $item['TenMay'] }}</td>
                                        <td class="text-end">{{ $item['SoLanSuaChua'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-info text-center" role="alert">
                            <p class="fst-italic m-0">Không có yêu cầu sửa chữa nào trong khoảng thời gian này.</p>
                        </div>
                    @endif
                </div>

            

            <!-- Form lọc thời gian -->
                <div class="col-3">
                    <form method="GET" action="{{ route('thongkesuachua') }}" class="p-3 border rounded">
                        <h5 class="mb-3">Bộ lọc</h5>
                        {{-- Lọc theo loại máy --}}
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

                        {{-- Lọc theo mã máy --}}                       

                        {{-- Lọc theo tên máy --}}
                        <div class="mb-3">
                            <label for="ten_may" class="form-label">Tên máy</label>
                            <input type="text" name="ten_may" id="ten_may" class="form-control"
                                value="{{ request('ten_may') }}">
                        </div>

                        {{-- Sắp xếp tăng/giảm --}}
                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Sắp xếp</label>
                            <select name="sort_order" id="sort_order" class="form-select">
                                <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Giảm dần (nhiều nhất)</option>
                                <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Tăng dần (ít nhất)</option>
                            </select>
                        </div>
                        {{-- Lọc theo thời gian --}}
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

                        {{-- Ngày bắt đầu và kết thúc (chỉ hiển thị nếu chọn "custom") --}}
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
            @endsection
                        


@section('scripts')
 <script>
        @if (session('success'))
            $.notify({
                title: 'Thành công',
                message: '{{ session('success') }}',
                icon: 'icon-bell'
            }, {
                type: 'success',
                animate: { enter: 'animated fadeInDown', exit: 'animated fadeOutUp' },
            });
        @endif
    </script>
    <script>
        // Hiển thị/ẩn ô chọn ngày khi chọn "Lựa chọn khác"
        document.addEventListener("DOMContentLoaded", function () {
            function toggleDateRange() {
                const isCustom = document.getElementById('custom').checked;
                document.getElementById('custom-date-range').style.display = isCustom ? 'block' : 'none';
            }

            const radios = document.querySelectorAll('input[name="time_filter"]');
            radios.forEach(r => r.addEventListener('change', toggleDateRange));
            toggleDateRange(); // gọi khi load trang
        });
    </script>
@endsection
