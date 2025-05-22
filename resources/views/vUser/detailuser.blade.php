@extends('layouts.main')

@section('title', 'Chi Tiết Người Dùng')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row d-flex justify-content-center">
                <div class="col-md-9 col-xl-7">
                    <div class="card mx-auto">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h1 class="mt-3 mx-3">Chi tiết người dùng</h1>
                                <a href="{{ route('taikhoan.editThongTin', $user->TenTaiKhoan) }}" class="btn btn-warning my-0 mx-3">
                                    <i class="fa fa-edit"></i> Sửa
                                </a>
                            </div>
                        </div>
                        <div class="card-body px-5">
                            <!-- Table Thông Tin Tài Khoản -->
                            <h5 class="fst-italic ms-3">I. Thông tin tài khoản</h5>
                            <table class="table">
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
                            <h5 class="fst-italic ms-3 mt-4">II. Thông tin nhân viên</h5>
                            <table class="table">
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
                                        <th scope="row">Email</th>
                                        <td>{{ $nhanvien->Email }}</td>
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
                                <a href="{{ route('taikhoan.index') }}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> Quay lại
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection