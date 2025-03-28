{{-- filepath: c:\xampp\htdocs\DoAn\resources\views\addmay.blade.php --}}
@extends('layouts.main')

@section('title', 'Thêm Máy Mới')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="card">
                <div class="card-header">
                    <h1>Thông Tin Máy</h1>
                </div>
                <div class="card-body p-lg-5">
                    <div class="row">
                        <!-- Cột 1 -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="MaMay" class="form-label"><strong>Mã Máy:</strong></label>
                                <p class="form-control-plaintext">{{ $may->MaMay }}</p>
                            </div>
                            <div class="mb-3">
                                <label for="TenMay" class="form-label"><strong>Tên Máy:</strong></label>
                                <p class="form-control-plaintext">{{ $may->TenMay }}</p>
                            </div>
                            <div class="mb-3">
                                <label for="SeriMay" class="form-label"><strong>Seri Máy:</strong></label>
                                <p class="form-control-plaintext">{{ $may->SeriMay }}</p>
                            </div>
                            <div class="mb-3">
                                <label for="ChuKyBaoTri" class="form-label"><strong>Chu Kỳ Bảo Trì:</strong></label>
                                <p class="form-control-plaintext">{{ $may->ChuKyBaoTri }} tháng</p>
                            </div>
                            <div class="mb-3">
                                <label for="ThoiGianBaoHanh" class="form-label"><strong>Thời Gian Bảo Hành:</strong></label>
                                <p class="form-control-plaintext">{{ $may->ThoiGianBaoHanh }} tháng</p>
                            </div>
                        </div>

                        <!-- Cột 2 -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ThoiGianDuaVaoSuDung" class="form-label"><strong>Thời Gian Đưa Vào Sử
                                        Dụng:</strong></label>
                                <p class="form-control-plaintext">{{ $may->ThoiGianDuaVaoSuDung }}</p>
                            </div>
                            <div class="mb-3">
                                <label for="NamSanXuat" class="form-label"><strong>Năm Sản Xuất:</strong></label>
                                <p class="form-control-plaintext">{{ $may->NamSanXuat }}</p>
                            </div>
                            <div class="mb-3">
                                <label for="HangSanXuat" class="form-label"><strong>Hãng Sản Xuất:</strong></label>
                                <p class="form-control-plaintext">{{ $may->HangSanXuat }}</p>
                            </div>
                            <div class="mb-3">
                                <label for="ChiTietLinhKien" class="form-label"><strong>Chi Tiết Linh Kiện:</strong></label>
                                <a class="form-control-plaintext">{{ $may->ChiTietLinhKien }}</>
                            </div>
                            <div class="mb-3">
                                <label for="MaNhaCungCap" class="form-label"><strong>Mã Nhà Cung Cấp:</strong></label>
                                <p class="form-control-plaintext">{{ $may->MaNhaCungCap }}</p>
                            </div>
                        </div>
                    </div>
                    <!-- Nút quay lại -->
                    <div class="mt-3">
                        <a href="{{ route('may') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection