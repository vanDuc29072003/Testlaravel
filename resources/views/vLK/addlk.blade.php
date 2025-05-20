@extends('layouts.main')

@section('title', 'Thêm Linh Kiện Mới')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-md-8 col-sm-12">
                    <div class="card mx-auto">
                        <div class="card-header">
                            <h1 class="m-3">Thêm Linh Kiện Mới</h1>
                        </div>
                        <div class="card-body">
                            <form id="formLinhKien" action="{{ route('linhkien.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="TenLinhKien">Tên Linh Kiện</label>
                                            <input type="text" class="form-control" id="TenLinhKien" name="TenLinhKien" placeholder="Nhập tên linh kiện"
                                                value="{{ old('TenLinhKien') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
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
                                    <div class="col-sm-9">
                                        <div class="form-group">
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
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="MoTa">Mô Tả</label>
                                            <textarea type="text" class="form-control" id="MoTa" name="MoTa"
                                                placeholder="Nhập mô tả" value="{{ old('MoTa') }}"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer">
                            <div class="form-group d-flex justify-content-between">
                                <a href="{{ route('linhkien') }}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> Trở lại</a>
                                <button type="submit" class="btn btn-primary" form="formLinhKien">
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
