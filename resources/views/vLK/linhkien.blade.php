@extends('layouts.main')

@section('title', 'Danh sách Linh Kiện')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-xl-10 col-sm-12">
                    <div class="table-responsive">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h1 class="mb-0">Danh sách Linh Kiện</h1>
                            <a href="{{ route('linhkien.add') }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Thêm mới
                            </a>
                        </div>
                        <table class="table table-responsive table-bordered table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">Mã Linh Kiện</th>
                                    <th scope="col">Tên Linh Kiện</th>
                                    <th scope="col">Đơn Vị Tính</th>
                                    <th scope="col">Số Lượng</th>
                                    <th scope="col">Nhà Cung Cấp</th>
                                    <th scope="col">Cập Nhật</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dsLinhKien as $linhKien)
                                    <tr class="text-center" onclick="window.location='{{ route('linhkien.detail', $linhKien->MaLinhKien) }}'"
                                        style="cursor: pointer;">
                                        <td>{{ $linhKien->MaLinhKien }}</td>
                                        <td>{{ $linhKien->TenLinhKien }}</td>
                                        <td>{{ $linhKien->donViTinh->TenDonViTinh ?? 'Không xác định' }}</td>
                                        <td>{{ $linhKien->SoLuong }}</td>
                                        <td>
                                            <ul class="list-group list-group-flush">
                                                @foreach ($linhKien->nhaCungCaps as $nhaCungCap)
                                                    <li class="list-group-item">{{ $nhaCungCap->TenNhaCungCap }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('linhkien.edit', $linhKien->MaLinhKien) }}"
                                                    class="btn btn-warning btn-sm text-black">
                                                    <i class="fa fa-edit"></i> Sửa
                                                </a>
                                                <form action="{{ route('linhkien.delete', $linhKien->MaLinhKien) }}" method="POST"
                                                    class="d-inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        onclick="event.stopPropagation(); confirmDelete(this)">
                                                        <i class="fa fa-trash"></i> Xóa
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <!-- Pagination -->
                                <nav aria-label="Page navigation example">
                                    {{ $dsLinhKien->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
                                </nav>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-12 p-0">
                    <div>
                        <form method="GET" action="{{ route('linhkien') }}" class="p-3 border rounded fixed-search-form">
                            <h5 class="mb-3">Tìm kiếm</h5>
                            <div class="mb-3">
                                <label for="MaLinhKien" class="form-label">Mã linh kiện</label>
                                <input type="text" name="MaLinhKien" id="MaLinhKien" class="form-control" placeholder="Vui lòng nhập"
                                    value="{{ request('MaLinhKien') }}">
                            </div>
                            <div class="mb-3">
                                <label for="TenLinhKien" class="form-label">Tên linh kiện</label>
                                <input type="text" name="TenLinhKien" id="TenLinhKien" class="form-control"
                                    placeholder="Vui lòng nhập" value="{{ request('TenLinhKien') }}">
                            </div>
                            <div class="mb-3">
                                <label for="TenDonViTinh" class="form-label">Đơn Vị Tính</label>
                                <input type="text" name="TenDonViTinh" id="TenDonViTinh" class="form-control"
                                    placeholder="Vui lòng nhập" value="{{ request('TenDonViTinh') }}">
                            </div>
                            <div class="mb-3">
                                <label for="SoLuong" class="form-label">Số lượng</label>
                                <input type="number" name="SoLuong" id="SoLuong" class="form-control"
                                    placeholder="Vui lòng nhập" value="{{ request('SoLuong') }}">
                            </div>
                            <div class="mb-3">
                                <label for="TenNhaCungCap" class="form-label">Nhà cung cấp</label>
                                <input type="text" name="TenNhaCungCap" id="TenNhaCungCap" class="form-control"
                                    placeholder="Vui lòng nhập" value="{{ request('TenNhaCungCap') }}">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fa fa-search"></i> Tìm kiếm
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
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