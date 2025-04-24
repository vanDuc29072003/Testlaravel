@extends('layouts.main')

@section('title', 'Thêm Linh Kiện Mới')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="card shadow-sm">
            <div class="card-header">
                <h1 class="m-3">Thêm Linh Kiện Mới</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('linhkien.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <!-- Cột 1 -->
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="TenLinhKien">Tên Linh Kiện</label>
                                <input type="text" class="form-control" id="TenLinhKien" name="TenLinhKien"
                                       placeholder="Nhập tên linh kiện" value="{{ old('TenLinhKien') }}" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="MaDonViTinh">Đơn Vị Tính</label>
                                <select class="form-control" id="MaDonViTinh" name="MaDonViTinh" required>
                                    <option value="">Chọn đơn vị tính</option>
                                    @foreach ($donViTinhs as $donViTinh)
                                        <option value="{{ $donViTinh->MaDonViTinh }}"
                                            {{ old('MaDonViTinh') == $donViTinh->MaDonViTinh ? 'selected' : '' }}>
                                            {{ $donViTinh->TenDonViTinh }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Cột 2 -->
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="SoLuong">Số Lượng</label>
                                <input type="number" class="form-control" id="SoLuong" name="SoLuong"
                                       placeholder="Nhập số lượng" value="{{ old('SoLuong') }}" min="1" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="MoTa">Mô Tả</label>
                                <input type="text" class="form-control" id="MoTa" name="MoTa"
                                       placeholder="Nhập mô tả" value="{{ old('MoTa') }}">
                            </div>
                        </div>

                        <!-- Cột 3 -->
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="nhaCungCapSelect">Nhà Cung Cấp</label>
                                <select class="form-control" id="nhaCungCapSelect" name="MaNhaCungCap" required>
                                    <option value="">Chọn nhà cung cấp</option>
                                    @foreach ($nhaCungCaps as $nhaCungCap)
                                        <option value="{{ $nhaCungCap->MaNhaCungCap }}"
                                            {{ old('MaNhaCungCap') == $nhaCungCap->MaNhaCungCap ? 'selected' : '' }}>
                                            {{ $nhaCungCap->TenNhaCungCap }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Tạo Mới
                        </button>
                        <a href="{{ route('linhkien') }}" class="btn btn-secondary mx-3">Trở lại</a>
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
