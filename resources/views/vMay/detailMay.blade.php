@extends('layouts.main')

@section('title', 'Thêm Máy Mới')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="card">
                <div class="card-header">
                    <h1 class="m-3">Thông Tin Máy</h1>
                </div>
                <div class="card-body p-5">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th scope="row">Mã Máy</th>
                                <td>{{ $may->MaMay }}</td>
                                <th scope="row">Thời Gian Đưa Vào Sử Dụng</th>
                                <td>{{ $may->ThoiGianDuaVaoSuDung }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Tên Máy</th>
                                <td>{{ $may->TenMay }}</td>
                                <th scope="row">Năm Sản Xuất</th>
                                <td>{{ $may->NamSanXuat }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Seri Máy</th>
                                <td>{{ $may->SeriMay }}</td>
                                <th scope="row">Hãng Sản Xuất</th>
                                <td>{{ $may->HangSanXuat }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Chu Kỳ Bảo Trì</th>
                                <td>{{ $may->ChuKyBaoTri }} tháng</td>
                                <th scope="row">Chi Tiết Linh Kiện</th>
                                <td><a href="{{ $may->ChiTietLinhKien }}" target="_blank"><i class="fas fa-link"></i> Mở file chi tiết</a></td>
                            </tr>
                            <tr>
                                <th scope="row">Thời Gian Bảo Hành</th>
                                <td>{{ $may->ThoiGianBaoHanh }} tháng</td>
                                <th scope="row">Nhà Cung Cấp</th>
                                <td>{{ $may->nhaCungCap->TenNhaCungCap}}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
                <div class="card-footer">
                    <!-- Nút quay lại -->
                    <div class="m-3">
                        <a href="{{ route('may') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Quay lại
                        </a>
                        <a href="{{ route('may.edit', $may->MaMay) }}" class="btn btn-warning mx-3">
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