@extends('layouts.main')

@section('title', 'Danh Sách Tài Khoản')

@section('content')
<div class="container">
  <div class="page-inner">
    <div class="row">

      <!-- Phần bảng -->
      <div class="col-md-9">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
          <div class="dropdown me-2">
              <button class="btn btn-outline-secondary dropdown-toggle p-2" type="button"
                      id="dropdownBoPhan" data-bs-toggle="dropdown" aria-expanded="false">
                  ☰ 
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownBoPhan">
                  <li><a class="dropdown-item" href="{{ route('taikhoan.index') }}">Tất cả</a></li>
                  @foreach ($bophans as $bp)
                      <li>
                          <a class="dropdown-item" href="{{ route('taikhoan.index', ['MaBoPhan' => $bp->MaBoPhan]) }}">
                              {{ $bp->TenBoPhan }}
                          </a>
                      </li>
                  @endforeach
              </ul>
          </div>
      
          <h1 class="mb-0 flex-grow-1">Danh Sách Tài Khoản</h1>
      
          <a href="{{ route('taikhoan.create') }}" class="btn btn-primary">
              <i class="fa fa-plus"></i> Thêm mới
          </a>
      </div>

        <table class="table table-bordered table-striped">
          <thead style="background-color: #ffc0cb; color: black;">
            <tr>
              <th>STT</th>
              <th>Tên Nhân viên</th>
              <th>Tên Tài khoản</th>
              <th>Mật khẩu</th>
              <th style="width: 200px;">Hành động</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($taikhoans as $index => $taikhoan)
              <tr>
                <!-- Cột có sự kiện onclick toàn dòng trừ hành động -->
                <td onclick="window.location='{{ route('taikhoan.show', $taikhoan->TenTaiKhoan) }}'" style="cursor:pointer;">
                  {{ $loop->iteration }}
                </td>
                <td onclick="window.location='{{ route('taikhoan.show', $taikhoan->TenTaiKhoan) }}'" style="cursor:pointer;">
                  {{ $taikhoan->nhanvien->TenNhanVien ?? 'Chưa xác định' }}
                </td>
                <td onclick="window.location='{{ route('taikhoan.show', $taikhoan->TenTaiKhoan) }}'" style="cursor:pointer;">
                  {{ $taikhoan->TenTaiKhoan }}
                </td>
                <td onclick="window.location='{{ route('taikhoan.show', $taikhoan->TenTaiKhoan) }}'" style="cursor:pointer;">
                  {{ $taikhoan->MatKhauChuaMaHoa }}
                </td>
                <td>
                  <div class="d-flex gap-2">
                    <a href="{{ route('taikhoan.edit', $taikhoan->MaNhanVien) }}" class="btn btn-warning btn-sm">Đổi mật khẩu</a>
                    <form action="{{ route('taikhoan.destroy', $taikhoan->TenTaiKhoan) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa tài khoản này?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                    </form>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <!-- Phần lọc -->
      <div class="col-md-3">
        <div style="margin-top: 50px">
          <h5 class="mb-3">Bộ lọc</h5>
          <form action="{{ route('taikhoan.index') }}" method="GET">
            <div class="mb-3">
              <label for="TenNhanVien" class="form-label">Tìm kiếm theo tên nhân viên</label>
              <input type="text" name="TenNhanVien" id="TenNhanVien" class="form-control" value="{{ request('TenNhanVien') }}" placeholder="Nhập tên nhân viên">
            </div>

            <div class="mb-3">
              <label for="MaBoPhan" class="form-label">Chọn bộ phận</label>
              <select name="MaBoPhan" id="MaBoPhan" class="form-select">
                <option value="">-- Chọn bộ phận --</option>
                @foreach ($bophans as $bophan)
                  <option value="{{ $bophan->MaBoPhan }}" {{ request('MaBoPhan') == $bophan->MaBoPhan ? 'selected' : '' }}>
                    {{ $bophan->TenBoPhan }}
                  </option>
                @endforeach
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
    @if (session('success'))
        $.notify({
            title: 'Thành công',
            message: '{{ session('success') }}',
            icon: 'icon-bell'
        }, {
            type: 'success',
            animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutUp'
            },
        });
    @endif
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