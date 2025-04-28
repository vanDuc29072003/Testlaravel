@extends('layouts.main')

@section('title', 'Sửa Tài Khoản')

@section('content')
<div class="container mt-5">
  <div class="page-inner">
    <div class="row justify-content-center">
      <div class="col-md-8" style="margin-top: 20px;padding: 20px; max-width: 600px;">

        <div class="card shadow-lg rounded-4">
          <div class="card-header bg-primary text-white text-center">
            <h2 class="mb-0">Sửa Tài Khoản</h2>
          </div>

          <div class="card-body p-5">

            <form action="{{ route('taikhoan.update', $taikhoan->TenTaiKhoan) }}" method="POST">
              @csrf
              @method('PUT')

              <div class="mb-4">
                <label for="TenNhanVien" class="form-label fw-bold">Tên Nhân viên</label>
                <input type="text" id="TenNhanVien" class="form-control form-control-lg" value="{{ $taikhoan->nhanvien->TenNhanVien }}" readonly>
              </div>

              <div class="mb-4">
                <label for="TenTaiKhoan" class="form-label fw-bold">Tên Tài khoản</label>
                <input type="text" id="TenTaiKhoan" class="form-control form-control-lg" value="{{ $taikhoan->TenTaiKhoan }}" readonly>
              </div>

              <div class="mb-4">
                <label for="MatKhauChuaMaHoa" class="form-label fw-bold">Mật khẩu mới</label>
                <input type="password" name="MatKhauChuaMaHoa" id="MatKhauChuaMaHoa" class="form-control form-control-lg" placeholder="Nhập mật khẩu mới" required>
              </div>

              <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success btn-lg w-45">
                  <i class="fas fa-save"></i> Cập nhật
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
