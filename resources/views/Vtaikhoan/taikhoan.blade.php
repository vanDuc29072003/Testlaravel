@extends('layouts.main')

@section('title', 'Danh Sách Tài Khoản')

@section('content')
<div class="container">
  <div class="page-inner">
    <div class="row">

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

        <table class="table table-responsive table-bordered table-hover">
          <thead>
            <tr class="text-center">
              <th>STT</th>
              <th>Tên Nhân viên</th>
              <th>Tên Tài khoản</th>
              <th>Mật khẩu</th>
              <th style="width: 200px;">Hành động</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($taikhoans as $index => $taikhoan)
              <tr class="text-center">
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
                <td>
                  <span class="password-mask" id="pw-{{ $loop->index }}">********</span>
                  <span class="password-real d-none" id="pw-real-{{ $loop->index }}">{{ $taikhoan->MatKhauChuaMaHoa }}</span>
                  <button type="button" class="btn btn-link btn-sm p-0" onclick="togglePassword({{ $loop->index }})">
                    <i class="fa fa-eye text-black" id="eye-{{ $loop->index }}"></i>
                  </button>
                </td>
                <td>
                  <div class="d-flex gap-2">
                    <a href="{{ route('taikhoan.edit', $taikhoan->MaNhanVien) }}" class="btn btn-warning btn-sm">Đổi mật khẩu</a>
                    <form action="{{ route('taikhoan.destroy', $taikhoan->TenTaiKhoan) }}" method="POST" class="d-inline-block">
                      @csrf
                      @method('DELETE')
                      <button type="button" class="btn btn-danger btn-sm"
                          onclick="event.stopPropagation(); confirmDelete(this)">Xóa
                      </button>
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
          <form action="{{ route('taikhoan.index') }}" method="GET" class="p-3 border rounded">
            <h5 class="mb-3">Bộ lọc</h5>
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

            <button type="submit" class="btn btn-primary w-100">
              <i class="fa fa-filter"></i> Lọc</button>
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
<script>
function togglePassword(index) {
    const mask = document.getElementById('pw-' + index);
    const real = document.getElementById('pw-real-' + index);
    const eye = document.getElementById('eye-' + index);
    if (mask.classList.contains('d-none')) {
        mask.classList.remove('d-none');
        real.classList.add('d-none');
        eye.classList.remove('fa-eye-slash');
        eye.classList.add('fa-eye');
    } else {
        mask.classList.add('d-none');
        real.classList.remove('d-none');
        eye.classList.remove('fa-eye');
        eye.classList.add('fa-eye-slash');
    }
}
</script>
<script>
  function confirmDelete(button) {
            swal({
                title: 'Bạn có chắc chắn?',
                text: "Hành động này không thể hoàn tác!",
                icon: 'warning',
                buttons: {
                    confirm: {
                        text: 'Xóa',
                        className: 'btn btn-danger'
                    },
                    cancel: {
                        text: 'Hủy',
                        visible: true,
                        className: 'btn btn-success'
                    }
                }
            }).then((willDelete) => {
                if (willDelete) {
                    button.closest('form').submit(); // Gửi form
                } else {
                    swal.close(); // Đóng hộp thoại
                }
            });
        }
</script>
@endsection