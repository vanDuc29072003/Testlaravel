@extends('layouts.main')

@section('title', 'Lịch Vận Hành')
<style>
    .square-btn {
        width: 90px;             
        text-align: center;
        white-space: nowrap;     
        font-size: 20px;         
        padding: 6px 8px;        
    }
</style>
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <!-- Danh sách lịch vận hành -->
                <div class="col-xl-10 col-sm-12">
                    <div class="table-responsive">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="mb-0">Lịch Vận Hành</h3>
                            <a href="{{ route('lichvanhanh.create') }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Thêm mới
                            </a>
                        </div>
                        <p class="fst-italic">
                            <a href="{{ route('lichvanhanh') }}">Ngày hiện tại: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</a>
                        </p>

                        @forelse ($lichvanhanh as $ngay => $lichs)
                            <h5 class="mt-4 fw-bold">Ngày: {{ \Carbon\Carbon::parse($ngay)->format('d/m/Y') }}</h5>
                                <table id="tableLichVanHanh" class="table table-responsive table-bordered table-hover">
                                <thead>                                 
                                    <tr class="text-center">
                                        <th>STT</th>
                                        <th>Mã Máy</th>
                                        <th>Tên Máy</th>
                                        <th>Ca làm việc</th>
                                        <th>Người Đảm Nhận</th>
                                        <th>Mô tả</th>
                                        <th>Hành Động</th>
                                    </tr>
                                </thead>
                               <tbody>
                                    @forelse ($lichs as $index => $lich)
                                        <tr class="text-center">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $lich->may->MaMay2 }}</td>
                                            <td>{{ $lich->may->TenMay ?? 'Không xác định' }}</td>
                                            <td>
                                                @switch($lich->CaLamViec)
                                                    @case('Sáng') Ca 1 @break
                                                    @case('Chiều') Ca 2 @break
                                                    @default Ca 3
                                                @endswitch
                                            </td>
                                            <td>{{ $lich->nhanVien->TenNhanVien ?? 'Không xác định' }}</td>
                                            <td>{{ $lich->MoTa ?? 'Không có mô tả' }}</td>
                                            <td>
                                                <div class="d-flex gap-2 mb-2">
                                                    <a href="{{ route('lichvanhanh.showNhatKi', $lich->MaLichVanHanh) }}"
                                                    class="btn btn-info btn-sm text-white square-btn">
                                                        <i class="fa fa-book"></i> Nhật Kí
                                                    </a>
                                                
                                                    <a href="{{ route('yeucausuachua.create', ['ma_lich' => $lich->MaLichVanHanh]) }}"
                                                    class="btn btn-primary btn-sm text-white square-btn">
                                                        <i class="fa fa-wrench"></i> YCSC
                                                    </a>
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('lichvanhanh.edit', $lich->MaLichVanHanh) }}"
                                                    class="btn btn-warning btn-sm text-black square-btn">
                                                        <i class="fa fa-edit"></i> Sửa
                                                    </a>
                                                    <form action="{{ route('lichvanhanh.destroy', $lich->MaLichVanHanh) }}"
                                                        method="POST" class="m-0 p-0 d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-sm square-btn"
                                                                onclick="event.stopPropagation(); confirmDelete(this)">
                                                            <i class="fa fa-trash"></i> Xóa
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">Không có lịch vận hành nào cho ngày này.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        @empty
                            <p class="text-muted">Không có dữ liệu lịch vận hành.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Bộ lọc -->
                <div class="col-xl-2 col-sm-12 p-0" style="margin-top: 138px;">
                    <div>
                        <form method="GET" action="{{ route('lichvanhanh') }}" class="p-3 border rounded fixed-search-form">
                            <h5 class="mb-3">Bộ lọc</h5>    
                              <div class="mb-3">
                                <label class="form-label">Thời gian</label>
                                @php
                                    $time_filter = request('time_filter', 'today');
                                @endphp
                                @foreach ([
                                    'yesterday' => 'Hôm qua',
                                    'today' => 'Hôm nay',
                                    'tomorrow' => 'Ngày mai',
                                    'this_week' => 'Tuần này',
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

                            <div class="mb-3">
                                <label for="ca" class="form-label">Ca làm việc</label>
                                <select name="ca" id="ca" class="form-control">
                                    <option value="">-- Chọn ca --</option>
                                    <option value="Sáng" {{ request('ca') == 'Sáng' ? 'selected' : '' }}>Ca 1 (Sáng)</option>
                                    <option value="Chiều" {{ request('ca') == 'Chiều' ? 'selected' : '' }}>Ca 2 (Chiều)</option>
                                    <option value="Đêm" {{ request('ca') == 'Đêm' ? 'selected' : '' }}>Ca 3 (Đêm)</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="may" class="form-label">Chọn máy</label>
                                <select name="may" id="may" class="form-control">
                                    <option value="">-- Chọn máy --</option>
                                    @foreach ($may as $m)
                                        <option value="{{ $m->MaMay }}" {{ request('may') == $m->MaMay ? 'selected' : '' }}>
                                            {{ $m->TenMay }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="nhanvien" class="form-label">Chọn nhân viên</label>
                                <select name="nhanvien" id="nhanvien" class="form-control">
                                    <option value="">-- Chọn nhân viên --</option>
                                    @foreach ($nhanvien as $nv)
                                        <option value="{{ $nv->MaNhanVien }}" {{ request('nhanvien') == $nv->MaNhanVien ? 'selected' : '' }}>
                                            {{ $nv->TenNhanVien }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fa fa-filter"></i> Lọc
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/remarkable-bootstrap-notify/3.1.3/bootstrap-notify.min.js"></script>

<!-- Animate.css (nếu dùng hiệu ứng animated) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script>
        function confirmDelete(button) {
                swal({
                    title: 'Bạn có chắc chắn?',
                    text: "Hành động này không thể hoàn tác!",
                    icon: 'warning',
                    buttons: {
                        confirm: {
                            text: 'Xóa',
                            className: 'btn btn-danger'
                        },
                        cancel: {
                            text: 'Hủy',
                            visible: true,
                            className: 'btn btn-success'
                        }
                    }
                }).then((willDelete) => {
                    if (willDelete) {
                        button.closest('form').submit(); // Gửi form
                    } else {
                        swal.close(); // Đóng hộp thoại
                    }
                });
            }
    </script>
 
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const radios = document.querySelectorAll('input[name="time_filter"]');
            const customDateRange = document.getElementById('custom-date-range');

            function toggleCustomDate() {
                if (document.querySelector('input[name="time_filter"]:checked').value === 'custom') {
                    customDateRange.style.display = '';
                } else {
                    customDateRange.style.display = 'none';
                    // Nếu muốn reset input ngày khi ẩn, uncomment:
                    // document.getElementById('start_date').value = '';
                    // document.getElementById('end_date').value = '';
                }
            }

            radios.forEach(radio => {
                radio.addEventListener('change', toggleCustomDate);
            });

            // Khởi tạo trạng thái khi trang load
            toggleCustomDate();
        });
    </script>
    <script>
        @if (session('notify_messages'))
            @foreach (session('notify_messages') as $notify)
                $.notify({
                    title: '@if ($notify["type"] == "success") Thành công @elseif($notify["type"] == "warning") Cảnh báo @else Thông báo @endif',
                    message: {!! json_encode($notify['message']) !!},
                    icon: 'icon-bell'
                }, {
                    type: '{{ $notify["type"] }}',
                    animate: {
                        enter: 'animated fadeInDown',
                        exit: 'animated fadeOutUp'
                    },
                });
            @endforeach
        @endif
    </script>
    <!-- script đồng bộ dữ liệu khi có thay đổi mới -->
    <script>
        pusher.subscribe('channel-all').bind('eventUpdateTable', function (data) {
            if (data.reload) {
                $.ajax({
                    url: window.location.href,
                    type: 'GET',
                    success: function (response) {
                        const newData = $(response).find('#tableLichVanHanh').html();

                        $('#tableLichVanHanh').html(newData);
                    },
                    error: function () {
                        console.error('Lỗi khi load lại bảng!');
                    }
                })
            }
        })
    </script>
@endsection
