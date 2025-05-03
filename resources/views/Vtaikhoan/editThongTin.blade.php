@extends('layouts.main')

@section('title', 'Chỉnh sửa tài khoản')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h1>Chỉnh sửa thông tin chi tiết</h1>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('taikhoan.updateThongTin', $taikhoan->TenTaiKhoan) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <!-- Cột 1 -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="TenTaiKhoan">Tên tài khoản</label>
                                <input type="text" class="form-control" id="TenTaiKhoan" name="TenTaiKhoan"
                                    value="{{ $taikhoan->TenTaiKhoan }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="MatKhauChuaMaHoa">Mật khẩu</label>
                                <input type="text" class="form-control" id="MatKhauChuaMaHoa" name="MatKhauChuaMaHoa"
                                    value="{{ $taikhoan->MatKhauChuaMaHoa }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="TenNhanVien">Tên nhân viên</label>
                                <input type="text" class="form-control" id="TenNhanVien" name="TenNhanVien"
                                    value="{{ $taikhoan->nhanvien->TenNhanVien ?? 'Chưa có' }}" >
                            </div>
                            <div class="form-group">
                                <label for="Email">Email</label>
                                <input type="email" class="form-control" id="Email" name="Email"
                                    value="{{ $taikhoan->nhanvien->Email ?? 'Chưa có' }}" >
                            </div>
                        </div>

                        <!-- Cột 2 -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="GioiTinh">Giới tính</label>
                                <input type="text" class="form-control" id="GioiTinh" name="GioiTinh"
                                    value="{{ $taikhoan->nhanvien->GioiTinh ?? 'Chưa có' }}">
                            </div>
                            <div class="form-group">
                                <label for="NgaySinh">Ngày sinh</label>
                                <input type="date" class="form-control" id="NgaySinh" name="NgaySinh"
                                    value="{{ $taikhoan->nhanvien->NgaySinh ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="SDT">SĐT</label>
                                <input type="text" class="form-control" id="SDT" name="SDT"
                                    value="{{ $taikhoan->nhanvien->SDT ?? 'Chưa có' }}">
                            </div>
                            <div class="form-group">
                                <label for="DiaChi">Địa chỉ</label>
                                <input type="text" class="form-control" id="DiaChi" name="DiaChi"
                                    value="{{ $taikhoan->nhanvien->DiaChi ?? 'Chưa có' }}">
                            </div>
                            <div class="form-group">
                                <label for="MaBoPhan">Bộ phận</label>
                                <select class="form-control" id="MaBoPhan" name="MaBoPhan" required>
                                    <option value="">-- Chọn bộ phận --</option>
                                    @foreach ($boPhans as $boPhan)
                                        <option value="{{ $boPhan->MaBoPhan }}"
                                            {{ optional($taikhoan->nhanvien)->MaBoPhan == $boPhan->MaBoPhan ? 'selected' : '' }}>
                                            {{ $boPhan->TenBoPhan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <a href="{{ route('taikhoan.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Quay lại
                        </a>
                        <button type="submit" class="btn btn-primary mx-3">
                            <i class="fa fa-save"></i> Cập nhật
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
