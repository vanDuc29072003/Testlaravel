@extends('layouts.main')

@section('title', 'Danh sách Phiếu Thanh Lý')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <!-- Bảng danh sách phiếu thanh lý chờ duyệt -->
                <div class="col-12">
                    <div class="table-responsive">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="mb-0">Danh sách Phiếu Thanh Lý Chờ Duyệt</h3>
                            <a href="{{ route('phieuthanhly.create') }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Thêm mới
                            </a>
                        </div>
                        <table class="table table-bordered table-hover" id="bang-cho-duyet">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">Mã</th>
                                    <th scope="col">Ngày Lập</th>
                                    <th scope="col">Nhân Viên</th>
                                    <th scope="col">Máy</th>
                                    <th scope="col">Trạng Thái</th>
                                    <th scope="col">Cập Nhật</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dsPhieuThanhLyChoDuyet as $phieuThanhLy)
                                    <tr class="text-center"
                                        onclick="window.location='{{ route('phieuthanhly.detail', $phieuThanhLy->MaPhieuThanhLy) }}'"
                                        style="cursor: pointer;">
                                        <td>{{ $phieuThanhLy->MaHienThi }}</td>
                                        <td>{{ $phieuThanhLy->NgayLapPhieu }}</td>
                                        <td>{{ $phieuThanhLy->nhanVien->TenNhanVien ?? 'Không xác định' }}</td>
                                        <td>{{ $phieuThanhLy->may->TenMay ?? 'Không xác định' }}</td>
                                        <td>
                                            <span class="badge bg-warning text-dark">Chờ duyệt</span>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('phieuthanhly.edit', $phieuThanhLy->MaPhieuThanhLy) }}"
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
                                    {{ $dsPhieuThanhLyChoDuyet->links('pagination::bootstrap-5') }}
                                </nav>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <h3 class="mb-3">Phiếu Thanh Lý Đã Duyệt</h3><!-- Bảng danh sách phiếu thanh lý đã duyệt -->
                <div class="col-lg-9">
                    <div class="table-responsive">
                        <table id="bang-da-duyet" class="table table-bordered table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">Mã</th>
                                    <th scope="col">Ngày Lập</th>
                                    <th scope="col">Nhân Viên</th>
                                    <th scope="col">Tổng Giá Trị</th>
                                    <th scope="col">Trạng Thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dsPhieuThanhLyDaDuyet as $phieuThanhLy)
                                    <tr class="text-center"
                                        onclick="window.location='{{ route('phieuthanhly.detail', $phieuThanhLy->MaPhieuThanhLy) }}'"
                                        style="cursor: pointer;">
                                        <td>{{ $phieuThanhLy->MaHienThi }}</td>
                                        <td>{{ $phieuThanhLy->NgayLapPhieu }}</td>
                                        <td>{{ $phieuThanhLy->nhanVien->TenNhanVien ?? 'Không xác định' }}</td>
                                        <td>{{ $phieuThanhLy->may->TenMay ?? 'Không xác định' }}</td>
                                        <td>
                                            @if ($phieuThanhLy->TrangThai == '1')
                                                <span class="badge bg-success text-white"> Đã duyệt</span>
                                            @else
                                                <span class="badge bg-danger text-white">Đã từ chối</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <!-- Pagination cho trạng thái đã duyệt -->
                                <nav aria-label="Page navigation example">
                                    {{ $dsPhieuThanhLyDaDuyet->links('pagination::bootstrap-5') }}
                                </nav>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Form tìm kiếm -->
                <div class="col-lg-3">
                    <form method="GET" action="{{ route('phieuthanhly.index') }}" class="p-3 border rounded">
                        <h5 class="mb-3">Tìm kiếm</h5>
                        <div class="mb-3">
                            <label for="MaHienThi" class="form-label">Mã Phiếu Thanh Lý</label>
                            <input type="text" name="MaHienThi" id="MaHienThi" class="form-control"
                                placeholder="Nhập mã phiếu thanh lý" value="{{ request('MaHienThi') }}">
                        </div>
                        <div class="mb-3">
                            <label for="NgayLapPhieu" class="form-label">Ngày Lập</label>
                            <input type="date" name="NgayLapPhieu" id="NgayLapPhieu" class="form-control"
                                value="{{ request('NgayLapPhieu') }}">
                        </div>
                        <div class="mb-3">
                            <label for="MaNhanVien" class="form-label">Nhân Viên</label>
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
                            <label for="May" class="form-label">Máy</label>
                            <select name="MaMay" id="MaMay" class="form-control">
                                <option value="">-- Chọn máy --</option>
                                @foreach ($dsMay as $may)
                                    <option value="{{ $may->MaMay }}" {{ request('MaMay') == $may->MaMay ? 'selected' : '' }}>
                                        {{ $may->TenMay }}
                                    </option>
                                @endforeach
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
@endsection