@extends('layouts.main')

@section('title', 'Lịch Bảo Trì')

@section('content')
<div class="container">
  <div class="page-inner">
    <div class="row">

      <!-- Phần lịch bảo trì -->
      <div class="col-lg-9">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h1 class="mb-0">Lịch bảo trì</h1>
          <a href="{{ route('lichbaotri.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Thêm mới
          </a>
        </div>
      </div>
      <div class="col-lg-9">
        @forelse ($lichbaotriGrouped as $monthYear => $lichs)
          <h5 class="mt-4 text-primary">Tháng: {{ \Carbon\Carbon::parse($monthYear . '-01')->format('m/Y') }}</h5>
          <table class="table table-responsive table-bordered">
            <thead>
              <tr>
                <th>STT</th>
                <th>Ngày</th>
                <th>Tên máy</th>
                <th>Mô tả</th>
                <th>Nhà cung cấp</th>
                <th style="width: 200px;">Hành động</th>
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
                  <td>
                    <div class="d-flex gap-2">
                      <a href="{{ route('lichbaotri.taophieubangiao', $lich->MaLichBaoTri) }}" class="btn btn-sm btn-success">
                        <i class="fa fa-check"></i> Bàn giao
                      </a>
                      <form action="{{ route('lichbaotri.destroy', $lich->MaLichBaoTri) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger btn-sm" onclick="event.stopPropagation(); confirmDelete(this)">
                          <i class="fa fa-trash"></i> Xóa
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @empty
          <div class="alert alert-info mt-4">Không có lịch bảo trì phù hợp.</div>
        @endforelse
      </div>

      <!-- Phần bộ lọc -->
    
      <div class="col-lg-3">
            <h5 class="mt-4">&nbsp;</h5>
            <form action="{{ route('lichbaotri') }}" method="GET" class="p-3 border rounded">
            <h5 class="mb-3">Bộ lọc</h5>
                <div class="mb-3">
            <!-- Chọn máy -->
                  <label for="may_id" class="form-label">Chọn máy</label>
                  <select name="may_id" id="may_id" class="form-select">
                      <option value="" {{ request()->filled('may_id') ? '' : 'selected' }}>-- Tất cả máy --</option>
                      @foreach ($dsMay as $may)
                          <option value="{{ $may->MaMay }}" {{ request('may_id') == $may->MaMay ? 'selected' : '' }}>
                              {{ $may->TenMay }}
                          </option>
                      @endforeach
                  </select>
                </div>
                <div class="mb-3">

                <!-- Chọn nhà cung cấp -->
               <!-- Chọn nhà cung cấp -->
              <label for="ncc_id" class="form-label">Chọn nhà cung cấp</label>
              <select name="ncc_id" id="ncc_id" class="form-select">
                  <option value="" {{ request()->filled('ncc_id') ? '' : 'selected' }}>-- Tất cả NCC --</option>
                  @foreach ($dsNhaCungCap as $ncc)
                      <option value="{{ $ncc->MaNhaCungCap }}" {{ request('ncc_id') == $ncc->MaNhaCungCap ? 'selected' : '' }}>
                          {{ $ncc->TenNhaCungCap }}
                      </option>
                  @endforeach
              </select> 
                </div>
              <!-- Khoảng thời gian -->
                <div class="mb-3">
                  <label class="form-label d-block">Khoảng thời gian</label>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="khoang_thoi_gian" id="radio_1thang" value="1"
                        {{ request('khoang_thoi_gian', '1') == '1' ? 'checked' : '' }}>
                      <label class="form-check-label m-0" for="radio_1thang">
                        1 tháng gần nhất
                      </label>
                    </div>
                  <!-- 3 tháng gần nhất -->
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="khoang_thoi_gian" id="radio_3thang" value="3"
                      {{ request('khoang_thoi_gian') == '3' ? 'checked' : '' }}>
                    <label class="form-check-label m-0" for="radio_3thang">
                      3 tháng gần nhất
                    </label>
                  </div>

                  <!-- 5 tháng gần nhất -->
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="khoang_thoi_gian" id="radio_5thang" value="5"
                      {{ request('khoang_thoi_gian') == '5' ? 'checked' : '' }}>
                    <label class="form-check-label m-0" for="radio_5thang">
                      5 tháng gần nhất
                    </label>
                  </div>

                  <!-- Tùy chọn khác -->
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="khoang_thoi_gian" id="radio_khac" value="khac"
                      {{ request('khoang_thoi_gian') == 'khac' || request('tu_ngay') || request('den_ngay') ? 'checked' : '' }}>
                    <label class="form-check-label m-0" for="radio_khac">
                      Tùy chọn khác
                    </label>
                  </div>
                </div>

                <!-- Hiện khi chọn "Tùy chọn khác" -->
                <div id="chon_khoang_tuy_chon" style="display: none;">
                  <div class="mb-3">
                    <label class="form-label">Từ ngày</label>
                    <input type="date" name="tu_ngay" class="form-control" value="{{ request('tu_ngay') }}">
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Đến ngày</label>
                    <input type="date" name="den_ngay" class="form-control" value="{{ request('den_ngay') }}">
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

  @if (session('error'))
    $.notify({
      title: 'Lỗi',
      message: '{{ session('error') }}',
      icon: 'icon-bell'
    }, {
      type: 'danger',
      animate: { enter: 'animated fadeInDown', exit: 'animated fadeOutUp' },
    });
  @endif
</script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const chonTuyChonDiv = document.getElementById('chon_khoang_tuy_chon');
    const radioKhac = document.getElementById('radio_khac');

    // Hàm cập nhật trạng thái hiển thị
    function toggleTuyChon() {
      const selected = document.querySelector('input[name="khoang_thoi_gian"]:checked');
      if (selected && selected.value === 'khac') {
        chonTuyChonDiv.style.display = 'block';
      } else {
        chonTuyChonDiv.style.display = 'none';
      }
    }

    // Gọi khi trang vừa load
    toggleTuyChon();

    // Gọi mỗi khi thay đổi radio
    document.querySelectorAll('input[name="khoang_thoi_gian"]').forEach(radio => {
      radio.addEventListener('change', toggleTuyChon);
    });
  });
</script>
@endsection
