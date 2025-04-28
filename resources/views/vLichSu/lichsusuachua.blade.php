@extends('layouts.main')

@section('title', 'Lịch Sử Sửa Chữa')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-10">
                    <div class="table-responsive mb-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="mb-3">Lịch sử sửa chữa</h3>
                        </div>
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
                                    <th scope="col">Xem chi tiết</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dsLSCDaHoanThanh as $dth)
                                    <tr class="text-center">
                                        <td>{{ $dth->MaLichSuaChua }}</td>
                                        <td>{{ \Carbon\Carbon::parse($dth->yeuCauSuaChua->ThoiGianYeuCau)->format('d-m-Y H:i') }}</td>
                                        <td>{{ $dth->yeuCauSuaChua->may->TenMay }}</td>
                                        <td>{{ $dth->yeuCauSuaChua->MoTa }}</td>
                                        <td>{{ $dth->yeuCauSuaChua->nhanVien->TenNhanVien }}</td>
                                        <td>{{ $dth->nhanVienKyThuat->TenNhanVien }}</td>
                                        <td>
                                            @if ($dth->TrangThai == '1')
                                                <span class="badge bg-success">Đã hoàn thành</span>
                                            @elseif ($dth->TrangThai == '2')
                                                <span class="badge bg-danger">Liên hệ NCC</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($dth->TrangThai == '1')
                                                <a href="{{ route('lichsuachua.showpbg', $dth->MaLichSuaChua) }}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-info-circle"></i> Chi tiết
                                                </a>
                                            @elseif ($dth->TrangThai == '2')
                                                <a href="{{ route('lichsuachua.showpbg1', $dth->MaLichSuaChua) }}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-info-circle"></i> Chi tiết
                                                </a>
                                            @endif
                                        </td>
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
        function confirmLienHe(button) {
            swal({
                title: 'Xác nhận?',
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
@endsection