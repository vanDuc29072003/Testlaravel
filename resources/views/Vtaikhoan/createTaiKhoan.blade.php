@extends('layouts.main')

@section('title', 'Thêm Tài Khoản')

@section('content')
  <div class="container">
    <div class="page-inner">
    <div class="row d-flex justify-content-center">
      <div class="col-md-9 col-xl-7">
      <div class="card">
        <div class="card-header">
        <h1 class="mt-3 mx-3">Thêm tài khoản mới</h1>
        </div>
        <div class="card-body">
        <form id="formTaiKhoan" action="{{ route('taikhoan.store') }}" method="POST">
          @csrf
          <div class="row">
          {{-- Cột 1: Thông tin nhân viên --}}
          <div class="col-md-6">
            <h5 class="fst-italic ms-3">Thông tin nhân viên</h5>

            <div class="form-group">
            <label for="TenNhanVien">Tên Nhân viên</label>
            <input type="text" class="form-control" id="TenNhanVien" name="TenNhanVien"
              placeholder="Nhập tên nhân viên" value="{{ old('TenNhanVien') }}" required>
            </div>

            <div class="row m-0">
            <div class="col-md-5 p-0">
              <div class="form-group">
              <label for="GioiTinh">Giới tính</label>
              <select class="form-control" id="GioiTinh" name="GioiTinh" required>
                <option value="">Chọn giới tính</option>
                <option value="Nam" {{ old('GioiTinh') == 'Nam' ? 'selected' : '' }}>Nam</option>
                <option value="Nữ" {{ old('GioiTinh') == 'Nữ' ? 'selected' : '' }}>Nữ</option>
              </select>
              </div>
            </div>

            <div class="col-md-7 p-0">
              <div class="form-group">
              <label for="NgaySinh">Ngày sinh</label>
              <input type="date" class="form-control" id="NgaySinh" name="NgaySinh"
                value="{{ old('NgaySinh') }}" required>
              </div>
            </div>
            </div>

            <div class="form-group">
              <label for="SDT">Số điện thoại</label>
              <input type="text" class="form-control @error('SDT') is-invalid @enderror" 
                    id="SDT" name="SDT" 
                    value="{{ old('SDT') }}" placeholder="Nhập số điện thoại" required>
              @error('SDT')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="Email">Email</label>
              <input type="email" class="form-control @error('Email') is-invalid @enderror" 
                    id="Email" name="Email" 
                    value="{{ old('Email') }}" placeholder="Nhập email" required>
              @error('Email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
            <label for="DiaChi">Địa chỉ</label>
            <input type="text" class="form-control" id="DiaChi" name="DiaChi" placeholder="Nhập địa chỉ"
              value="{{ old('DiaChi') }}" required>
            </div>

          </div>

          {{-- Cột 2: Thông tin tài khoản --}}
          <div class="col-md-6">
            <h5 class="fst-italic ms-3">Thông tin tài khoản</h5>

            <div class="form-group">
            <label for="MaBoPhan">Bộ phận</label>
            <select class="form-control" id="MaBoPhan" name="MaBoPhan" required>
              <option value="">Chọn bộ phận</option>
              @foreach ($bophans as $bp)
          <option value="{{ $bp->MaBoPhan }}" {{ old('MaBoPhan') == $bp->MaBoPhan ? 'selected' : '' }}>
          {{ $bp->TenBoPhan }}
          </option>
        @endforeach
            </select>
            </div>
            <div class="form-group">
            <label for="TenTaiKhoan">Tên Tài khoản</label>
            <input type="text" class="form-control" id="TenTaiKhoan" name="TenTaiKhoan"
              value="{{ old('TenTaiKhoan') }}" readonly>
            </div>

            <div class="form-group">
            <label for="MatKhauChuaMaHoa">Mật khẩu</label>
            <input type="text" class="form-control" id="MatKhauChuaMaHoa" name="MatKhauChuaMaHoa"
              placeholder="Nhập mật khẩu" value="{{ old('MatKhauChuaMaHoa', 'TKhoa12345@') }}" readonly>
            </div>
          </div>

          </div>

          {{-- Nút hành động --}}

        </form>
        </div>
        <div class="card-footer">
        <div class="d-flex justify-content-between m-3">
          <a href="{{ route('taikhoan.index') }}" class="btn btn-secondary">
          <i class="fas fa-arrow-left"></i> Quay lại
          </a>
          <button type="submit" class="btn btn-primary" form="formTaiKhoan">
          <i class="fas fa-save"></i> Lưu
          </button>
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
    const boPhanSelect = document.getElementById('MaBoPhan');
    const tenTaiKhoanInput = document.getElementById('TenTaiKhoan');

    const tenRutGonMap = {
    @foreach ($bophans as $bp)
      '{{ $bp->MaBoPhan }}': '{{ $bp->TenRutGon }}',
    @endforeach
    };

    const nextMaNhanVien = {{ $maNhanVien }};

    boPhanSelect.addEventListener('change', function () {
    const maBoPhan = this.value;
    const rutGon = tenRutGonMap[maBoPhan] || '';
    if (rutGon) {
      tenTaiKhoanInput.value = rutGon + nextMaNhanVien;
    } else {
      tenTaiKhoanInput.value = '';
    }
    });
  </script>
@endsection