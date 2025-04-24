@extends('layouts.main')

@section('title', 'Chi Tiết Người Dùng')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="card w-50 mx-auto">

                <div class="card-body pt-5 px-5">
                    <!-- Table Thông Tin Tài Khoản -->
                    <h3>Thông Tin Tài Khoản</h3>
                    <table class="table table-bordered table-striped mb-5">
                        <tbody>
                            <tr>
                                <th scope="row">Mã Nhân Viên</th>
                                <td>{{ $user->MaNhanVien }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Tên Tài Khoản</th>
                                <td>{{ $user->TenTaiKhoan }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Table Hồ Sơ Nhân Viên -->
                    <h3>Hồ Sơ Nhân Viên</h3>
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th scope="row">Tên Nhân Viên</th>
                                <td>{{ $nhanvien->TenNhanVien }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Giới Tính</th>
                                <td>{{ $nhanvien->GioiTinh }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Ngày Sinh</th>
                                <td>{{ $nhanvien->NgaySinh }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Số Điện Thoại</th>
                                <td>{{ $nhanvien->SDT }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Địa Chỉ</th>
                                <td>{{ $nhanvien->DiaChi }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Bộ Phận</th>
                                <td>{{ $bophan->TenBoPhan ?? 'Chưa cập nhật' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center flex-wrap m-3">
                        <a href="{{ route('may') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Quay lại
                        </a>
                        <div class="d-flex gap-3">
                            <a class="btn btn-warning">
                                <i class="fas fa-unlock-alt"></i> Cấp lại mật khẩu
                            </a>
                            <a class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i> Xóa tài khoản
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection