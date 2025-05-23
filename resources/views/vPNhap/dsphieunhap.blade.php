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
                            <h3 class="mb-0">Danh sách Phiếu Nhập Chờ Duyệt</h3>
                            <a href="{{ route('dsphieunhap.add', ['new' => true]) }}) }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Thêm mới
                            </a>
                        </div>
                        <table class="table table-bordered table-hover" id="bang-cho-duyet">
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
                                @foreach ($dsPhieuNhapChoDuyet as $phieuNhap)
                                    <tr class="text-center"
                                        onclick="window.location='{{ route('phieunhap.show', $phieuNhap->MaPhieuNhap) }}'"
                                        style="cursor: pointer;">
                                        <td>{{ $phieuNhap->MaHienThi }}</td>
                                        <td>{{ \Carbon\Carbon::parse($phieuNhap->NgayNhap)->format('H:i - d/m/Y') }}</td>
                                        <td>{{ $phieuNhap->nhaCungCap->TenNhaCungCap ?? 'Không xác định' }}</td>
                                        <td>{{ $phieuNhap->nhanVien->TenNhanVien ?? 'Không xác định' }}</td>
                                        <td>{{ number_format($phieuNhap->TongTien, 0, ',', '.') }} VND</td>
                                        <td>
                                            <span class="badge bg-warning text-dark">Chờ duyệt</span>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                             <a href="{{ route('dsphieunhap.edit', ['MaPhieuNhap' => $phieuNhap->MaPhieuNhap]) }}?new=true"
                                                class="btn btn-warning btn-sm text-black">
                                                    <i class="fa fa-edit"></i> Sửa
                                                </a>


                                                <button href="" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-info-circle"></i> Xem
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <!-- Pagination cho trạng thái chờ duyệt -->
                                <nav aria-label="Page navigation example">
                                    {{ $dsPhieuNhapChoDuyet->links('pagination::bootstrap-5') }}
                                </nav>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <h3 class="mb-3">Phiếu Nhập Đã Duyệt</h3><!-- Bảng danh sách phiếu nhập đã duyệt -->
                <div class="col-lg-9">
                    <div class="table-responsive">
                        <table id="bang-da-duyet" class="table table-bordered table-hover">
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
                                @foreach ($dsPhieuNhapDaDuyet as $phieuNhap)
                                    <tr class="text-center"
                                        onclick="window.location='{{ route('phieunhap.show', $phieuNhap->MaPhieuNhap) }}'"
                                        style="cursor: pointer;">
                                        <td>{{ $phieuNhap->MaHienThi }}</td>
                                        <td>{{ \Carbon\Carbon::parse($phieuNhap->NgayNhap)->format('H:i - d/m/Y') }}</td>
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
                                    {{ $dsPhieuNhapDaDuyet->links('pagination::bootstrap-5') }}
                                </nav>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Form tìm kiếm -->
                <div class="col-lg-3">
                    <form method="GET" action="{{ route('dsphieunhap') }}" class="p-3 border rounded">
                        <h5 class="mb-3">Tìm kiếm</h5>
                        <div class="mb-3">
                            <label for="MaHienThi" class="form-label">Mã Phiếu Nhập</label>
                            <input type="text" name="MaHienThi" id="MaHienThi" class="form-control"
                                placeholder="Nhập mã phiếu nhập" value="{{ request('MaHienThi') }}">
                        </div>
                        <div class="mb-3">
                            <label for="NgayNhap" class="form-label">Ngày Nhập</label>
                            <input type="date" name="NgayNhap" id="NgayNhap" class="form-control"
                                value="{{ request('NgayNhap') }}">
                        </div>
                        <div class="mb-3">
                            <label for="TenNhaCungCap" class="form-label">Tên Nhà Cung Cấp</label>
                            <input type="text" name="TenNhaCungCap" id="TenNhaCungCap" class="form-control"
                                placeholder="Nhập tên nhà cung cấp" value="{{ request('TenNhaCungCap') }}">
                        </div>
                        <div class="mb-3">
                            <label for="MaNhanVien" class="form-label">Nhân Viên Nhập</label>
                            <select name="MaNhanVien" id="MaNhanVien" class="form-control">
                                <option value="">-- Chọn nhân viên --</option>
                                @foreach ($dsNhanVien as $nhanVien)
                                    <option value="{{ $nhanVien->MaNhanVien }}" {{ request('MaNhanVien') == $nhanVien->MaNhanVien ? 'selected' : '' }}>
                                        {{ $nhanVien->TenNhanVien }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="TongTien" class="form-label">Tổng Giá Trị</label>
                            <input type="number" name="TongTien" id="TongTien" class="form-control"
                                placeholder="Nhập tổng giá trị" value="{{ request('TongTien') }}">
                        </div>
                        <div class="mb-3">
                            <label for="SoLuong" class="form-label">Tổng Số Lượng</label>
                            <input type="number" name="TongSoLuong" id="SoLuong" class="form-control"
                                placeholder="Nhập tổng số lượng" value="{{ request('TongSoLuong') }}">
                        </div>
                        <div class="mb-3">
                            <label for="GhiChu" class="form-label">Mô tả</label>
                            <textarea type="text" name="GhiChu" id="GhiChu" class="form-control" placeholder="Nhập ghi chú"
                                value="{{ request('GhiChu') }}" rows="3"></textarea>
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
    </script>
    <script>
        pusher.subscribe('channel-all').bind('eventUpdateTable', function (data) {
            if (data.reload) {
                console.log('Có cập nhật mới');

                $.ajax({
                    url: window.location.href,
                    type: 'GET',
                    success: function (response) {
                        // Tìm đúng bảng trong response
                        const newChoDuyet = $(response).find('#bang-cho-duyet').html();
                        const newDaDuyet = $(response).find('#bang-da-duyet').html();

                        // Gán lại đúng chỗ
                        $('#bang-cho-duyet').html(newChoDuyet);
                        $('#bang-da-duyet').html(newDaDuyet);
                    },
                    error: function () {
                        console.error('Lỗi khi load lại bảng!');
                    }
                });
            }
        });
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