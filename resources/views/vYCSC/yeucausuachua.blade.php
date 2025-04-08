@extends('layouts.main')

@section('title', 'Danh sách Yêu cầu sửa chữa')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-12">
                    <!-- Bảng yêu cầu đang chờ duyệt -->
                    <div class="table-responsive mb-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="mb-3">Danh sách Yêu cầu sửa chữa</h3>
                            <a href="{{ route('yeucausuachua.create') }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Thêm mới
                            </a>
                        </div>
                        <table class="table table-responsive table-bordered table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">Mã</th>
                                    <th scope="col">Thời Gian</th>
                                    <th scope="col">Máy</th>
                                    <th scope="col">Mô Tả</th>
                                    <th scope="col">NVYC</th>
                                    <th scope="col">Trạng Thái</th>
                                    <th scope="col">Cập Nhật</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dsYeuCauSuaChuaChoDuyet as $ycsccd)
                                    <tr class="text-center">
                                        <td>{{ $ycsccd->MaYeuCauSuaChua }}</td>
                                        <td>{{ $ycsccd->ThoiGianYeuCau }}</td>
                                        <td>{{ $ycsccd->may->TenMay }}</td>
                                        <td>{{ $ycsccd->MoTa }}</td>
                                        <td>{{ $ycsccd->nhanVien->TenNhanVien }}</td>
                                        <td><span class="badge bg-warning">Chờ duyệt</span></td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="#" class="btn btn-success btn-sm">
                                                    <i class="fa-solid fa-check"></i>
                                                </a>
                                                <a href="#" class="btn btn-danger btn-sm">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <nav aria-label="Page navigation example">
                                    {{ $dsYeuCauSuaChuaChoDuyet->links('pagination::bootstrap-5') }}
                                </nav>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="col-10">
                    <!-- Bảng yêu cầu đã xử lý -->
                    <div class="table-responsive">
                        <table class="table table-responsive table-bordered table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">Mã</th>
                                    <th scope="col">Thời Gian</th>
                                    <th scope="col">Máy</th>
                                    <th scope="col">Mô Tả</th>
                                    <th scope="col">NVYC</th>
                                    <th scope="col">Trạng Thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dsYeuCauSuaChuaDaXuLy as $ycscdxl)
                                    <tr class="text-center">
                                        <td>{{ $ycscdxl->MaYeuCauSuaChua }}</td>
                                        <td>{{ $ycscdxl->ThoiGianYeuCau }}</td>
                                        <td>{{ $ycscdxl->may->TenMay }}</td>
                                        <td>{{ $ycscdxl->MoTa }}</td>
                                        <td>{{ $ycscdxl->nhanVien->TenNhanVien }}</td>
                                        <td>
                                            @if ($ycscdxl->TrangThai == '1')
                                                <span class="badge bg-success">Đã duyệt</span>
                                            @elseif ($ycscdxl->TrangThai == '2')
                                                <span class="badge bg-danger">Đã từ chối</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <nav aria-label="Page navigation example">
                                    @if ($dsYeuCauSuaChuaDaXuLy->hasPages())
                                        {{ $dsYeuCauSuaChuaDaXuLy->links('pagination::bootstrap-5') }}
                                    @else
                                        <ul class="pagination justify-content-end">
                                            <li class="page-item disabled"><span class="page-link">1</span></li>
                                        </ul>
                                    @endif
                                </nav>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Form tìm kiếm -->
                <div class="col-2 p-0">
                    <div style="margin-top: 50px;">
                        <form method="GET" action="{{ route('yeucausuachua.index') }}"
                            class="p-3 border rounded fixed-search-form">
                            <div class="mb-3">
                                <label for="MaYeuCauSuaChua" class="form-label">Mã yêu cầu sửa chữa</label>
                                <input type="text" name="MaYeuCauSuaChua" id="MaYeuCauSuaChua" class="form-control"
                                    placeholder="Nhập mã yêu cầu" value="{{ request('MaYeuCauSuaChua') }}">
                            </div>
                            <div class="mb-3">
                                <label for="ThoiGianYeuCau" class="form-label">Thời gian yêu cầu</label>
                                <input type="date" name="ThoiGianYeuCau" id="ThoiGianYeuCau" class="form-control"
                                    value="{{ request('ThoiGianYeuCau') }}">
                            </div>
                            <div class="mb-3">
                                <label for="MaMay" class="form-label">Tên máy</label>
                                <select name="MaMay" id="MaMay" class="form-control">
                                    <option value="">-- Chọn máy --</option>
                                    @foreach ($dsMay as $may)
                                        <option value="{{ $may->MaMay }}" {{ request('MaMay') == $may->MaMay ? 'selected' : '' }}>
                                            {{ $may->TenMay }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="MaNhanVien" class="form-label">Tên nhân viên</label>
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
                                <label for="MoTa" class="form-label">Mô tả</label>
                                <input type="text" name="MoTa" id="MoTa" class="form-control" placeholder="Nhập mô tả"
                                    value="{{ request('MoTa') }}">
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

    <script>
        @if (session('error'))
            $.notify({
                title: 'Lỗi',
                message: '{{ session('error') }}',
                icon: 'icon-bell'
            }, {
                type: 'danger',
                animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutUp'
                },
            });
        @endif
    </script>
@endsection