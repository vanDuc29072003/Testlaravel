@extends('layouts.main')

@section('title', 'Thêm Tài Khoản')

@section('content')
<div class="container">
  <div class="page-inner">
    <div class="card shadow-sm">
      <div class="card-header">
        <h1 class="m-3">Thêm Tài Khoản Mới</h1>
      </div>
      <div class="card-body">
        <form action="{{ route('taikhoan.store') }}" method="POST">
          @csrf
          <div class="row">
            {{-- Cột 1: Thông tin nhân viên --}}
            <div class="col-md-6">
              <h4 class="mb-4 fw-bold text-primary">Thông tin nhân viên</h4>

              <div class="form-group mb-3">
                <label for="TenNhanVien">Tên Nhân viên</label>
                <input type="text" class="form-control" id="TenNhanVien" name="TenNhanVien"
                       placeholder="Nhập tên nhân viên" value="{{ old('TenNhanVien') }}" required>
              </div>

              <div class="form-group mb-3">
                <label for="Email">Email</label>
                <input type="email" class="form-control" id="Email" name="Email"
                       placeholder="Nhập email" value="{{ old('Email') }}" required>
              </div>

              <div class="form-group mb-3">
                <label for="GioiTinh">Giới tính</label>
                <select class="form-control" id="GioiTinh" name="GioiTinh" required>
                  <option value="">Chọn giới tính</option>
                  <option value="Nam" {{ old('GioiTinh') == 'Nam' ? 'selected' : '' }}>Nam</option>
                  <option value="Nữ" {{ old('GioiTinh') == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                </select>
              </div>

              <div class="form-group mb-3">
                <label for="NgaySinh">Ngày sinh</label>
                <input type="date" class="form-control" id="NgaySinh" name="NgaySinh"
                       value="{{ old('NgaySinh') }}" required>
              </div>

              <div class="form-group mb-3">
                <label for="SDT">Số điện thoại</label>
                <input type="text" class="form-control" id="SDT" name="SDT"
                       placeholder="Nhập số điện thoại" value="{{ old('SDT') }}" required>
              </div>

              <div class="form-group mb-3">
                <label for="DiaChi">Địa chỉ</label>
                <input type="text" class="form-control" id="DiaChi" name="DiaChi"
                       placeholder="Nhập địa chỉ" value="{{ old('DiaChi') }}" required>
              </div>

              <div class="form-group mb-3">
                <label for="MaBoPhan">Bộ phận</label>
                <select class="form-control" id="MaBoPhan" name="MaBoPhan" required>
                  <option value="">Chọn bộ phận</option>
                  @foreach ($bophans as $bp)
                    <option value="{{ $bp->MaBoPhan }}"
                        {{ old('MaBoPhan') == $bp->MaBoPhan ? 'selected' : '' }}>
                        {{ $bp->TenBoPhan }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>

            {{-- Cột 2: Thông tin tài khoản --}}
            <div class="col-md-6">
              <h4 class="mb-4 fw-bold text-primary">Thông tin tài khoản</h4>

              <div class="form-group mb-3">
                <label for="TenTaiKhoan">Tên Tài khoản</label>
                <input type="text" class="form-control" id="TenTaiKhoan" name="TenTaiKhoan"
                       placeholder="Nhập tên tài khoản" value="{{ old('TenTaiKhoan') }}" required>
              </div>

              <div class="form-group mb-3">
                <label for="MatKhauChuaMaHoa">Mật khẩu</label>
                <input type="text" class="form-control" id="MatKhauChuaMaHoa" name="MatKhauChuaMaHoa"
                       placeholder="Nhập mật khẩu" value="{{ old('MatKhauChuaMaHoa') }}" required>
              </div>
            </div>
          </div>

          {{-- Nút hành động --}}
          <div class="d-flex justify-content-between mt-4">
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save"></i> Lưu
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
@endsection
