@extends('layouts.main')

@section('title', 'Thông tin máy')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="card">
                <div class="card-header">
                    <div class="mt-3 mx-3 d-flex justify-content-between">
                        <h2 class="ps-3 mb-0">Thông Tin Máy</h2>
                        <div class="d-flex justify-content-end">
                            @if ($may->TrangThai == 0)
                                <a href="{{ route('phieuthanhly.create', ['MaMay' => $may->MaMay]) }}"
                                    class="btn btn-black btn-border">
                                    <i class="fas fa-recycle"></i> Thanh lý
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body pt-6 px-5">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th scope="row">Mã Máy</th>
                                <td>{{ $may->MaMay2 }}</td>
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
                                <th scope="row">Chu Kỳ Bảo Trì</th>
                                <td>{{ $may->ChuKyBaoTri }} tháng</td>
                                <th scope="row">Chi Tiết Linh Kiện</th>
                                <td><a href="{{ $may->ChiTietLinhKien }}" target="_blank"><i class="fas fa-link"></i> Mở
                                        file chi tiết</a></td>
                            </tr>
                            <tr>
                                <th scope="row">Thời Gian Bảo Hành</th>
                                <td>{{ $may->ThoiGianBaoHanh }} tháng</td>
                                <th scope="row">Nhà Cung Cấp</th>
                                <td>{{ $may->nhaCungCap->TenNhaCungCap}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Seri Máy</th>
                                <td>{{ $may->SeriMay }}</td>
                                
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