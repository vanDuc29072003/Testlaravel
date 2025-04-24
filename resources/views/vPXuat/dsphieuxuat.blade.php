@extends('layouts.main')

@section('title', 'Danh sách Phiếu Xuất')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <!-- Bảng danh sách phiếu xuất -->
                <div class="col-9">
                    <div class="table-responsive">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h1 class="mb-0">Danh sách Phiếu Xuất</h1>
                            <a href="{{ route('dsphieuxuat.add') }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Thêm mới
                            </a>
                        </div>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">Mã Phiếu Xuất</th>
                                    <th scope="col">Ngày Xuất</th>
                                    <th scope="col">Nhân Viên Xuất</th>
                                    <th scope="col">Nhân Viên Nhận</th>
                                    <th scope="col">Tổng Số Lượng</th>
                                    <th scope="col">Ghi Chú</th>
                                    <th scope="col">Trạng Thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dsPhieuXuat as $phieuXuat)
                                    <tr class="text-center"
                                        onclick="window.location='{{ route('phieuxuat.show', $phieuXuat->MaPhieuXuat) }}'"
                                        style="cursor: pointer;">
                                        <td>{{ $phieuXuat->MaPhieuXuat }}</td>
                                        <td>{{ \Carbon\Carbon::parse($phieuXuat->NgayXuat)->format('d/m/Y H:i:s') }}</td>
                                        <td>{{ $phieuXuat->nhanVienTao->TenNhanVien ?? 'Không xác định' }}</td>
                                        <td>{{ $phieuXuat->nhanVienNhan->TenNhanVien ?? 'Không xác định' }}</td>
                                        <td>{{ number_format($phieuXuat->TongSoLuong, 0, ',', '.') }}</td>
                                        <td>{{ $phieuXuat->GhiChu ?? 'Không có ghi chú' }}</td>
                                        <td>
                                            <span class="badge bg-success text-white">Đã xuất kho</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <nav aria-label="Page navigation example">
                                    {{ $dsPhieuXuat->appends(request()->query())->links('pagination::bootstrap-5') }}
                                </nav>
                            </tfoot>
                        </table>
                    </div>
                    
                </div>

                <!-- Thanh tìm kiếm -->
                <div class="col-3">
                    <div class="border p-3 rounded">
                        <form method="GET" action="{{ route('dsphieuxuat') }}">
                            <h5 class="mb-3">Tìm kiếm</h5>
                            <div class="mb-3">
                                <label for="MaPhieuXuat" class="form-label">Mã Phiếu Xuất</label>
                                <input type="text" name="MaPhieuXuat" id="MaPhieuXuat" class="form-control"
                                    placeholder="Nhập mã phiếu xuất" value="{{ request('MaPhieuXuat') }}">
                            </div>
                            <div class="mb-3">
                                <label for="NgayXuat" class="form-label">Ngày Xuất</label>
                                <input type="date" name="NgayXuat" id="NgayXuat" class="form-control"
                                    value="{{ request('NgayXuat') }}">
                            </div>
                            <div class="mb-3">
                                <label for="TenNhanVienXuat" class="form-label">Nhân Viên Tạo</label>
                                <input type="text" name="TenNhanVienXuat" id="TenNhanVienXuat" class="form-control"
                                    placeholder="Nhập tên nhân viên xuất" value="{{ request('TenNhanVienXuat') }}">
                            </div>
                            <div class="mb-3">
                                <label for="TenNhanVienNhan" class="form-label">Nhân Viên Nhận</label>
                                <input type="text" name="TenNhanVienNhan" id="TenNhanVienNhan" class="form-control"
                                    placeholder="Nhập tên nhân viên nhận" value="{{ request('TenNhanVienNhan') }}">
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
@endsection

