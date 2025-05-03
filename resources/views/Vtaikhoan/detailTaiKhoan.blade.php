@extends('layouts.main')

@section('title', 'Chi Tiết Tài Khoản')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="card">
            <div class="card-header">
                <h1 class="m-3">Chi Tiết Tài Khoản</h1>
            </div>
            <div class="card-body p-5">
                
                <!-- Hiển thị tên bộ phận -->
                <h4 class="mb-4">
                    Bộ phận:
                    <span class="text-primary">
                        {{ $taikhoan->nhanvien->bophan->TenBoPhan ?? 'Chưa có' }}
                    </span>
                </h4>

                <!-- Bảng thông tin -->
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th scope="row">Tên Tài Khoản</th>
                            <td>{{ $taikhoan->TenTaiKhoan }}</td>
                            <th scope="row">Mật Khẩu</th>
                            <td>{{ $taikhoan->MatKhauChuaMaHoa }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Tên Nhân Viên</th>
                            <td>{{ $taikhoan->nhanvien->TenNhanVien ?? 'Chưa có' }}</td>
                            <th scope="row">Email</th>
                            <td>{{ $taikhoan->nhanvien->Email ?? 'Chưa có' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Giới Tính</th>
                            <td>{{ $taikhoan->nhanvien->GioiTinh ?? 'Chưa có' }}</td>
                            <th scope="row">Ngày Sinh</th>
                            <td>{{ $taikhoan->nhanvien->NgaySinh ?? 'Chưa có' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">SĐT</th>
                            <td>{{ $taikhoan->nhanvien->SDT ?? 'Chưa có' }}</td>
                            <th scope="row">Địa Chỉ</th>
                            <td>{{ $taikhoan->nhanvien->DiaChi ?? 'Chưa có' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="m-3">
                    <a href="{{ route('taikhoan.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Quay lại
                    </a>
                    <a href="{{ route('taikhoan.editThongTin', $taikhoan->TenTaiKhoan) }}" class="btn btn-warning mx-3">
                        <i class="fa fa-edit"></i> Sửa
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
