@extends('layouts.main')

@section('title', 'Chỉnh sửa thông tin máy')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <!-- Cột 1 -->
                    <div class="col-md-6">
                        <h1>Chỉnh sửa thông tin máy</h1>
                    </div>
                    <div class="col-md-6">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('may.edit', $may->MaMay) }}" method="POST">
                    @csrf
                    <div class="row">
                        <!-- Cột 1 -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="SeriMay">Seri Máy</label>
                                <input type="text" class="form-control" id="SeriMay" name="SeriMay"
                                    placeholder="Nhập seri máy" value="{{ $may->SeriMay }}" required readonly>
                            </div>

                            <div class="form-group">
                                <label for="TenMay">Tên Máy</label>
                                <input type="text" class="form-control" id="TenMay" name="TenMay"
                                    placeholder="Nhập tên máy" value="{{ $may->TenMay }}" required readonly>
                            </div>

                            <div class="form-group">
                                <label for="HangSanXuat">Hãng Sản Xuất</label>
                                <input type="text" class="form-control" id="HangSanXuat" name="HangSanXuat"
                                    placeholder="Nhập hãng sản xuất" value="{{ $may->HangSanXuat }}" required readonly>
                            </div>
                        </div>

                        <!-- Cột 2 -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="MaNhaCungCap">Nhà Cung Cấp</label>
                                <select class="form-control" id="MaNhaCungCap" name="MaNhaCungCap" required disabled>
                                    <option value="">Chọn nhà cung cấp</option>
                                    @foreach ($nhaCungCaps as $nhaCungCap)
                                        <option value="{{ $nhaCungCap->MaNhaCungCap }}"
                                            {{ $may->MaNhaCungCap == $nhaCungCap->MaNhaCungCap ? 'selected' : '' }}>
                                            {{ $nhaCungCap->TenNhaCungCap }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="NamSanXuat">Năm Sản Xuất</label>
                                <input type="number" class="form-control" id="NamSanXuat" name="NamSanXuat"
                                    placeholder="Nhập năm sản xuất" value="{{ $may->NamSanXuat }}" required readonly>
                            </div>

                            <div class="form-group">
                                <label for="ThoiGianDuaVaoSuDung">Thời Gian Đưa Vào Sử Dụng</label>
                                <input type="date" class="form-control" id="ThoiGianDuaVaoSuDung"
                                    name="ThoiGianDuaVaoSuDung" value="{{ $may->ThoiGianDuaVaoSuDung }}"
                                    required readonly>
                            </div>
                        </div>

                        <!-- Cột 3 -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="ChiTietLinhKien">Chi Tiết Linh Kiện</label>
                                <input type="text" class="form-control" id="ChiTietLinhKien" name="ChiTietLinhKien"
                                    placeholder="Nhập chi tiết linh kiện" value="{{ $may->ChiTietLinhKien }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="ThoiGianBaoHanh">Thời Gian Bảo Hành</label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" id="ThoiGianBaoHanh"
                                        name="ThoiGianBaoHanh" placeholder="Nhập thời gian bảo hành"
                                        value="{{ $may->ThoiGianBaoHanh }}" required readonly>
                                    <span class="input-group-text">Tháng</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ChuKyBaoTri">Chu Kỳ Bảo Trì</label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" id="ChuKyBaoTri" name="ChuKyBaoTri"
                                        placeholder="Nhập chu kỳ bảo trì" value="{{ $may->ChuKyBaoTri }}" min="1" required>
                                    <span class="input-group-text">Tháng</span>
                                </div>
                            </div>
                        </div>
                    </div>

                        <div class="form-group mt-4">
                            <a href="{{ route('may') }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> Quay lại
                            </a>
                            <button type="submit" class="btn btn-primary mx-3">
                                    <i class="fa fa-save"></i> Cập nhật
                                </a>
                            </button>
                            
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection