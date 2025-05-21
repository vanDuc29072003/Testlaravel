@extends('layouts.main')

@section('title', 'Lịch Bảo Trì Đã Hoàn Thành')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <!-- Phần bảng -->
                <div class="col-md-9">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h1 class="mb-0">Lịch bảo trì đã hoàn thành</h1>
                    </div>

                    @foreach ($lichbaotriGrouped as $monthYear => $lichs)
                        <!-- Hiển thị tháng và năm -->
                        <h5 class="mt-4 text-primary">Tháng: {{ \Carbon\Carbon::parse($monthYear . '-01')->format('m/Y') }}</h5>

                        <table class="table table-responsive table-bordered">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Ngày</th>
                                    <th>Tên máy</th>
                                    <th>Mô tả</th>
                                    <th>Nhà cung cấp sửa chữa</th>
                                    <th>Trạng thái</th>
                                    <th scope="col">Xem chi tiết</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lichs as $index => $lich)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ \Carbon\Carbon::parse($lich->NgayBaoTri)->format('d/m/Y') }}</td>
                                        <td>{{ $lich->may->TenMay ?? 'Không xác định' }}</td>
                                        <td>{{ $lich->MoTa }}</td>
                                        <td>{{ $lich->may->nhaCungCap->TenNhaCungCap ?? 'Không xác định' }}</td>
                                        <td><span class="badge bg-success">Hoàn thành</span></td>
                                        <td>
                                            <a href="{{ route('lichbaotri.showpbg', $lich->MaLichBaoTri) }}"
                                                class="btn btn-primary btn-sm">
                                                <i class="fas fa-info-circle"></i> Chi tiết
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endforeach
                </div>

                <!-- Phần lọc -->
                <div class="col-md-3">
                    <div style="margin-top: 100px;">
                        <form action="{{ route('lichbaotri.dabangiao') }}" method="GET" class="p-3 border rounded">
                            <h5 class="mb-3">Bộ lọc</h5>
                            <div class="mb-3">
                                <label for="may" class="form-label">Chọn máy</label>
                                <select name="may" id="may" class="form-select">
                                    <option value="">-- Tất cả máy --</option>
                                    @foreach($dsMay as $may)
                                        <option value="{{ $may->MaMay }}" {{ request('may') == $may->MaMay ? 'selected' : '' }}>
                                            {{ $may->TenMay }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="ncc" class="form-label">Chọn nhà cung cấp</label>
                                <select name="ncc" id="ncc" class="form-select">
                                    <option value="">-- Tất cả nhà cung cấp --</option>
                                    @foreach($dsNhaCungCap as $ncc)
                                        <option value="{{ $ncc->MaNhaCungCap }}" {{ request('ncc') == $ncc->MaNhaCungCap ? 'selected' : '' }}>
                                            {{ $ncc->TenNhaCungCap }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label d-block">Khoảng thời gian</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="time_type" id="time_month"
                                        value="month" {{ request('time_type', 'month') == 'month' ? 'checked' : '' }}>
                                    <label class="form-check-label m-0" for="time_month">Tháng này</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="time_type" id="time_quarter"
                                        value="quarter" {{ request('time_type') == 'quarter' ? 'checked' : '' }}>
                                    <label class="form-check-label m-0" for="time_quarter">3 tháng trước</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="time_type" id="time_custom"
                                        value="custom" {{ request('time_type') == 'custom' ? 'checked' : '' }}>
                                    <label class="form-check-label m-0" for="time_custom">Khoảng thời gian</label>
                                </div>
                                <div class="mb-3" id="custom-date-range"
                                    style="display: none;">
                                    <div class="mb-3">
                                        <label for="from" class="form-label">Từ ngày</label>
                                        <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="to" class="form-label">Đến ngày</label>
                                        <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fa fa-filter"></i> Lọc</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Hiện/ẩn khoảng thời gian tuỳ chọn
        document.addEventListener('DOMContentLoaded', function () {
            const radios = document.querySelectorAll('input[name="time_type"]');
            const customRange = document.getElementById('custom-date-range');
            radios.forEach(radio => {
                radio.addEventListener('change', function () {
                    if (this.value === 'custom') {
                        customRange.style.display = 'block';
                    } else {
                        customRange.style.display = 'none';
                    }
                });
            });
        });
    </script>
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
@endsection