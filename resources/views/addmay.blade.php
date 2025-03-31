{{-- filepath: c:\xampp\htdocs\DoAn\resources\views\addmay.blade.php --}}
@extends('layouts.main')

@section('title', 'Thêm Máy Mới')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="card">
                <div class="card-header">
                    <h1 class="m-3">Thêm Máy Mới</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('may.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <!-- Cột 1 -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="SeriMay">Seri Máy</label>
                                    <input type="text" class="form-control" id="SeriMay" name="SeriMay"
                                        placeholder="Nhập seri máy" value="{{ old('SeriMay') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="TenMay">Tên Máy</label>
                                    <input type="text" class="form-control" id="TenMay" name="TenMay"
                                        placeholder="Nhập tên máy" value="{{ old('TenMay') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="HangSanXuat">Hãng Sản Xuất</label>
                                    <input type="text" class="form-control" id="HangSanXuat" name="HangSanXuat"
                                        placeholder="Nhập hãng sản xuất" value="{{ old('HangSanXuat') }}" required>
                                </div>
                            </div>

                            <!-- Cột 2 -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="MaNhaCungCap">Nhà Cung Cấp</label>
                                    <select class="form-control" id="MaNhaCungCap" name="MaNhaCungCap" required>
                                        <option value="">Chọn nhà cung cấp</option>
                                        @foreach ($nhaCungCaps as $nhaCungCap)
                                            <option value="{{ $nhaCungCap->MaNhaCungCap }}"
                                                {{ old('MaNhaCungCap') == $nhaCungCap->MaNhaCungCap ? 'selected' : '' }}>
                                                {{ $nhaCungCap->TenNhaCungCap }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="NamSanXuat">Năm Sản Xuất</label>
                                    <input type="number" class="form-control" id="NamSanXuat" name="NamSanXuat"
                                        placeholder="Nhập năm sản xuất" value="{{ old('NamSanXuat') }}" min="1980" required>
                                </div>

                                <div class="form-group">
                                    <label for="ThoiGianDuaVaoSuDung">Thời Gian Đưa Vào Sử Dụng</label>
                                    <input type="date" class="form-control" id="ThoiGianDuaVaoSuDung"
                                        name="ThoiGianDuaVaoSuDung" value="{{ old('ThoiGianDuaVaoSuDung', date('Y-m-d')) }}"
                                        required>
                                </div>
                            </div>

                            <!-- Cột 3 -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ChiTietLinhKien">Chi Tiết Linh Kiện</label>
                                    <input type="text" class="form-control" id="ChiTietLinhKien" name="ChiTietLinhKien"
                                        placeholder="Nhập chi tiết linh kiện" value="{{ old('ChiTietLinhKien') }}">
                                </div>

                                

                                <div class="form-group">
                                    <label for="ThoiGianBaoHanh">Thời Gian Bảo Hành</label>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control" id="ThoiGianBaoHanh"
                                            name="ThoiGianBaoHanh" placeholder="Nhập thời gian bảo hành"
                                            value="{{ old('ThoiGianBaoHanh') }}" min="1" required>
                                        <span class="input-group-text">Tháng</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ChuKyBaoTri">Chu Kỳ Bảo Trì</label>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control" id="ChuKyBaoTri" name="ChuKyBaoTri"
                                            placeholder="Nhập chu kỳ bảo trì" value="{{ old('ChuKyBaoTri') }}" min="1" required>
                                        <span class="input-group-text">Tháng</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Tạo Mới
                            </button>
                            <a href="{{ route('may') }}" class="btn btn-secondary mx-3">Trở lại</a>
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