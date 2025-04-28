@extends('layouts.main')

@section('title', 'Thêm Tài Khoản')

@section('content')
<div class="container mt-5" ">
  <div class="page-inner">
    <div class="row justify-content-center">
      <div class="col-md-8" style="margin-top: 20px;padding: 20px; max-width: 600px;">

        <div class="card shadow-lg rounded-4">
          <div class="card-header bg-primary text-white text-center">
            <h2 class="mb-0">Thêm Tài Khoản Mới</h2>
          </div>

          <div class="card-body p-5">

            <form action="{{ route('taikhoan.store') }}" method="POST">
              @csrf

              <div class="mb-4">
                <label for="MaNhanVien" class="form-label fw-bold">Tên Nhân viên</label>
                <select name="MaNhanVien" id="MaNhanVien" class="form-select form-select-lg" required>
                  <option value="">-- Chọn Nhân viên --</option>
                  @foreach ($nhanviens as $nhanvien)
                    <option value="{{ $nhanvien->MaNhanVien }}">{{ $nhanvien->TenNhanVien }}</option>
                  @endforeach
                </select>
              </div>

              <div class="mb-4">
                <label for="TenTaiKhoan" class="form-label fw-bold">Tên Tài khoản</label>
                <input type="text" name="TenTaiKhoan" id="TenTaiKhoan" class="form-control form-control-lg" required>
              </div>

              <div class="mb-4">
                <label for="MatKhauChuaMaHoa" class="form-label fw-bold">Mật khẩu (chưa mã hóa)</label>
                <input type="text" name="MatKhauChuaMaHoa" id="MatKhauChuaMaHoa" class="form-control form-control-lg" required>
              </div>

              <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success btn-lg w-45">
                  <i class="fas fa-save"></i> Lưu
                </button>

                <a href="{{ route('taikhoan.index') }}" class="btn btn-secondary btn-lg w-45">
                  <i class="fas fa-arrow-left"></i> Quay lại
                </a>
              </div>

            </form>

          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
