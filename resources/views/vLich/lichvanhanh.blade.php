@extends('layouts.main')

@section('title', 'Lịch Vận Hành')

@section('content')
<div class="container">
  <div class="row" style="margin-top: 20px; margin-left: 10px;">
    <!-- Bảng lịch vận hành -->
    <div class="col-md-9">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Lịch Vận Hành</h1>
        <a href="{{ route('lichvanhanh.create') }}" class="btn btn-primary">
          <i class="fa fa-plus"></i> Thêm mới
        </a>
      </div>

      <p style="font-style:italic">
        <a href="{{ route('lichvanhanh') }}">Ngày hiện tại : {{ \Carbon\Carbon::now()->format('d/m/Y') }}</a>
      </p>

      @forelse ($lichvanhanh as $ngay => $lichs)
        <!-- Hiển thị ngày -->
        <h7 class="mt-4" style="font-weight: bold;">Ngày: {{ \Carbon\Carbon::parse($ngay)->format('d/m/Y') }}</h7>
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead style="background-color: #ffc0cb; color: black;">
              <tr>
                <th>STT</th>
                <th>Ngày</th>
                <th>Mã Máy</th>
                <th>Tên Máy</th>
                <th>Người Đảm Nhận</th>
                <th>Mô tả</th>
                <th>Ca làm việc</th>
                <th style="width: 200px;">Hành Động</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($lichs as $index => $lich)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ \Carbon\Carbon::parse($lich->NgayVanHanh)->format('d/m/Y') }}</td>
                  <td>{{ $lich->MaMay }}</td>
                  <td>{{ $lich->may->TenMay ?? 'Không xác định' }}</td>
                  <td>{{ $lich->nhanVien->TenNhanVien ?? 'Không xác định' }}</td>
                  <td>{{ $lich->MoTa }}</td>
                  <td>
                    @if ($lich->CaLamViec == 'Sáng')
                      Ca 1
                    @elseif ($lich->CaLamViec == 'Chiều')
                      Ca 2
                    @else
                      Ca 3
                    @endif
                  </td>
                  <td>
                    <div class="d-flex gap-2">
                      <a href="{{ route('lichvanhanh.edit', $lich->MaLichVanHanh) }}" class="btn btn-warning btn-sm">
                        <i class="fa fa-edit"></i> Sửa
                      </a>
                      <form action="{{ route('lichvanhanh.destroy', $lich->MaLichVanHanh) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="from_date" value="{{ request('from_date') }}">
                        <input type="hidden" name="to_date" value="{{ request('to_date') }}">
                        <input type="hidden" name="quy" value="{{ request('quy') }}">
                        <input type="hidden" name="nam" value="{{ request('nam') }}">
                        <input type="hidden" name="ca" value="{{ request('ca') }}">
                        <input type="hidden" name="may" value="{{ request('may') }}">
                        <input type="hidden" name="nhanvien" value="{{ request('nhanvien') }}">
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                            Xóa
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="8" class="text-center">Không có lịch vận hành nào cho ngày hôm đó.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      @empty
        <p>Không có dữ liệu lịch vận hành.</p>
      @endforelse
    </div>

    <!-- Phần lọc -->
    <div class="col-md-3" style="margin-top: 97px;">
      <div class="card mt-4">
        <div class="card-body">
          <h5 class="card-title">Bộ lọc</h5>
          <form action="{{ route('lichvanhanh') }}" method="GET">
            <div class="mb-3">
              <label for="nam" class="form-label">Chọn năm</label>
              <select name="nam" id="nam" class="form-select">
                <option value="">-- Chọn năm --</option>
                @for ($year = now()->year; $year >= 2000; $year--)
                  <option value="{{ $year }}" {{ request('nam') == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endfor
              </select>
            </div>
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
              <label for="ca" class="form-label">Chọn ca làm việc</label>
              <select name="ca" id="ca" class="form-select">
                <option value="">-- Chọn ca --</option>
                <option value="Sáng" {{ request('ca') == 'Sáng' ? 'selected' : '' }}>Ca 1 (Sáng)</option>
                <option value="Chiều" {{ request('ca') == 'Chiều' ? 'selected' : '' }}>Ca 2 (Chiều)</option>
                <option value="Đêm" {{ request('ca') == 'Đêm' ? 'selected' : '' }}>Ca 3 (Đêm)</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="may" class="form-label">Chọn máy</label>
              <select name="may" id="may" class="form-select">
                <option value="">-- Chọn máy --</option>
                @foreach ($may as $m)
                  <option value="{{ $m->MaMay }}" {{ request('may') == $m->MaMay ? 'selected' : '' }}>{{ $m->TenMay }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label for="nhanvien" class="form-label">Chọn nhân viên</label>
              <select name="nhanvien" id="nhanvien" class="form-select">
                <option value="">-- Chọn nhân viên --</option>
                @foreach ($nhanvien as $nv)
                  <option value="{{ $nv->MaNhanVien }}" {{ request('nhanvien') == $nv->MaNhanVien ? 'selected' : '' }}>{{ $nv->TenNhanVien }}</option>
                @endforeach
              </select>
            </div>
            <br>
            <div>
              <label for="from_date">Chọn khoảng thời gian</label>
              <br>
              <div class="row">
                <div class="col-md-4">
                  <label for="from_date">Từ ngày</label>
                  <input type="date" name="from_date" id="from_date" class="form-control" value="{{ request('from_date') }}">
                  <span id="from_date_display" style="font-weight: bold;"></span>
                </div>

                <div class="col-md-4">
                  <label for="to_date">Đến ngày</label>
                  <input type="date" name="to_date" id="to_date" style="width:100%" class="form-control" value="{{ request('to_date') }}">
                  <span id="to_date_display" style="font-weight: bold;"></span>
                </div>
              </div>
            </div>
            <br>
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
  $(document).ready(function() {
    function formatDate(dateString) {
      const date = new Date(dateString);
      if (!isNaN(date)) {
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        return `${day}.${month}.${year}`;
      }
      return dateString;
    }

    $('#from_date').on('change', function() {
      var selectedDate = $(this).val();
      var formattedDate = formatDate(selectedDate);
      $('#from_date_display').text('Ngày đã chọn: ' + formattedDate);
    });

    $('#to_date').on('change', function() {
      var selectedDate = $(this).val();
      var formattedDate = formatDate(selectedDate);
      $('#to_date_display').text('Ngày đã chọn: ' + formattedDate);
    });
  });
</script>
<script>
  @if (session('error'))
      $.notify({
          title: 'Lỗi',
          message: '{{ session('error') }}',
          icon: 'icon-bell'
      }, {
          type: 'danger',
          animate: {
              enter: 'animated fadeInDown',
              exit: 'animated fadeOutUp'
          },
      });
  @endif
</script>
@endsection
