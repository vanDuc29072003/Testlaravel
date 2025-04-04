@extends('layouts.main')

@section('title', 'Danh sách Máy')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-10">
                    <div class="table-responsive">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h1 class="mb-0">Danh sách Máy</h1>
                            <a href="{{ route('may.add') }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Thêm mới
                            </a>
                        </div>
                        <table class="table table-responsive table-bordered table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">Mã Máy</th>
                                    <th scope="col">Tên Máy</th>
                                    <th scope="col">Seri Máy</th>
                                    <th scope="col">Chu Kì Bảo Trì (Tháng)</th>
                                    <th scope="col">Năm Sản Xuất</th>
                                    <th scope="col">Hãng Sản Xuất</th>
                                    <th scope="col">Cập Nhật</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dsMay as $may)
                                    <tr class="text-center" onclick="window.location='{{ route('may.detail', $may->MaMay) }}'"
                                        style="cursor: pointer;">
                                        <td>{{ $may->MaMay }}</td>
                                        <td>{{ $may->TenMay }}</td>
                                        <td>{{ $may->SeriMay }}</td>
                                        <td>{{ $may->ChuKyBaoTri }}</td>
                                        <td>{{ $may->NamSanXuat }}</td>
                                        <td>{{ $may->HangSanXuat }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('may.edit', $may->MaMay) }}"
                                                    class="btn btn-warning btn-sm text-black">
                                                    <i class="fa fa-edit"></i> Sửa
                                                </a>
                                                <form action="{{ route('may.delete', $may->MaMay) }}" method="POST"
                                                    class="d-inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        onclick="event.stopPropagation(); confirmDelete(this)">
                                                        <i class="fa fa-trash"></i> Xóa
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <!-- Pagination -->
                                <nav aria-label="Page navigation example">
                                    {{ $dsMay->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
                                </nav>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="col-2 p-0">
                    <div style="margin-top: 105px;">
                        <form method="GET" action="{{ route('may') }}" class="p-3 border rounded fixed-search-form">
                            <div class="mb-3">
                                <label for="MaMay" class="form-label">Mã máy</label>
                                <input type="text" name="MaMay" id="MaMay" class="form-control" placeholder="Vui lòng nhập"
                                    value="{{ request('MaMay') }}">
                            </div>
                            <div class="mb-3">
                                <label for="TenMay" class="form-label">Tên máy</label>
                                <input type="text" name="TenMay" id="TenMay" class="form-control"
                                    placeholder="Vui lòng nhập" value="{{ request('TenMay') }}">
                            </div>
                            <div class="mb-3">
                                <label for="SeriMay" class="form-label">Seri máy</label>
                                <input type="text" name="SeriMay" id="SeriMay" class="form-control"
                                    placeholder="Vui lòng nhập" value="{{ request('SeriMay') }}">
                            </div>
                            <div class="mb-3">
                                <label for="ChuKyBaoTri" class="form-label">Chu kỳ bảo trì</label>
                                <input type="number" name="ChuKyBaoTri" id="ChuKyBaoTri" class="form-control"
                                    placeholder="Vui lòng nhập" value="{{ request('ChuKyBaoTri') }}">
                            </div>
                            <div class="mb-3">
                                <label for="ThoiGianBaoHanh" class="form-label">Thời gian bảo hành</label>
                                <input type="number" name="ThoiGianBaoHanh" id="ThoiGianBaoHanh" class="form-control"
                                    placeholder="Vui lòng nhập" value="{{ request('ThoiGianBaoHanh') }}">
                            </div>
                            <div class="mb-3">
                                <label for="ThoiGianDuaVaoSuDung" class="form-label">Thời gian đưa vào sử dụng</label>
                                <input type="date" name="ThoiGianDuaVaoSuDung" id="ThoiGianDuaVaoSuDung"
                                    class="form-control" value="{{ request('ThoiGianDuaVaoSuDung') }}">
                            </div>
                            <div class="mb-3">
                                <label for="NamSanXuat" class="form-label">Năm sản xuất</label>
                                <input type="number" name="NamSanXuat" id="NamSanXuat" class="form-control"
                                    placeholder="Vui lòng nhập" value="{{ request('NamSanXuat') }}">
                            </div>
                            <div class="mb-3">
                                <label for="HangSanXuat" class="form-label">Hãng sản xuất</label>
                                <input type="text" name="HangSanXuat" id="HangSanXuat" class="form-control"
                                    placeholder="Vui lòng nhập" value="{{ request('HangSanXuat') }}">
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
        function confirmDelete(button) {
            swal({
                title: 'Bạn có chắc chắn?',
                text: "Hành động này không thể hoàn tác!",
                icon: 'warning',
                buttons: {
                    confirm: {
                        text: 'Xóa',
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