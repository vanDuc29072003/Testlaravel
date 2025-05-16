@extends('layouts.main')

@section('title', 'Lịch Vận Hành')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <!-- Danh sách lịch vận hành -->
                <div class="col-10">
                    <div class="table-responsive">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h1 class="mb-0">Lịch Vận Hành</h1>
                            <a href="{{ route('lichvanhanh.create') }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Thêm mới
                            </a>
                        </div>
                        <p class="fst-italic">
                            <a href="{{ route('lichvanhanh') }}">Ngày hiện tại: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</a>
                        </p>

                        @forelse ($lichvanhanh as $ngay => $lichs)
                            <h5 class="mt-4 fw-bold">Ngày: {{ \Carbon\Carbon::parse($ngay)->format('d/m/Y') }}</h5>
                                <table class="table table-responsive table-bordered table-hover">
                                <thead>                                 
                                    <tr class="text-center">
                                        <th>STT</th>
                                        <th>Ngày</th>
                                        <th>Mã Máy</th>
                                        <th>Tên Máy</th>
                                        <th>Người Đảm Nhận</th>
                                        <th>Ca làm việc</th>
                                        <th>Hành Động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($lichs as $index => $lich)
                                        <tr class="text-center"
                                            onclick="window.location='{{ route('lichvanhanh.showNhatKi', $lich->MaLichVanHanh) }}'"
                                            style="cursor: pointer;">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ \Carbon\Carbon::parse($lich->NgayVanHanh)->format('d/m/Y') }}</td>
                                            <td>{{ $lich->may->MaMay2 }}</td>
                                            <td>{{ $lich->may->TenMay ?? 'Không xác định' }}</td>
                                            <td>{{ $lich->nhanVien->TenNhanVien ?? 'Không xác định' }}</td>
                                            <td>
                                                @switch($lich->CaLamViec)
                                                    @case('Sáng') Ca 1 @break
                                                    @case('Chiều') Ca 2 @break
                                                    @default Ca 3
                                                @endswitch
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2 justify-content-center">
                                                    <a href="{{ route('lichvanhanh.edit', $lich->MaLichVanHanh) }}"
                                                        class="btn btn-warning btn-sm text-black">
                                                        <i class="fa fa-edit"></i> Sửa
                                                    </a>
                                                    <a href="{{ route('yeucausuachua.create', ['ma_lich' => $lich->MaLichVanHanh]) }}"
                                                         class="btn btn-primary btn-sm text-white">
                                                         <i class="fa fa-wrench"></i> Yêu cầu sửa chữa
                                                     </a>

                                                    <form action="{{ route('lichvanhanh.destroy', $lich->MaLichVanHanh) }}"
                                                        method="POST" class="d-inline-block"
                                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <!-- Giữ lại điều kiện lọc -->
                                                        @foreach (['from_date', 'to_date', 'quy', 'nam', 'ca', 'may', 'nhanvien'] as $filter)
                                                            <input type="hidden" name="{{ $filter }}"
                                                                value="{{ request($filter) }}">
                                                        @endforeach
                                                        <button type="submit" class="btn btn-danger btn-sm">
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
                <div class="col-2 p-0">
                    <div style="margin-top: 140px;">
                        <form method="GET" action="{{ route('lichvanhanh') }}" class="p-3 border rounded fixed-search-form">
                            <div class="mb-3">
                                <label for="nam" class="form-label">Chọn năm</label>
                                <select name="nam" id="nam" class="form-control">
                                    <option value="">-- Chọn năm --</option>
                                    @for ($year = now()->year; $year >= 2000; $year--)
                                        <option value="{{ $year }}" {{ request('nam') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="quy" class="form-label">Chọn quý</label>
                                <select name="quy" id="quy" class="form-control">
                                    <option value="">-- Chọn quý --</option>
                                    @foreach ([1, 2, 3, 4] as $q)
                                        <option value="{{ $q }}" {{ request('quy') == $q ? 'selected' : '' }}>Quý {{ $q }}</option>
                                    @endforeach
                                </select>
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

                            <div class="mb-3">
                                <label for="from_date" class="form-label">Từ ngày</label>
                                <input type="date" name="from_date" id="from_date" class="form-control" value="{{ request('from_date') }}">
                            </div>

                            <div class="mb-3">
                                <label for="to_date" class="form-label">Đến ngày</label>
                                <input type="date" name="to_date" id="to_date" class="form-control" value="{{ request('to_date') }}">
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fa fa-search"></i> Lọc
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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

@endsection