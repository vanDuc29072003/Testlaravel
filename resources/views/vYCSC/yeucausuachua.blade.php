@extends('layouts.main')

@section('title', 'Danh sách Yêu cầu sửa chữa')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive mb-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="mb-3">Danh sách Yêu cầu sửa chữa</h3>
                            <a href="{{ route('yeucausuachua.create') }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Thêm mới
                            </a>
                        </div>
                        <div id="bang-cho-duyet">
                            @if($dsYeuCauSuaChuaChoDuyet->count() > 0)
                                <table class="table table-responsive table-bordered table-hover">
                                    <thead>
                                        <tr class="text-center">
                                            <th scope="col">Mã</th>
                                            <th scope="col">Thời Gian</th>
                                            <th scope="col">Máy</th>
                                            <th scope="col">Mô Tả</th>
                                            <th scope="col">NVYC</th>
                                            <th scope="col">Trạng Thái</th>
                                            <th scope="col">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dsYeuCauSuaChuaChoDuyet as $ycsccd)
                                            <tr class="text-center">
                                                <td>{{ $ycsccd->MaYeuCauSuaChua }}</td>
                                                <td>{{ \Carbon\Carbon::parse($ycsccd->ThoiGianYeuCau)->format('d-m-Y H:i') }}</td>
                                                <td>{{ $ycsccd->may->TenMay }}</td>
                                                <td>{{ $ycsccd->MoTa }}</td>
                                                <td>{{ $ycsccd->nhanVien->TenNhanVien ?? 'Không xác định' }}</td>
                                                <td><span class="badge bg-warning">Chờ duyệt</span></td>
                                                <td>
                                                    <div class="d-flex justify-content-center gap-3">
                                                        <a href="{{ route('yeucausuachua.formduyet', $ycsccd->MaYeuCauSuaChua) }}"
                                                            class="btn btn-success btn-sm">
                                                            <i class="fa-solid fa-check"></i> Duyệt
                                                        </a>
                                                        <form action="{{ route('yeucausuachua.tuchoi', $ycsccd->MaYeuCauSuaChua) }}"
                                                            method="POST" class="d-inline-block">
                                                            @csrf
                                                            @method('POST')
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                onclick="event.stopPropagation(); confirmTuchoi(this)">
                                                                <i class="fa-solid fa-xmark"></i> Từ chối
                                                            </button>
                                                        </form>
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
                            @else
                                <div class="alert alert-info text-center" role="alert" style="width: 99%;">
                                    <p class="fst-italic m-0">Không có yêu cầu sửa chữa nào đang chờ duyệt.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <h3 class="mb-3">Yêu cầu sửa chữa đã duyệt</h3>
                <div class="col-xl-10 col-sm-12">
                    <!-- Bảng yêu cầu đã xử lý -->
                    <div class="table-responsive">
                        <table id="bang-da-xu-ly" class="table table-responsive table-bordered table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col" style="width: 11%">Thời Gian</th>
                                    <th scope="col">Máy</th>
                                    <th scope="col">Mô Tả</th>
                                    <th scope="col">NVYC</th>
                                    <th scope="col">NV Duyệt</th>
                                    <th scope="col" style="width: 7%">Trạng Thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dsYeuCauSuaChuaDaXuLy as $ycscdxl)
                                    <tr class="text-center">
                                        <td>{{ \Carbon\Carbon::parse($ycscdxl->ThoiGianYeuCau)->format('d-m-Y H:i') }}</td>
                                        <td class="text-start">{{ $ycscdxl->may->TenMay }}</td>
                                        <td class="text-start">{{ $ycscdxl->MoTa }}</td>
                                        <td>{{ $ycscdxl->nhanVien->TenNhanVien }}</td>
                                        <td>{{ $ycscdxl->nhanVienDuyet->TenNhanVien }}</td>
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
                                    {{ $dsYeuCauSuaChuaDaXuLy->links('pagination::bootstrap-5') }}
                                </nav>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Form tìm kiếm -->
                <div class="col-xl-2 col-sm-12 p-0">
                    <form method="GET" action="{{ route('yeucausuachua.index') }}" class="p-3 border rounded">
                        <h5 class="mb-3">Tìm kiếm</h5>
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
                            <label for="MaNhanVienYeuCau" class="form-label">Tên nhân viên yêu cầu</label>
                            <select name="MaNhanVienYeuCau" id="MaNhanVienYeuCau" class="form-control">
                                <option value="">-- Chọn nhân viên --</option>
                                @foreach ($dsNhanVien as $nhanVien)
                                    <option value="{{ $nhanVien->MaNhanVien }}" {{ request('MaNhanVienYeuCau') == $nhanVien->MaNhanVien ? 'selected' : '' }}>
                                        {{ $nhanVien->TenNhanVien }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="TrangThai" class="form-label">Trạng thái</label>
                            <select name="TrangThai" id="TrangThai" class="form-control">
                                <option value="">-- Chọn trạng thái --</option>
                                <option value="1" {{ request('TrangThai') == '1' ? 'selected' : '' }}>Đã duyệt</option>
                                <option value="2" {{ request('TrangThai') == '2' ? 'selected' : '' }}>Đã từ chối</option>
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
@endsection

@section('scripts')
   
    <script>
        function confirmTuchoi(button) {
            swal({
                title: 'Từ chối yêu cầu?',
                icon: 'warning',
                buttons: {
                    confirm: {
                        text: 'Từ chối',
                        className: 'btn btn-danger'
                    },
                    cancel: {
                        text: 'Hủy',
                        visible: true,
                        className: 'btn btn-success'
                    }
                }
            }).then((confirm) => {
                if (confirm) {
                    button.closest('form').submit();
                } else {
                    swal.close();
                }
            });
        }
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
                        const newDaXuLy = $(response).find('#bang-da-xu-ly').html();

                        // Gán lại đúng chỗ
                        $('#bang-cho-duyet').html(newChoDuyet);
                        $('#bang-da-xu-ly').html(newDaXuLy);
                    },
                    error: function () {
                        console.error('Lỗi khi load lại bảng!');
                    }
                });
            }
        });
    </script>
@endsection