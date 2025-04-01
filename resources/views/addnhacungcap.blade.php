@extends('layouts.main')

@section('title', 'Thêm Nhà Cung Cấp')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="card w-50 mx-auto">
                <div class="card-header">
                    <h1 class="m-3">Thêm Nhà Cung Cấp</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('nhacungcap.store') }}" method="POST">
                        @csrf
                        <!-- Tên Nhà Cung Cấp -->
                        <div class="form-group">
                            <label for="TenNhaCungCap">Tên Nhà Cung Cấp</label>
                            <input type="text" class="form-control" id="TenNhaCungCap" name="TenNhaCungCap"
                                placeholder="Nhập tên nhà cung cấp" value="{{ old('TenNhaCungCap') }}" required>
                        </div>

                        <!-- Địa Chỉ -->
                        <div class="form-group">
                            <label for="DiaChi">Địa Chỉ</label>
                            <input type="text" class="form-control" id="DiaChi" name="DiaChi"
                                placeholder="Nhập địa chỉ" value="{{ old('DiaChi') }}" required>
                        </div>

                        <!-- Số Điện Thoại -->
                        <div class="form-group">
                            <label for="SDT">Số Điện Thoại</label>
                            <input type="text" class="form-control" id="SDT" name="SDT"
                                placeholder="Nhập số điện thoại" value="{{ old('SDT') }}" required>
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="Email">Email</label>
                            <input type="email" class="form-control" id="Email" name="Email"
                                placeholder="Nhập email" value="{{ old('Email') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="MaSoThue">Mã Số Thuế</label>
                            <input type="text" class="form-control" id="MaSoThue" name="MaSoThue"
                                placeholder="Nhập mã số thuế" value="{{ old('MaSoThue') }}" required>
                        </div>
                        <!-- Nút hành động -->
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Tạo Mới
                            </button>
                            <a href="{{ route('nhacungcap') }}" class="btn btn-secondary mx-3">Trở lại</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection