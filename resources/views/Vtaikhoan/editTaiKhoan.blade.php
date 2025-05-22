@extends('layouts.main')

@section('title', 'Sửa Tài Khoản')

@section('content')
<div class="container">
  <div class="page-inner">
    <div class="row d-flex justify-content-center">
      <div class="col-md-8 col-lg-7 col-xl-5">
        <div class="card">
          <div class="card-header">
            <h1 class="mt-3 mx-3">Đổi mật khẩu</h1>
          </div>

          <div class="card-body">
            <form id="formMatKhau" action="{{ route('taikhoan.update', $taikhoan->MaNhanVien) }}" method="POST">

              @csrf
              @method('PUT')

              <div class="form-group">
                <label for="TenNhanVien" class="form-label">Tên Nhân viên</label>
                <input type="text" id="TenNhanVien" class="form-control" value="{{ $taikhoan->nhanvien->TenNhanVien }}" readonly>
              </div>

              <div class="form-group">
                <label for="TenTaiKhoan" class="form-label">Tên Tài khoản</label>
                <input type="text" id="TenTaiKhoan" class="form-control" value="{{ $taikhoan->TenTaiKhoan }}" readonly>
              </div>

              <div class="form-group">
                <label for="MatKhauChuaMaHoa" class="form-label">Mật khẩu mới</label>
                <input type="password" name="MatKhauChuaMaHoa" id="MatKhauChuaMaHoa" class="form-control" placeholder="Nhập mật khẩu mới" required>
                @if ($errors->has('MatKhauChuaMaHoa'))
                <div class="text-danger">
                    {{ $errors->first('MatKhauChuaMaHoa') }}
                </div>
               @endif
              </div>
            </form>
          </div>
          <div class="card-footer">
            <div class="d-flex justify-content-between m-3">
              <a href="{{ route('taikhoan.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
              </a>
              <button type="submit" class="btn btn-primary" form="formMatKhau">
                <i class="fas fa-save"></i> Cập nhật
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
