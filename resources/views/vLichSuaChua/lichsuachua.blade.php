@extends('layouts.main')

@section('title', 'Lịch Sửa Chữa')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive mb-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="mb-3">Lịch sửa chữa</h3>
                        </div>
                        <div id="bang-chua-hoan-thanh">
                            @if ($dsLSCChuaHoanThanh->count() > 0)
                                <table class="table table-responsive table-bordered table-hover">
                                    <thead>
                                        <tr class="text-center">
                                            <th scope="col">Mã</th>
                                            <th scope="col">Thời Gian</th>
                                            <th scope="col">Máy</th>
                                            <th scope="col">Mô Tả</th>
                                            <th scope="col">NVYC</th>
                                            <th scope="col">Người đảm nhận</th>
                                            <th scope="col">Trạng thái</th>
                                            <th scope="col">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="spinner-row" style="display: none;">
                                            <td colspan="8" style="text-align: center;">
                                                <div class="spinner-border text-dark" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            </td>
                                        </tr>
                                        @foreach ($dsLSCChuaHoanThanh as $cht)
                                            <tr class="text-center">
                                                <td>{{ $cht->MaLichSuaChua }}</td>
                                                <td>{{ $cht->yeuCauSuaChua->ThoiGianYeuCau }}</td>
                                                <td>{{ $cht->yeuCauSuaChua->may->TenMay }}</td>
                                                <td>{{ $cht->yeuCauSuaChua->MoTa }}</td>
                                                <td>{{ $cht->yeuCauSuaChua->nhanVien->TenNhanVien }}</td>
                                                <td>{{ $cht->nhanVienKyThuat->TenNhanVien }}</td>
                                                <td><span class="badge bg-warning">Chưa hoàn thành</span></td>
                                                <td>
                                                    <a class="btn btn-sm btn-success">
                                                        <i class="fa fa-check"></i> Bàn giao
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <nav aria-label="Page navigation example">
                                            {{ $dsLSCChuaHoanThanh->links('pagination::bootstrap-5') }}
                                        </nav>
                                    </tfoot>
                                </table>
                            @else
                                <div class="alert alert-info text-center" role="alert" style="width: 99%;">
                                    <p class="fst-italic m-0">Không có lịch sửa chữa nào chưa hoàn thành.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-10">
                    <div class="table-responsive mb-5">
                        <table id="bang-da-hoan-thanh" class="table table-responsive table-bordered table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">Mã</th>
                                    <th scope="col">Thời Gian</th>
                                    <th scope="col">Máy</th>
                                    <th scope="col">Mô Tả</th>
                                    <th scope="col">NVYC</th>
                                    <th scope="col">Người đảm nhận</th>
                                    <th scope="col">Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="spinner-row" style="display: none;">
                                    <td colspan="8" style="text-align: center;">
                                        <div class="spinner-border text-dark" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </td>
                                </tr>
                                @foreach ($dsLSCDaHoanThanh as $dth)
                                    <tr class="text-center">
                                        <td>{{ $dth->MaLichSuaChua }}</td>
                                        <td>{{ $dth->yeuCauSuaChua->ThoiGianYeuCau }}</td>
                                        <td>{{ $dth->yeuCauSuaChua->may->TenMay }}</td>
                                        <td>{{ $dth->yeuCauSuaChua->MoTa }}</td>
                                        <td>{{ $dth->yeuCauSuaChua->nhanVien->TenNhanVien }}</td>
                                        <td>{{ $dth->nhanVienKyThuat->TenNhanVien }}</td>
                                        <td><span class="badge bg-success">Đã hoàn thành</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <nav aria-label="Page navigation example">
                                    {{ $dsLSCDaHoanThanh->links('pagination::bootstrap-5') }}
                                </nav>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <!-- Form tìm kiếm -->
                <div class="col-2 p-0">
                    <div style="margin-top: 50px;">
                        <form method="GET" action="{{ route('lichsuachua.index') }}"
                            class="p-3 border rounded fixed-search-form">
                            <div class="mb-3">
                                <label for="MaLichSuaChua" class="form-label">Mã lịch sửa chữa</label>
                                <input type="text" name="MaLichSuaChua" id="MaLichSuaChua" class="form-control"
                                    placeholder="Nhập mã lịch sửa chữa" value="{{ request('MaLichSuaChua') }}">
                            </div>
                            <div class="mb-3">
                                <label for="MaYeuCauSuaChua" class="form-label">Mã yêu cầu sửa chữa</label>
                                <input type="text" name="MaYeuCauSuaChua" id="MaYeuCauSuaChua" class="form-control"
                                    placeholder="Nhập mã yêu cầu sửa chữa" value="{{ request('MaYeuCauSuaChua') }}">
                            </div>
                            <div class="mb-3">
                                <label for="MaNhanVienKyThuat" class="form-label">Nhân viên đảm nhận</label>
                                <select name="MaNhanVienKyThuat" id="MaNhanVienKyThuat" class="form-control">
                                    <option value="">-- Chọn nhân viên --</option>
                                    @foreach ($dsNhanVien as $nv)
                                        <option value="{{ $nv->MaNhanVien }}" {{ request('MaNhanVienKyThuat') == $nv->MaNhanVien ? 'selected' : '' }}>
                                            {{ $nv->TenNhanVien }}
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
    </div>
@endsection

@section('scripts')
    <script>
        pusher.subscribe('channel-all').bind('eventUpdateTable', function (data) {
            if (data.reload) {
                console.log('Có cập nhật mới');

                $.ajax({
                    url: window.location.href,
                    type: 'GET',

                    beforeSend: function () {
                        // Hiển thị spinner khi bắt đầu gửi request
                        $('#spinner-row').show();
                    },

                    success: function (response) {
                        $('#spinner-row').hide();

                        const newChuaHoanThanh = $(response).find('#bang-chua-hoan-thanh').html();
                        const newDaHoanThanh = $(response).find('#bang-da-hoan-thanh').html();

                        $('#bang-chua-hoan-thanh').html(newChuaHoanThanh);
                        $('#bang-da-hoan-thanh').html(newDaHoanThanh);
                    },
                    error: function () {
                        console.error('Lỗi khi load lại bảng!');
                    }
                });
            }
        })
    </script>
@endsection