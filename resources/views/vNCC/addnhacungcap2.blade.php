@extends('layouts.main')

@section('title', 'Thêm Nhà Cung Cấp')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-md-8 col-sm-12">
                    <div class="card mx-auto">
                        <div class="card-header">
                            <h1 class="m-3">Thêm Nhà Cung Cấp</h1>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form id="formNhaCungCap" action="{{ route('nhacungcap.store2') }}" method="POST">
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

                            </form>
                        </div>
                        <div class="card-footer">
                            <div class="form-group d-flex justify-content-between">
                                @php
                                    $maLinhKien = session('editing_linhkien_id');
                                @endphp

                                <a href="{{ $maLinhKien ? route('linhkien.edit', $maLinhKien) : route('nhacungcap') }}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> Trở lại
                                </a>
                                <button type="submit" class="btn btn-primary" form="formNhaCungCap">
                                    <i class="fa fa-save"></i> Tạo Mới
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    
@endsection