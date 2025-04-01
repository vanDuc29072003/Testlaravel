@extends('layouts.main')

@section('title', 'Chỉnh Sửa Nhà Cung Cấp')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="card">
                <div class="card-header">
                    <h1 class="m-3">Chỉnh Sửa Nhà Cung Cấp</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('nhacungcap.update', $nhaCungCap->MaNhaCungCap) }}" method="POST">
                        @csrf
                        @method('POST')
                        <!-- Tên Nhà Cung Cấp -->
                        <div class="form-group">
                            <label for="TenNhaCungCap">Tên Nhà Cung Cấp</label>
                            <input type="text" class="form-control" id="TenNhaCungCap" name="TenNhaCungCap"
                                value="{{ $nhaCungCap->TenNhaCungCap }}" required readonly>
                        </div>

                        <!-- Địa Chỉ -->
                        <div class="form-group">
                            <label for="DiaChi">Địa Chỉ</label>
                            <input type="text" class="form-control" id="DiaChi" name="DiaChi"
                                value="{{ $nhaCungCap->DiaChi }}" required>
                        </div>

                        <!-- Số Điện Thoại -->
                        <div class="form-group">
                            <label for="SDT">Số Điện Thoại</label>
                            <input type="text" class="form-control" id="SDT" name="SDT"
                                value="{{ $nhaCungCap->SDT }}" required>
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="Email">Email</label>
                            <input type="email" class="form-control" id="Email" name="Email"
                                value="{{ $nhaCungCap->Email }}" required>
                        </div>

                        <div class="form-group">
                            <label for="MaSoThue">Mã Số Thuế</label>
                            <input type="text" class="form-control" id="MaSoThue" name="MaSoThue"
                                value="{{ $nhaCungCap->MaSoThue }}" required>
                        </div>
                        <!-- Nút hành động -->
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Lưu Thay Đổi
                            </button>
                            <a href="{{ route('nhacungcap') }}" class="btn btn-secondary mx-3">Trở lại</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection