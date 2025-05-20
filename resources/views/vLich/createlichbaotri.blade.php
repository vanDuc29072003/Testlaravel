@extends('layouts.main')

@section('title', 'Thêm Lịch Bảo trì')

@section('content')
<div class="container">
  <div class="page-inner">
    <div class="card">
      <div class="card-header">
        <h1 class="m-3">Thêm Lịch Bảo trì</h1>
      </div>
      <div class="card-body">

        <form action="{{ route('lichbaotri.store') }}" method="POST" id="formLichBaoTri">
          @csrf
           <!-- Kiểu lịch -->
          <div class="mb-3">
            <label class="form-label d-block">Chọn loại lịch bảo trì:</label>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="checkboxDinhKy" name="is_dinh_ky" value="1" {{ old('is_dinh_ky') ? 'checked' : '' }}>
              <label class="form-check-label" for="checkboxDinhKy">Theo chu kỳ</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="checkboxDotXuat" name="is_dot_xuat" value="1" {{ old('is_dot_xuat') ? 'checked' : '' }}>
              <label class="form-check-label" for="checkboxDotXuat">Phát sinh đột xuất</label>
            </div>
            
          </div>
          

          <!-- Ngày bảo trì -->
          <div class="mb-3">
            <label for="NgayBaoTri" class="form-label">Ngày bảo trì bắt đầu</label>
            <input type="date" name="NgayBaoTri" id="NgayBaoTri" class="form-control" value="{{ old('NgayBaoTri') }}"     
             required>
          </div>

          <!-- Tên máy -->
          <div class="mb-3">
            <label for="MaMay" class="form-label">Tên máy</label>
            <select name="MaMay" id="MaMay" class="form-select" required>
              <option value="">-- Chọn máy --</option>
              @foreach ($machines as $machine)
                <option value="{{ $machine->MaMay }}" {{ old('MaMay') == $machine->MaMay ? 'selected' : '' }}>
                  {{ $machine->TenMay }}
                </option>
              @endforeach
            </select>
          </div>

         <!-- Mô tả -->
          <div class="mb-3">
            <label for="MoTa" class="form-label">Mô tả</label>
            <input type="text" name="MoTa" id="MoTa" class="form-control" value="{{ old('MoTa') }}" required>
          </div>

          <!-- Nút -->
         
        </form>
      </div>
      <div class="card-footer">
        <button type="submit" id="btnLuu" class="btn btn-primary" form="formLichBaoTri" disabled>Lưu lịch </button>

        <a href="{{ route('lichbaotri') }}" class="btn btn-secondary">Quay lại</a>
    </div>
  </div>
</div>
@endsection
@section('scripts')

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const dinhKy = document.getElementById('checkboxDinhKy');
    const dotXuat = document.getElementById('checkboxDotXuat');
    const btnLuu = document.getElementById('btnLuu');

    function updateCheckboxState() {
      // Kích hoạt nút nếu có một checkbox được chọn
      if (dinhKy.checked || dotXuat.checked) {
        btnLuu.disabled = false;
      } else {
        btnLuu.disabled = true;
      }

      // Chỉ cho phép chọn một loại
      if (dinhKy.checked) {
        dotXuat.checked = false;
      } else if (dotXuat.checked) {
        dinhKy.checked = false;
      }
    }

    dinhKy.addEventListener('change', updateCheckboxState);
    dotXuat.addEventListener('change', updateCheckboxState);

    // Khởi tạo trạng thái ban đầu (nếu user nhấn back)
    updateCheckboxState();
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
                animate: { enter: 'animated fadeInDown', exit: 'animated fadeOutUp' },
            });
        @endif
    </script>
@endsection
