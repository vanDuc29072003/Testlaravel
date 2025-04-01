@extends('layouts.main')

@section('title', 'Chi Tiết Nhà Cung Cấp')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="card">
                <div class="card-header">
                    <h1 class="m-3">Thông Tin Nhà Cung Cấp</h1>
                </div>
                <div class="card-body p-5">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th scope="row">Mã Nhà Cung Cấp</th>
                                <td>{{ $nhaCungCap->MaNhaCungCap }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Tên Nhà Cung Cấp</th>
                                <td>{{ $nhaCungCap->TenNhaCungCap }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Địa Chỉ</th>
                                <td>{{ $nhaCungCap->DiaChi }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Số Điện Thoại</th>
                                <td>{{ $nhaCungCap->SDT }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Email</th>
                                <td>{{ $nhaCungCap->Email }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Mã Số Thuế</th>
                                <td>{{ $nhaCungCap->MaSoThue }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <!-- Nút quay lại -->
                    <div class="m-3">
                        <a href="{{ route('nhacungcap') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Quay lại
                        </a>
                        <a href="{{ route('nhacungcap.edit', $nhaCungCap->MaNhaCungCap) }}" class="btn btn-warning mx-3">
                            <i class="fa fa-edit"></i> Sửa
                        </a>
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