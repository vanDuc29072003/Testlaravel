{{-- filepath: c:\xampp\htdocs\DoAn\resources\views\addmay.blade.php --}}
@extends('layouts.main')

@section('title', 'Thêm Máy Mới')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row justify-content-center">
                <div class="col-md-8 col-sm-12">
                    <div class="card mx-auto">
                        <div class="card-header">
                            <h1 class="mt-3 mx-3">Thêm Máy Mới</h1>
                        </div>
                        <div class="card-body px-5">
                            <form id="formMay" action="{{ route('may.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    {{-- Hàng 1 --}}
                                    <div class="form-group col-md-6">
                                        <label for="MaLoai">Loại Máy</label>
                                        <select class="form-control" id="MaLoai" name="MaLoai" required>
                                            <option value="">Chọn loại máy</option>
                                            @foreach ($loaiMays as $loaiMay)
                                                <option value="{{ $loaiMay->MaLoai }}" {{ old('MaLoai') == $loaiMay->MaLoai ? 'selected' : '' }}>
                                                    {{ $loaiMay->TenLoai }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="ThoiGianDuaVaoSuDung">Thời Gian Đưa Vào Sử Dụng</label>
                                        <input type="date" class="form-control" id="ThoiGianDuaVaoSuDung"
                                            name="ThoiGianDuaVaoSuDung"
                                            value="{{ old('ThoiGianDuaVaoSuDung', date('Y-m-d')) }}" required>
                                    </div>

                                    {{-- Hàng 2 --}}
                                    <div class="form-group col-md-6">
                                        <label for="TenMay">Tên Máy</label>
                                        <input type="text" class="form-control" id="TenMay" name="TenMay"
                                            placeholder="Nhập tên máy" value="{{ old('TenMay') }}" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="SeriMay">Seri Máy</label>
                                        <input type="text" class="form-control" id="SeriMay" name="SeriMay"
                                            placeholder="Nhập seri máy" value="{{ old('SeriMay') }}" required>
                                    </div>

                                    {{-- Hàng 3 --}}
                                    <div class="form-group col-md-6">
                                        <label for="MaNhaCungCap">Nhà Cung Cấp</label>
                                        <select class="form-control" id="MaNhaCungCap" name="MaNhaCungCap" required>
                                            <option value="">Chọn nhà cung cấp</option>
                                            @foreach ($nhaCungCaps as $nhaCungCap)
                                                <option value="{{ $nhaCungCap->MaNhaCungCap }}" {{ old('MaNhaCungCap') == $nhaCungCap->MaNhaCungCap ? 'selected' : '' }}>
                                                    {{ $nhaCungCap->TenNhaCungCap }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="NamSanXuat">Năm Sản Xuất</label>
                                        <input type="number" class="form-control" id="NamSanXuat" name="NamSanXuat"
                                            placeholder="Nhập năm sản xuất" value="{{ old('NamSanXuat') }}" min="1980"
                                            required>
                                    </div>

                                    {{-- Hàng 4 --}}
                                    <div class="form-group col-md-4">
                                        <label for="ThoiGianBaoHanh">Thời Gian Bảo Hành</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="ThoiGianBaoHanh"
                                                name="ThoiGianBaoHanh" placeholder="Thời gian bảo hành"
                                                value="{{ old('ThoiGianBaoHanh') }}" min="1" required>
                                            <span class="input-group-text">Tháng</span>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="ChuKyBaoTri">Chu Kỳ Bảo Trì</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="ChuKyBaoTri" name="ChuKyBaoTri"
                                                placeholder="Chu kỳ bảo trì" value="{{ old('ChuKyBaoTri') }}" min="1"
                                                required>
                                            <span class="input-group-text">Tháng</span>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="ThoiGianKhauHao">Thời Gian Khấu Hao</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="ThoiGianKhauHao"
                                                name="ThoiGianKhauHao" placeholder="Thời gian khấu hao"
                                                value="{{ old('ThoiGianKhauHao') }}" min="1" required>
                                            <span class="input-group-text">Năm</span>
                                        </div>
                                    </div>

                                    {{-- Hàng 5 --}}
                                    <div class="form-group col-md-6">
                                        <label for="GiaTriBanDau">Giá Trị Ban Đầu</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="GiaTriBanDau" name="GiaTriBanDau"
                                                placeholder="Nhập giá trị ban đầu" value="{{ old('GiaTriBanDau') }}" min="0"
                                                step="1000" required>
                                            <span class="input-group-text">VND</span>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="ChiTietLinhKien">Chi Tiết Linh Kiện</label>
                                        <input type="text" class="form-control" id="ChiTietLinhKien" name="ChiTietLinhKien"
                                            placeholder="Nhập chi tiết linh kiện" value="{{ old('ChiTietLinhKien') }}">
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="card-footer">
                            <div class="form-group d-flex justify-content-between">
                                <a href="{{ route('may') }}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> Trở lại</a>
                                <button type="submit" class="btn btn-primary" form="formMay">
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