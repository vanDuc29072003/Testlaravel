@extends('layouts.main')

@section('title', 'Chi Tiết Phiếu Nhập')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card mx-auto">
                        <div class="card-header">
                            <div class="mt-3 mx-3 d-flex justify-content-between">
                                <h2 class="ps-3 mb-0">Thông Tin Phiếu Nhập</h2>
                                <div class="d-flex justify-content-end">
                                    @if ($phieuNhap->TrangThai == 0)
                                        <a href="{{ route('dsphieunhap.edit', ['MaPhieuNhap' => $phieuNhap->MaPhieuNhap, 'new' => true]) }}"
                                                class="btn btn-warning  text-black">
                                                    <i class="fa fa-edit"></i> Sửa
                                        </a>
                                    @else
                                        <a href="{{ route('phieunhap.exportPDF', $phieuNhap->MaPhieuNhap) }}"
                                            class="btn btn-black btn-border ms-3">
                                            <i class="fas fa-file-download"></i> Xuất FILE PDF
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-3 px-5">
                            <h5 class="fst-italic ms-3">Thông tin chung</h5>
                            <table class="table table-bordered table-striped table-responsive">
                                <tbody>
                                    <tr>
                                        <th>Mã Phiếu Nhập</th>
                                        <td>{{ $phieuNhap->MaHienThi }}</td>
                                        <th>Ngày Nhập</th>
                                        <td>{{ \Carbon\Carbon::parse($phieuNhap->NgayNhap)->format('H:i d/m/Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Người Lập Phiếu:</th>
                                        <td>{{ $phieuNhap->nhanVien->TenNhanVien ?? 'Không xác định' }}</td>
                                        <th>Nhà Cung Cấp</th>
                                        <td>{{ $phieuNhap->nhaCungCap->TenNhaCungCap }}</td>
                                    </tr>
                                    <tr>
                                        <th>Trạng Thái</th>
                                        <td>
                                            @if ($phieuNhap->TrangThai == 0)
                                                <span class="badge bg-warning text-dark">Chờ duyệt</span>
                                            @elseif ($phieuNhap->TrangThai == 1)
                                                <span class="badge bg-success text-white">Đã nhập kho</span>
                                            @elseif ($phieuNhap->TrangThai == 2)
                                                <span class="badge bg-danger text-white">Bị từ chối</span>

                                            @endif
                                        </td>
                                        <th>Ghi Chú</th>
                                        <td>{{ $phieuNhap->GhiChu ?? 'Không có' }}</td>
                                    </tr>
                                    @if ($phieuNhap->TrangThai == 1)
                                        <tr>
                                            <th>Người Duyệt</th>
                                            <td>{{ $phieuNhap->nhanVienDuyet->TenNhanVien ?? 'Không xác định' }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                            <!-- Danh sách chi tiết phiếu nhập -->
                            <h5 class="fst-italic ms-3">Danh sách linh kiện</h5>
                            <table class="table table-responsive table-bordered">
                                <thead>
                                    <tr>
                                        <th>Mã Linh Kiện</th>
                                        <th>Tên Linh Kiện</th>
                                        <th>Số Lượng</th>
                                        <th>ĐVT</th>
                                        <th>Giá Nhập</th>
                                        <th>Thành Tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($phieuNhap->chiTietPhieuNhap as $chiTiet)
                                        <tr>
                                            <td>{{ $chiTiet->linhKien->MaLinhKien }}</td>
                                            <td>{{ $chiTiet->linhKien->TenLinhKien }}</td>
                                            <td>{{ $chiTiet->SoLuong }}</td>
                                            <td>{{ $chiTiet->linhKien->donViTinh->TenDonViTinh ?? 'Không xác định' }}</td>
                                            <td>{{ number_format($chiTiet->GiaNhap, 0, ',', '.') }} VND</td>
                                            <td>{{ number_format($chiTiet->TongCong, 0, ',', '.') }} VND</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th colspan="5" class="text-end">Tổng số lượng</th>
                                        <td>{{ $phieuNhap->TongSoLuong }}</td>
                                    </tr>
                                    <!-- Dòng tổng tiền -->
                                    <tr>
                                        <th colspan="5" class="text-end">Tổng tiền</th>
                                        <td>{{ number_format($phieuNhap->TongTien, 0, ',', '.') }} VND</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <!-- Nút quay lại -->
                            <div class="m-3 d-flex justify-content-between">
                                <a href="{{ route('dsphieunhap') }}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> Quay lại
                                </a>
                                @if ($phieuNhap->TrangThai == 0)
                                    <div class="d-flex justify-content-end">
                                        <form action="{{ route('phieunhap.approve', $phieuNhap->MaPhieuNhap) }}" method="POST"
                                            class="d-inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <button type="button" class="btn btn-success" onclick="confirmApprove(this)">
                                                <i class="fa fa-check"></i> Duyệt
                                            </button>
                                        </form>
                                        <form action="{{ route('dsphieunhap.delete', $phieuNhap->MaPhieuNhap) }}" method="POST"
                                            class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger ms-3" onclick="confirmDelete(this)">
                                                <i class="fa fa-times"></i> Từ Chối
                                            </button>
                                        </form>
                                    </div>
                                @endif
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
        function confirmApprove(button) {
            swal({
                title: 'Xác nhận các thông tin là chính xác',
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
        function confirmDelete(button) {
            swal({
                title: 'Bạn có chắc chắn?',
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