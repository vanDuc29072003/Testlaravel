@extends('layouts.main')

@section('title', 'Tạo Yêu Cầu Sửa Chữa')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="card w-50 mx-auto">
                <div class="card-header">
                    <h1 class="m-3">Tạo yêu cầu sửa chữa</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('yeucausuachua.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="TenNhanVien">Nhân Viên</label>
                                    <!-- Hiển thị tên nhân viên từ người dùng đang đăng nhập -->
                                    <input type="text" class="form-control" id="TenNhanVien" name="TenNhanVien"
                                        value="{{ $nhanVien->TenNhanVien }}" readonly>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="ThoiGianYeuCau">Thời Gian Yêu Cầu</label>
                                    <!-- Lấy thời gian hiện tại -->
                                    <input type="text" class="form-control" id="ThoiGianYeuCau" name="ThoiGianYeuCau"
                                        value="{{ now()->format('d-m-Y H:i:s') }}" readonly>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="MaMay">Máy</label>
                                    <select class="form-control" id="MaMay" name="MaMay" required>
                                        <option value="">-- Chọn máy --</option>
                                        @foreach ($dsMay as $may)
                                            <option value="{{ $may->MaMay }}">{{ $may->TenMay }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="MoTa">Mô Tả</label>
                                    <textarea class="form-control" id="MoTa" name="MoTa" rows="3"
                                        placeholder="Nhập mô tả..." required></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- Nút hành động -->
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Tạo Mới
                            </button>
                            <a href="{{ route('yeucausuachua.index') }}" class="btn btn-secondary mx-3">Trở lại</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        @if (session('error'))
            $.notify({
                title: 'Lỗi',
                message: '{{ session('error') }}',
                icon: 'icon-bell'
            }, {
                type: 'danger',
                animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutUp'
                },
            });
        @endif
    </script>
@endsection