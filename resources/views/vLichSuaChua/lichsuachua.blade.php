@extends('layouts.main')

@section('title', 'Lịch Sửa Chữa')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-10">
                    <div class="table-responsive mb-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="mb-3">Lịch sửa chữa</h3>
                        </div>
                        <table class="table table-responsive table-bordered table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">Mã</th>
                                    <th scope="col">Thời Gian</th>
                                    <th scope="col">Máy</th>
                                    <th scope="col">Mô Tả</th>
                                    <th scope="col">NVYC</th>
                                    <th scope="col">Người đảm nhận</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="spinner-row" style="display: none;">
                                    <td colspan="6" style="text-align: center;">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </td>
                                </tr>
                                @foreach ($dsLichSuaChua as $lsc)
                                    <tr class="text-center">
                                        <td>{{ $lsc->MaLichSuaChua }}</td>
                                        <td>{{ $lsc->yeuCauSuaChua->ThoiGianYeuCau }}</td>
                                        <td>{{ $lsc->yeuCauSuaChua->may->TenMay }}</td>
                                        <td>{{ $lsc->yeuCauSuaChua->MoTa }}</td>
                                        <td>{{ $lsc->yeuCauSuaChua->nhanVien->TenNhanVien }}</td>
                                        <td>{{ $lsc->nhanVienKyThuat->TenNhanVien }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <nav aria-label="Page navigation example">
                                    {{ $dsLichSuaChua->links('pagination::bootstrap-5') }}
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

                        const newTable = $(response).find('table tbody').html();
                        $('table tbody').html(newTable);
                    },
                    error: function () {
                        console.error('Lỗi khi load lại bảng!');
                    }
                });
            }
        })
    </script>

@endsection