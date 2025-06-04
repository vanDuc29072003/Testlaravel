@extends('layouts.main')

@section('title', 'Chỉnh Sửa Nhà Cung Cấp')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-md-8 col-sm-12">
                    <div class="card mx-auto">
                        <div class="card-header">
                            <h1 class="mx-3 mt-3">Chỉnh Sửa Nhà Cung Cấp</h1>
                        </div>
                        <div class="card-body">
                            <form id="formNhaCungCap" action="{{ route('nhacungcap.update', $nhaCungCap->MaNhaCungCap) }}" method="POST">
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
                            </form>
                        </div>
                        <div class="card-footer">
                            <!-- Nút hành động -->
                            <div class="form-group d-flex justify-content-between">
                                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> Trở lại</a>
                                <button type="submit" class="btn btn-primary" form="formNhaCungCap">
                                    <i class="fa fa-save"></i> Lưu Thay Đổi
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
    <script>
        document.getElementById('TenNhaCungCap').addEventListener('input', function(e) {
            // Chỉ cho phép chữ cái, số, khoảng trắng, gạch ngang, gạch dưới
            this.value = this.value.replace(/[^\p{L}0-9 _\-,.()]/gu, '');
        });
        document.getElementById('SDT').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/gu, '');
        });
        document.getElementById('MaSoThue').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9-]/gu, '');
        });
    </script>
@endsection