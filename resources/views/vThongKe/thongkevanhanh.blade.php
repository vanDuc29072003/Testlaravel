@extends('layouts.main')

@section('title', 'Thống Kê Nhật Ký Vận Hành')

@section('content')
<div class="container">
  <div class="row" style="margin-top: 20px; margin-left: 10px;">
    <div class="col-md-9">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Nhật Ký Vận Hành</h1>
      </div>

      @if ($thongke->isEmpty())
        <p>Không có nhật ký nào.</p>
      @else
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead style="background-color: #c2f0c2;">
              <tr>
                <th>STT</th>
                <th>Ngày Vận Hành</th>
                <th>Thời gian</th>
                <th>Tên Máy</th>
                <th>Ca Làm Việc</th>
                <th>Nhân Viên</th>
                <th>Trạng Thái</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($thongke as $index => $item)
              <tr onclick="window.location='{{ route('nhatki.show', $item->MaLichVanHanh) }}'" style="cursor: pointer;">
                <td>{{ $loop->iteration }}</td>
                <td>{{ \Carbon\Carbon::parse($item->NgayVanHanh)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($item->updated_at)->format('d/m/Y H:i') }}</td>
                <td>{{ $item->TenMay }}</td>
                <td>
                  @if ($item->CaLamViec == 'Sáng')
                    Ca 1
                  @elseif ($item->CaLamViec == 'Chiều')
                    Ca 2
                  @else
                    Ca 3
                  @endif
                </td>
                <td>{{ $item->TenNhanVien }}</td>
               <td>
                  @if ($item->trangthai == '0')
                    <span class="badge bg-success">Hoạt động</span>
                  @elseif ($item->trangthai == '2')
                    <span class="badge bg-danger">Có sự cố</span>
                  @else
                    Không xác định
                  @endif
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>

    <!-- Bộ lọc -->
    <div class="col-md-3" style="margin-top: 58px;">
        <form method="GET" action="{{ route('nhatki.thongke') }}" class="p-3 border rounded">
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
