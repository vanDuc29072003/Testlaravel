@extends('layouts.main')

@section('title', 'Danh sách Nhà Cung Cấp')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-xl-10 col-sm-12">
                    <div class="table-responsive">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h1 class="mb-0">Danh sách Nhà Cung Cấp</h1>
                            <a href="{{ route('nhacungcap.add') }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Thêm mới
                            </a>
                        </div>
                        <table class="table table-responsive table-bordered table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">Mã Nhà Cung Cấp</th>
                                    <th scope="col">Tên Nhà Cung Cấp</th>
                                    <th scope="col">Số Điện Thoại</th>
                                    <th scope="col">Mã Số Thuế </th>
                                    <th scope="col">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dsNhaCungCap as $ncc)
                                    <tr class="text-center"
                                        onclick="window.location='{{ route('nhacungcap.detail', $ncc->MaNhaCungCap) }}'"
                                        style="cursor: pointer;">
                                        <td>{{ $ncc->MaNhaCungCap }}</td>
                                        <td class="text-start">{{ $ncc->TenNhaCungCap }}</td>
                                        <td>{{ $ncc->SDT }}</td>
                                        <td>{{ $ncc->MaSoThue }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('nhacungcap.edit', $ncc->MaNhaCungCap) }}"
                                                    class="btn btn-warning btn-sm text-black">
                                                    <i class="fa fa-edit"></i> Sửa
                                                </a>
                                                <form action="{{ route('nhacungcap.delete', $ncc->MaNhaCungCap) }}"
                                                    method="POST" class="d-inline-block">
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
                                    {{ $dsNhaCungCap->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
                                </nav>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-12 p-0">
                    <div>
                        <form method="GET" action="{{ route('nhacungcap') }}" class="p-3 border rounded fixed-search-form">
                            <h5 class="mb-3">Tìm kiếm</h5>
                            <div class="mb-3">
                                <label for="MaNhaCungCap" class="form-label">Mã nhà cung cấp</label>
                                <input type="text" name="MaNhaCungCap" id="MaNhaCungCap" class="form-control"
                                    placeholder="Vui lòng nhập" value="{{ request('MaNhaCungCap') }}">
                            </div>
                            <div class="mb-3">
                                <label for="TenNhaCungCap" class="form-label">Tên nhà cung cấp</label>
                                <input type="text" name="TenNhaCungCap" id="TenNhaCungCap" class="form-control"
                                    placeholder="Vui lòng nhập" value="{{ request('TenNhaCungCap') }}">
                            </div>
                            <div class="mb-3">
                                <label for="DiaChi" class="form-label">Địa chỉ</label>
                                <input type="text" name="DiaChi" id="DiaChi" class="form-control"
                                    placeholder="Vui lòng nhập" value="{{ request('DiaChi') }}">
                            </div>
                            <div class="mb-3">
                                <label for="MaSoThue" class="form-label">Mã số thuế </label>
                                <input type="number" name="MaSoThue" id="MaSoThue" class="form-control"
                                    placeholder="Vui lòng nhập" value="{{ request('MaSoThue') }}">
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
            function confirmDelete(button) {
                swal({
                    title: 'Bạn có chắc chắn?',
                    text: "Những máy thuộc nhà cung cấp sẽ bị xóa theo!",
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
                    animate: { enter: 'animated fadeInDown', exit: 'animated fadeOutUp' },
                });
            @endif
        </script>
    @endsection