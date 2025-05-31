@extends('layouts.main')

@section('title', 'Thêm Lịch Bảo trì')

@section('content')
  <div class="container">
    <div class="page-inner">
      <div class="row justify-content-center">
        <div class="col-xl-6 col-md-8 col-sm-12">
          <div class="card">
            <div class="card-header">
              <h1 class="mt-3 mx-3">Thêm Lịch Bảo trì</h1>
            </div>
            <div class="card-body">
              <form action="{{ route('lichbaotri.store') }}" method="POST" id="formLichBaoTri">
                @csrf
                <!-- Kiểu lịch -->
                <div class="form-group">
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
                <div class="form-group">
                  <label for="NgayBaoTri" class="form-label">Ngày bảo trì bắt đầu</label>
                  <input type="date" name="NgayBaoTri" id="NgayBaoTri" class="form-control" value="{{ old('NgayBaoTri') }}"     
                      min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                </div>

                <!-- Tên máy -->
                <div class="form-group">
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
                <div class="form-group">
                <label for="MoTa" class="form-label">Mô tả</label>
                <textarea type="text" name="MoTa" id="MoTa" class="form-control" value="{{ old('MoTa') }}" placeholder="Vui lòng nhập..." required></textarea>
                </div>

              </form>
            </div>
            <div class="card-footer">
              <div class="form-group d-flex justify-content-between">
                <a href="{{ route('lichbaotri') }}" class="btn btn-secondary">
                  <i class="fa fa-arrow-left"></i> Quay lại</a>
                <button type="submit" id="btnLuu" class="btn btn-primary" form="formLichBaoTri" disabled>
                  <i class="fa fa-save"></i> Lưu lịch </button>
              </div>
            </div>
          </div>
        </div>
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

    function updateCheckboxState(e) {
      // Nếu vừa chọn dinhKy thì bỏ chọn dotXuat
      if (e && e.target === dinhKy && dinhKy.checked) {
        dotXuat.checked = false;
      }
      // Nếu vừa chọn dotXuat thì bỏ chọn dinhKy
      if (e && e.target === dotXuat && dotXuat.checked) {
        dinhKy.checked = false;
      }

      // Kích hoạt nút nếu có một checkbox được chọn
      btnLuu.disabled = !(dinhKy.checked || dotXuat.checked);
    }

    dinhKy.addEventListener('change', updateCheckboxState);
    dotXuat.addEventListener('change', updateCheckboxState);

    // Khởi tạo trạng thái ban đầu (nếu user nhấn back)
    updateCheckboxState();
  });
</script>

@endsection
