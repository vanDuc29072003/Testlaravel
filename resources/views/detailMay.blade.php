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
                                <label class="form-label fw-bold">Mã Máy:</label>
                                <p class="form-control-plaintext">{{ $may->MaMay }}</p>
                            </div>
                            <hr class="my-3">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tên Máy:</label>
                                <p class="form-control-plaintext">{{ $may->TenMay }}</p>
                            </div>
                            <hr class="my-3">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Seri Máy:</label>
                                <p class="form-control-plaintext">{{ $may->SeriMay }}</p>
                            </div>
                            <hr class="my-3">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Chu Kỳ Bảo Trì:</label>
                                <p class="form-control-plaintext">{{ $may->ChuKyBaoTri }} tháng</p>
                            </div>
                            <hr class="my-3">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Thời Gian Bảo Hành:</label>
                                <p class="form-control-plaintext">{{ $may->ThoiGianBaoHanh }} tháng</p>
                            </div>
                        </div>

                        <!-- Cột 2 -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Thời Gian Đưa Vào Sử Dụng:</label>
                                <p class="form-control-plaintext">{{ $may->ThoiGianDuaVaoSuDung }}</p>
                            </div>
                            <hr class="my-3">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Năm Sản Xuất:</label>
                                <p class="form-control-plaintext">{{ $may->NamSanXuat }}</p>
                            </div>
                            <hr class="my-3">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Hãng Sản Xuất:</label>
                                <p class="form-control-plaintext">{{ $may->HangSanXuat }}</p>
                            </div>
                            <hr class="my-3">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Chi Tiết Linh Kiện:</label>
                                <a href="{{ $may->ChiTietLinhKien }}" target="_blank"
                                    class="form-control-plaintext">
                                    <i class="fa fa-file-pdf"></i>
                                    Mở file chi tiết
                                </a>
                            </div>
                            <hr class="my-3">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Mã Nhà Cung Cấp:</label>
                                <p class="form-control-plaintext">{{ $may->MaNhaCungCap }}</p>
                            </div>
                        </div>
                    </div>
                    <hr class="my-4"> <!-- Đường kẻ ngang tách nội dung với nút -->
                    <!-- Nút quay lại -->
                    <div class="text-center">
                        <a href="{{ route('may') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection