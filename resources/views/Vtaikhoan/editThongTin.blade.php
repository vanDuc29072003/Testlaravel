@extends('layouts.main')

@section('title', 'Chỉnh sửa tài khoản')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row d-flex justify-content-center">
            <div class="col-md-9 col-xl-7">
                <div class="card">
                    <div class="card-header">
                        <h1 class="mt-3 mx-3">Chỉnh sửa thông tin nhân viên</h1>
                    </div>
                    <div class="card-body">
                        <form id="formEdit" action="{{ route('taikhoan.updateThongTin', $taikhoan->TenTaiKhoan) }}" method="POST" id="formTaiKhoan">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                {{-- Cột 1: Thông tin nhân viên --}}
                                <div class="col-md-6">
                                    <h5 class="fst-italic ms-3">Thông tin nhân viên</h5>

                                    <div class="form-group">
                                        <label for="TenNhanVien">Tên Nhân viên</label>
                                        <input type="text" class="form-control" id="TenNhanVien" name="TenNhanVien"
                                            value="{{ old('TenNhanVien', $taikhoan->nhanvien->TenNhanVien ?? '') }}" required>
                                    </div>
                                    
                                    <div class="row m-0">
                                        <div class="col-md-5 p-0">
                                            <div class="form-group">
                                                <label for="GioiTinh">Giới tính</label>
                                                <select class="form-control" id="GioiTinh" name="GioiTinh" required>
                                                    <option value="">Chọn giới tính</option>
                                                    <option value="Nam" {{ old('GioiTinh', $taikhoan->nhanvien->GioiTinh ?? '') == 'Nam' ? 'selected' : '' }}>Nam</option>
                                                    <option value="Nữ" {{ old('GioiTinh', $taikhoan->nhanvien->GioiTinh ?? '') == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-7 p-0">
                                            <div class="form-group">
                                                <label for="NgaySinh">Ngày sinh</label>
                                                <input type="date" class="form-control" id="NgaySinh" name="NgaySinh"
                                                    value="{{ old('NgaySinh', $taikhoan->nhanvien->NgaySinh ?? '') }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="SDT">Số điện thoại</label>
                                        <input type="text" class="form-control" id="SDT" name="SDT"
                                            value="{{ old('SDT', $taikhoan->nhanvien->SDT ?? '') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="Email">Email</label>
                                        <input type="email" class="form-control" id="Email" name="Email"
                                            value="{{ old('Email', $taikhoan->nhanvien->Email ?? '') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="DiaChi">Địa chỉ</label>
                                        <input type="text" class="form-control" id="DiaChi" name="DiaChi"
                                            value="{{ old('DiaChi', $taikhoan->nhanvien->DiaChi ?? '') }}" required>
                                    </div>
                                </div>

                                {{-- Cột 2: Thông tin tài khoản --}}
                                <div class="col-md-6">
                                    <h5 class="fst-italic ms-3">Thông tin tài khoản</h5>

                                    @if (Auth::user()->nhanvien->MaBoPhan == '5')
                                        <div class="form-group">
                                            <label for="MaBoPhan">Bộ phận</label>
                                            <select class="form-control" id="MaBoPhan" name="MaBoPhan" required>
                                                <option value="">Chọn bộ phận</option>
                                                @foreach ($boPhans as $bp)
                                                    <option value="{{ $bp->MaBoPhan }}"
                                                        {{ old('MaBoPhan', optional($taikhoan->nhanvien)->MaBoPhan) == $bp->MaBoPhan ? 'selected' : '' }}>
                                                        {{ $bp->TenBoPhan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @else
                                        <div class="form-group">
                                            <label for="MaBoPhan">Bộ phận</label>
                                            <select class="form-control" id="MaBoPhan" name="MaBoPhan" required disabled>
                                                <option value="">Chọn bộ phận</option>
                                                @foreach ($boPhans as $bp)
                                                    <option value="{{ $bp->MaBoPhan }}"
                                                        {{ old('MaBoPhan', optional($taikhoan->nhanvien)->MaBoPhan) == $bp->MaBoPhan ? 'selected' : '' }}>
                                                        {{ $bp->TenBoPhan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="TenTaiKhoan">Tên Tài khoản</label>
                                        <input type="text" class="form-control" id="TenTaiKhoan" name="TenTaiKhoan"
                                            value="{{ $taikhoan->TenTaiKhoan }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="MatKhauChuaMaHoa">Mật khẩu</label>
                                        <input type="text" class="form-control" id="MatKhauChuaMaHoa" name="MatKhauChuaMaHoa"
                                            value="{{ $taikhoan->MatKhauChuaMaHoa }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between m-3">
                            <a href="{{ route('taikhoan.index') }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> Quay lại
                            </a>
                            <button type="submit" class="btn btn-primary" form="formEdit">
                                <i class="fa fa-save"></i> Cập nhật
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
