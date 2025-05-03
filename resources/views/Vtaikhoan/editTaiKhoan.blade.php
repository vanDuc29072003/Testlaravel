@extends('layouts.main')

@section('title', 'Sửa Tài Khoản')

@section('content')
<div class="container mt-5">
  <div class="page-inner">
    <div class="row justify-content-center">
      <div class="col-md-8" style="margin-top: 20px;padding: 20px; max-width: 600px;">

        <div class="card shadow-sm">
          <div class="card-header">
            <h1 class="m-3">Sửa Tài Khoản</h1>
          </div>

          <div class="card-body">
            <form action="{{ route('taikhoan.update', $taikhoan->TenTaiKhoan) }}" method="POST">
              @csrf
              @method('PUT')

              <div class="form-group mb-3">
                <label for="TenNhanVien" class="form-label fw-bold">Tên Nhân viên</label>
                <input type="text" id="TenNhanVien" class="form-control" value="{{ $taikhoan->nhanvien->TenNhanVien }}" readonly>
              </div>

              <div class="form-group mb-3">
                <label for="TenTaiKhoan" class="form-label fw-bold">Tên Tài khoản</label>
                <input type="text" id="TenTaiKhoan" class="form-control" value="{{ $taikhoan->TenTaiKhoan }}" readonly>
              </div>

              <div class="form-group mb-3">
                <label for="MatKhauChuaMaHoa" class="form-label fw-bold">Mật khẩu mới</label>
                <input type="password" name="MatKhauChuaMaHoa" id="MatKhauChuaMaHoa" class="form-control" placeholder="Nhập mật khẩu mới" required>
                @if ($errors->has('MatKhauChuaMaHoa'))
                <div class="text-danger">
                    {{ $errors->first('MatKhauChuaMaHoa') }}
                </div>
               @endif
              </div>

              <div class="d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-save"></i> Cập nhật
                </button>
                <a href="{{ route('taikhoan.index') }}" class="btn btn-secondary">
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
