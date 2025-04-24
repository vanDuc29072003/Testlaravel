@extends('layouts.main')

@section('title', 'Danh sách Phiếu Nhập')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <!-- Bảng danh sách phiếu nhập chờ duyệt -->
                <div class="col-12">
                    <div class="table-responsive">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="mb-0">Danh sách Phiếu Chờ Duyệt</h3>
                            <a href="{{ route('dsphieunhap.add') }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Thêm mới
                            </a>
                        </div>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">Mã Phiếu Nhập</th>
                                    <th scope="col">Ngày Nhập</th>
                                    <th scope="col">Nhà Cung Cấp</th>
                                    <th scope="col">Nhân Viên Nhập</th>
                                    <th scope="col">Tổng Giá Trị</th>
                                    <th scope="col">Trạng Thái</th>
                                    <th scope="col">Cập Nhật</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dsPhieuNhapChoDuyet->where('TrangThai', 0) as $phieuNhap)
                                    <tr class="text-center"
                                        onclick="window.location='{{ route('phieunhap.show', $phieuNhap->MaPhieuNhap) }}'"
                                        style="cursor: pointer;">
                                        <td>{{ $phieuNhap->MaPhieuNhap }}</td>
                                        <td>{{ $phieuNhap->NgayNhap }}</td>
                                        <td>{{ $phieuNhap->nhaCungCap->TenNhaCungCap ?? 'Không xác định' }}</td>
                                        <td>{{ $phieuNhap->nhanVien->TenNhanVien ?? 'Không xác định' }}</td>
                                        <td>{{ number_format($phieuNhap->TongTien, 0, ',', '.') }} VND</td>
                                        <td>
                                            <span class="badge bg-warning text-dark">Chờ duyệt</span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('dsphieunhap.edit', $phieuNhap->MaPhieuNhap) }}"
                                                    class="btn btn-warning btn-sm text-black">
                                                    <i class="fa fa-edit"></i> Sửa
                                                </a>
                                                <form action="{{ route('phieunhap.approve', $phieuNhap->MaPhieuNhap) }}" method="POST"
                                                    class="d-inline-block">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="button" class="btn btn-success btn-sm"
                                                        onclick="event.stopPropagation(); confirmApprove(this)">
                                                        <i class="fa fa-check"></i> Duyệt
                                                    </button>
                                                </form>
                                                <form action="{{ route('dsphieunhap.delete', $phieuNhap->MaPhieuNhap) }}" method="POST"
                                                    class="d-inline-block"> 
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        onclick="event.stopPropagation(); confirmDelete(this)">
                                                        <i class="fa fa-times"></i> Từ Chối
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <!-- Pagination cho trạng thái chờ duyệt -->
                                <nav aria-label="Page navigation example">
                                    {{ $dsPhieuNhapChoDuyet->appends(request()->query())->links('pagination::bootstrap-5') }}
                                </nav>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <h3 class="mb-3">Phiếu Nhập Đã Duyệt</h3><!-- Bảng danh sách phiếu nhập đã duyệt -->
                <div class="col-9">
                    <div class="table-responsive">
                     
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">Mã Phiếu Nhập</th>
                                    <th scope="col">Ngày Nhập</th>
                                    <th scope="col">Nhà Cung Cấp</th>
                                    <th scope="col">Nhân Viên Nhập</th>
                                    <th scope="col">Tổng Giá Trị</th>
                                    <th scope="col">Trạng Thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dsPhieuNhapDaDuyet->where('TrangThai', 1) as $phieuNhap)
                                    <tr class="text-center"
                                        onclick="window.location='{{ route('phieunhap.show', $phieuNhap->MaPhieuNhap) }}'"
                                        style="cursor: pointer;">
                                        <td>{{ $phieuNhap->MaPhieuNhap }}</td>
                                        <td>{{ $phieuNhap->NgayNhap }}</td>
                                        <td>{{ $phieuNhap->nhaCungCap->TenNhaCungCap }}</td>
                                        <td>{{ $phieuNhap->nhanVien->TenNhanVien }}</td>
                                        <td>{{ number_format($phieuNhap->TongTien, 0, ',', '.') }} VND</td>
                                        <td>
                                            <span class="badge bg-success text-white">Đã duyệt</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <!-- Pagination cho trạng thái đã duyệt -->
                                <nav aria-label="Page navigation example">
                                    {{ $dsPhieuNhapDaDuyet->appends(request()->query())->links('pagination::bootstrap-5') }}
                                </nav>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Form tìm kiếm -->
                <div class="col-3">
                    <form method="GET" action="{{ route('dsphieunhap') }}" class="p-3 border rounded">
                        <h5 class="mb-3">Tìm kiếm</h5>
                        <div class="mb-3">
                            <label for="MaPhieuNhap" class="form-label">Mã Phiếu Nhập</label>
                            <input type="text" name="MaPhieuNhap" id="MaPhieuNhap" class="form-control"
                                placeholder="Nhập mã phiếu nhập" value="{{ request('MaPhieuNhap') }}">
                        </div>
                        <div class="mb-3">
                            <label for="NgayNhap" class="form-label">Ngày Nhập</label>
                            <input type="date" name="NgayNhap" id="NgayNhap" class="form-control"
                                value="{{ request('NgayNhap') }}">
                        </div>
                        <div class="mb-3">
                            <label for="TenNhaCungCap" class="form-label">Nhà Cung Cấp</label>
                            <input type="text" name="TenNhaCungCap" id="TenNhaCungCap" class="form-control"
                                placeholder="Nhập tên nhà cung cấp" value="{{ request('TenNhaCungCap') }}">
                        </div>
                        <div class="mb-3">
                            <label for="TenNhanVien" class="form-label">Nhân Viên Nhập</label>
                            <input type="text" name="TenNhanVien" id="TenNhanVien" class="form-control"
                                placeholder="Nhập tên nhân viên" value="{{ request('TenNhanVien') }}">
                        </div>
                        <div class="mb-3">
                            <label for="TongTien" class="form-label">Tổng Giá Trị</label>
                            <input type="number" name="TongTien" id="TongTien" class="form-control"
                                placeholder="Nhập tổng giá trị" value="{{ request('TongTien') }}">
                        </div>
                        <div class="mb-3">
                            <label for="SoLuong" class="form-label">Tổng Số Lượng</label>
                            <input type="number" name="SoLuong" id="SoLuong" class="form-control"
                                placeholder="Nhập tổng số lượng" value="{{ request('SoLuong') }}">
                        </div>
                        <div class="mb-3">
                            <label for="TrangThai" class="form-label">Trạng Thái</label>
                            <select name="TrangThai" id="TrangThai" class="form-control">
                                <option value="1" {{ request('TrangThai') == '1' ? 'selected' : '' }}>Đã duyệt</option>
                             
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fa fa-search"></i> Tìm kiếm
                        </button>
                    </form>
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
        function confirmApprove(button) {
            swal({
                title: 'Sau khi duyệt số lượng linh kiện sẽ được thêm vào kho?',
                text: "Hành động này không thể hoàn tác!",
                icon: 'warning',
                buttons: {
                    confirm: {
                        text: 'Đồng ý',
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