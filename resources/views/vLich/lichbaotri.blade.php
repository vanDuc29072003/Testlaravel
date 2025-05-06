@extends('layouts.main')

@section('title', 'Lịch Bảo Trì')

@section('content')
  <div class="container">
    <div class="page-inner">
      <div class="row">
        <!-- Phần bảng -->
        <div class="col-md-9">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="mb-0">Lịch bảo trì</h1>
            <a href="{{ route('lichbaotri.create') }}" class="btn btn-primary">
              <i class="fa fa-plus"></i> Thêm mới
            </a>
          </div>

          @foreach ($lichbaotriGrouped as $monthYear => $lichs)
            <!-- Hiển thị tháng và năm -->
            <h7 class="mt-4" style="font-weight: bold;">Tháng: {{ \Carbon\Carbon::parse($monthYear . '-01')->format('m/Y') }}</h7>

            <table class="table table-bordered">
              <thead style="background-color: #ffc0cb; color: black;">
                <tr>
                  <th>STT</th>
                  <th>Ngày</th> <!-- Cột Ngày -->
                  <th>Mô tả</th>
                  <th>Tên máy</th>
                  <th>Nhà cung cấp sửa chữa</th>
                  <th style="width: 200px;">Trạng thái</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($lichs as $index => $lich)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($lich->NgayBaoTri)->format('d/m/Y') }}</td> <!-- Hiển thị ngày -->
                    <td>{{ $lich->MoTa }}</td>
                    <td>{{ $lich->may->TenMay ?? 'Không xác định' }}</td>
                    <td>{{ $lich->may->nhaCungCap->TenNhaCungCap ?? 'Không xác định' }}</td>
                    <td style="width: 200px;">
                      <div class="d-flex gap-2">
                        
                        <a href="{{ route('lichbaotri.taophieubangiao', $lich->MaLichBaoTri) }}" class="btn btn-sm btn-success">
                          <i class="fa fa-check"></i> Bàn giao
                        </a>
                      
                        <form action="{{ route('lichbaotri.destroy', $lich->MaLichBaoTri) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="button" class="btn btn-danger btn-sm"
                          onclick="event.stopPropagation(); confirmDelete(this)">
                          <i class="fa fa-trash"></i> Xóa
                           </button>
                        </form>
                      </div>
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
            <form action="{{ route('lichbaotri') }}" method="GET">
              <!-- 👇 Di chuyển ô tìm kiếm lên trên cùng -->
              <div class="mb-3">
                <label for="ten_may" class="form-label">Tìm theo tên máy</label>
                <input type="text" name="ten_may" id="ten_may" class="form-control" value="{{ request('ten_may') }}" placeholder="Nhập tên máy...">
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
  function confirmDelete(button) {
      swal({
          title: 'Bạn có chắc chắn?',
          text: "Hành động này không thể hoàn tác!",
          icon: 'warning',
          buttons: {
              confirm: { text: 'Xóa', className: 'btn btn-danger' },
              cancel: { text: 'Hủy', visible: true, className: 'btn btn-success' }
          }
      }).then((willDelete) => {
          if (willDelete) {
              button.closest('form').submit();  
          } else {
              swal.close();
          }
      });
  }
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