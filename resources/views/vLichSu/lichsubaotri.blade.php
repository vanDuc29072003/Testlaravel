@extends('layouts.main')

@section('title', 'Lịch Bảo Trì Đã Hoàn Thành')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <!-- Phần bảng -->
            <div class="col-md-9">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h1 class="mb-0">Lịch Bảo Trì Đã Hoàn Thành</h1>
                   
                </div>

                @foreach ($lichbaotriGrouped as $monthYear => $lichs)
                    <!-- Hiển thị tháng và năm -->
                    <h7 class="mt-4" style="font-weight: bold;">Tháng: {{ \Carbon\Carbon::parse($monthYear . '-01')->format('m/Y') }}</h7>

                    <table class="table table-bordered">
                        <thead style="background-color: #c0ffc0; color: black;">
                            <tr>
                                <th>STT</th>
                                <th>Ngày</th>
                                <th>Mô tả</th>
                                <th>Tên máy</th>
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
                                    <td>{{ $lich->MoTa }}</td>
                                    <td>{{ $lich->may->TenMay ?? 'Không xác định' }}</td>
                                    <td>{{ $lich->may->nhaCungCap->TenNhaCungCap ?? 'Không xác định' }}</td>
                                    <td><span class="badge bg-success">Hoàn thành</span></td>
                                    <td>
                                        <a href="{{ route('lichbaotri.showpbg', $lich->MaLichBaoTri) }}" class="btn btn-primary btn-sm">
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
                <div style="margin-top: 50px">
                    <h5 class="mb-3">Bộ lọc</h5>
                    <form action="{{ route('lichbaotri.dabangiao') }}" method="GET">
                        <div class="mb-3">
                            <label for="quy" class="form-label">Chọn quý</label>
                            <select name="quy" id="quy" class="form-select">
                                <option value="">-- Chọn quý --</option>
                                <option value="1" {{ request('quy') == 1 ? 'selected' : '' }}>Quý 1</option>
                                <option value="2" {{ request('quy') == 2 ? 'selected' : '' }}>Quý 2</option>
                                <option value="3" {{ request('quy') == 3 ? 'selected' : '' }}>Quý 3</option>
                                <option value="4" {{ request('quy') == 4 ? 'selected' : '' }}>Quý 4</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nam" class="form-label">Chọn năm</label>
                            <select name="nam" id="nam" class="form-select">
                                <option value="">-- Chọn năm --</option>
                                @for ($year = now()->year; $year >= 2000; $year--)
                                    <option value="{{ $year }}" {{ request('nam') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Lọc</button>
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
