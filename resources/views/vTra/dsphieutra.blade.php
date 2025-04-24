@extends('layouts.main')

@section('title', 'Danh sách Phiếu Trả')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <!-- Bảng danh sách phiếu trả -->
                <div class="col-9">
                    <div class="table-responsive">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h1 class="mb-0">Danh sách Phiếu Trả</h1>
                            <a href="{{ route('dsphieutra.add') }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Thêm mới
                            </a>
                        </div>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">Mã Phiếu Trả</th>
                                    <th scope="col">Ngày Trả</th>
                                    <th scope="col">Nhân Viên Tạo</th>
                                    <th scope="col">Nhân Viên Trả</th>
                                    <th scope="col">Tổng Số Lượng</th>
                                    <th scope="col">Ghi Chú</th>
                                    <th scope="col">Trạng Thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dsPhieuTra as $phieuTra)
                                    <tr class="text-center"
                                        onclick="window.location='{{ route('phieutra.show', $phieuTra->MaPhieuTra) }}'"
                                        style="cursor: pointer;">
                                        <td>{{ $phieuTra->MaPhieuTra }}</td>
                                        <td>{{ \Carbon\Carbon::parse($phieuTra->NgayTra)->format('d/m/Y H:i:s') }}</td>
                                        <td>{{ $phieuTra->nhanVienTao->TenNhanVien ?? 'Không xác định' }}</td>
                                        <td>{{ $phieuTra->nhanVienTra->TenNhanVien ?? 'Không xác định' }}</td>
                                        <td>{{ number_format($phieuTra->TongSoLuong, 0, ',', '.') }}</td>
                                        <td>{{ $phieuTra->GhiChu ?? 'Không có ghi chú' }}</td>
                                        <td>
                                            <span class="badge bg-success text-white">Đã trả</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <nav aria-label="Page navigation example">
                                    {{ $dsPhieuTra->appends(request()->query())->links('pagination::bootstrap-5') }}
                                </nav>
                            </tfoot>
                        </table>
                    </div>
                  
                </div>

                <!-- Thanh tìm kiếm -->
                <div class="col-3">
                    <div class="border p-3 rounded">
                        <form method="GET" action="{{ route('dsphieutra') }}">
                            <h5 class="mb-3">Tìm kiếm</h5>
                            <div class="mb-3">
                                <label for="MaPhieuTra" class="form-label">Mã Phiếu Trả</label>
                                <input type="text" name="MaPhieuTra" id="MaPhieuTra" class="form-control"
                                    placeholder="Nhập mã phiếu trả" value="{{ request('MaPhieuTra') }}">
                            </div>
                            <div class="mb-3">
                                <label for="NgayTra" class="form-label">Ngày Trả</label>
                                <input type="date" name="NgayTra" id="NgayTra" class="form-control"
                                    value="{{ request('NgayTra') }}">
                            </div>
                            
                            <div class="mb-3">
                                <label for="TenNhanVienTao" class="form-label">Nhân Viên Tạo</label>
                                <input type="text" name="TenNhanVien" id="TenNhanVienTao" class="form-control"
                                    placeholder="Nhập tên nhân viên tạo" value="{{ request('TenNhanVienTao') }}">
                            </div>
                            <div class="mb-3">
                                <label for="TenNhanVienTra" class="form-label">Nhân Viên Trả</label>
                                <input type="text" name="TenNhanVienTra" id="TenNhanVienTra" class="form-control"
                                    placeholder="Nhập tên nhân viên trả" value="{{ request('TenNhanVienTra') }}">
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