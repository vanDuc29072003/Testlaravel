@extends('layouts.main')

@section('title', 'Thống Kê Nhật Ký Vận Hành')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-9">
                <div>
                  <div class="d-flex justify-content-between align-items-center mb-0">
                      <h3 class="mb-0">Nhật kí vận hành</h3>
                  </div>
                  @if ($startDate && $endDate)
                  <p class="fst-italic">
                  Ngày hiển thị nhật ký: {{ $timeDescription }} (từ {{ $startDate->format('d/m/Y H:i') }} đến {{ $endDate->format('d/m/Y H:i') }})
                  </p>
                  @endif
                </div>
            </div>
            <div class="col-3">
                <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                            <i class="fas fa-check"></i> 
                                        </div>
                                    </div>
                                    <div class="col col-stats ms-3 ms-sm-0">
                                        <div class="numbers">
                                            <strong>Tổng số lịch đã xác nhận</strong>
                                            <h4 class="card-title">{{ $totalWithNhatKi }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            </div>
          <div class="col-9">
            @if ($thongke->isEmpty())
              <p>Không có nhật ký nào.</p>
            @else
              <div class="table-responsive">
                <table class="table table-hover table-bordered">
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
                          <span class="badge bg-success">Bình thường</span>
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
          <div class="col-3">
                      <form method="GET" action="{{ route('nhatki.thongke') }}" class="p-3 border rounded">
                          <h5 class="mb-3">Bộ lọc</h5>
                          <div class="mb-3">
                              @php
                                  $time_filter = request('time_filter', 'today');
                              @endphp
                              @foreach ([
                                  'today' => 'Hôm nay',
                                  'yesterday' => 'Hôm qua',
                                  'last_7_days' => '7 ngày trước',
                                  'this_month' => 'Tháng này',
                                  'last_month' => 'Tháng trước',
                                  'this_quarter' => 'Quý này',
                                  'custom' => 'Lựa chọn khác',
                              ] as $key => $label)
                                  <div class="form-check p-0">
                                      <input class="form-check-input" type="radio" name="time_filter" id="{{ $key }}"
                                          value="{{ $key }}" {{ $time_filter == $key ? 'checked' : '' }}>
                                      <label class="form-check-label" for="{{ $key }}">{{ $label }}</label>
                                  </div>
                              @endforeach
                          </div>

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
            toggleDateRange(); // gọi khi load trang
        });
    </script>
@endsection
