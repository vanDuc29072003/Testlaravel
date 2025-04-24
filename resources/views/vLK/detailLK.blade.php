@extends('layouts.main')

@section('title', 'Chi Tiết Linh Kiện')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="card w-50 mx-auto">
                <div class="card-header">
                    <h1 class="m-3">Thông Tin Linh Kiện</h1>
                </div>
                <div class="card-body p-5">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th scope="row">Mã Linh Kiện</th>
                                <td>{{ $linhKien->MaLinhKien }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Tên Linh Kiện</th>
                                <td>{{ $linhKien->TenLinhKien }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Mô Tả</th>
                                <td>{{ $linhKien->MoTa ?? 'Không có mô tả' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Số Lượng</th>
                                <td>{{ $linhKien->SoLuong }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Đơn Vị Tính</th>
                                <td>{{ $linhKien->donViTinh->TenDonViTinh ?? 'Không xác định' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Nhà Cung Cấp</th>
                                <td>
                                    <section>
                                        @foreach ($linhKien->nhaCungCaps as $nhaCungCap)
                                            <div class="card mb-3">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $nhaCungCap->TenNhaCungCap }}</h5>
                                                    <p class="card-text">
                                                        <strong>Số điện thoại:</strong>
                                                        {{ $nhaCungCap->SDT ?? 'Không có số điện thoại' }} <br>
                                                        <strong>Email:</strong> {{ $nhaCungCap->Email ?? 'Không có email' }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </section>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <!-- Nút quay lại -->
                    <div class="m-3">
                        <a href="{{ route('linhkien') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Quay lại
                        </a>
                        <a href="{{ route('linhkien.edit', $linhKien->MaLinhKien) }}" class="btn btn-warning mx-3">
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