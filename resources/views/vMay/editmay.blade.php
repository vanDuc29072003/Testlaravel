@extends('layouts.main')

@section('title', 'Chỉnh sửa thông tin máy')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row justify-content-center">
            <div class="col-md-8 col-sm-12">
                <div class="card mx-auto">
                    <div class="card-header">
                        <h1 class="mt-3 mx-3">Chỉnh sửa thông tin máy</h1>
                    </div>
                    <div class="card-body px-5">
                        <form id="formMay" action="{{ route('may.update', $may->MaMay) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="MaMay">Mã Máy</label>
                                    <input type="text" class="form-control" id="MaMay" name="MaMay"
                                        value="{{ old('MaMay', $may->MaMay2) }}" disabled>
                                </div>
                                {{-- Hàng 1 --}}
                                <div class="form-group col-md-4">
                                    <label for="MaLoai">Loại Máy</label>
                                    <select class="form-control" id="MaLoai" name="MaLoai" required>
                                        <option value="">Chọn loại máy</option>
                                        @foreach ($loaiMays as $loaiMay)
                                            <option value="{{ $loaiMay->MaLoai }}"
                                                {{ old('MaLoai', $may->MaLoai) == $loaiMay->MaLoai ? 'selected' : '' }}>
                                                {{ $loaiMay->TenLoai }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="ThoiGianDuaVaoSuDung">Thời Gian Đưa Vào Sử Dụng</label>
                                    <input type="date" class="form-control" id="ThoiGianDuaVaoSuDung" name="ThoiGianDuaVaoSuDung"
                                        value="{{ old('ThoiGianDuaVaoSuDung', $may->ThoiGianDuaVaoSuDung) }}" required>
                                </div>

                                {{-- Hàng 2 --}}
                                <div class="form-group col-md-6">
                                    <label for="TenMay">Tên Máy</label>
                                    <input type="text" class="form-control" id="TenMay" name="TenMay" placeholder="Nhập tên máy"
                                        value="{{ old('TenMay', $may->TenMay) }}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="SeriMay">Seri Máy</label>
                                    <input type="text" class="form-control" id="SeriMay" name="SeriMay" placeholder="Nhập seri máy"
                                        value="{{ old('SeriMay', $may->SeriMay) }}" required>
                                </div>

                                {{-- Hàng 3 --}}
                                <div class="form-group col-md-6">
                                    <label for="MaNhaCungCap">Nhà Cung Cấp</label>
                                    <select class="form-control" id="MaNhaCungCap" name="MaNhaCungCap" required>
                                        <option value="">Chọn nhà cung cấp</option>
                                        @foreach ($nhaCungCaps as $nhaCungCap)
                                            <option value="{{ $nhaCungCap->MaNhaCungCap }}"
                                                {{ old('MaNhaCungCap', $may->MaNhaCungCap) == $nhaCungCap->MaNhaCungCap ? 'selected' : '' }}>
                                                {{ $nhaCungCap->TenNhaCungCap }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="NamSanXuat">Năm Sản Xuất</label>
                                    <input type="number" class="form-control" id="NamSanXuat" name="NamSanXuat" placeholder="Nhập năm sản xuất"
                                        value="{{ old('NamSanXuat', $may->NamSanXuat) }}" min="1980" required>
                                </div>

                                {{-- Hàng 4 --}}
                                <div class="form-group col-md-4">
                                    <label for="ThoiGianBaoHanh">Thời Gian Bảo Hành</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="ThoiGianBaoHanh" name="ThoiGianBaoHanh"
                                            placeholder="Thời gian bảo hành" value="{{ old('ThoiGianBaoHanh', $may->ThoiGianBaoHanh) }}" min="1" required>
                                        <span class="input-group-text">Tháng</span>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="ChuKyBaoTri">Chu Kỳ Bảo Trì</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="ChuKyBaoTri" name="ChuKyBaoTri" placeholder="Chu kỳ bảo trì"
                                            value="{{ old('ChuKyBaoTri', $may->ChuKyBaoTri) }}" min="1" required>
                                        <span class="input-group-text">Tháng</span>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="ThoiGianKhauHao">Thời Gian Khấu Hao</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="ThoiGianKhauHao" name="ThoiGianKhauHao"
                                            placeholder="Thời gian khấu hao" value="{{ old('ThoiGianKhauHao', $may->ThoiGianKhauHao) }}" min="1" required>
                                        <span class="input-group-text">Năm</span>
                                    </div>
                                </div>

                                {{-- Hàng 5 --}}
                                <div class="form-group col-md-6">
                                    <label for="GiaTriBanDau">Giá Trị Ban Đầu</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="GiaTriBanDau" name="GiaTriBanDau"
                                            placeholder="Nhập giá trị ban đầu" value="{{ old('GiaTriBanDau', $may->GiaTriBanDau) }}" min="0" step="1000" required>
                                        <span class="input-group-text">VND</span>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="ChiTietLinhKien">Chi Tiết Linh Kiện</label>
                                    <input type="text" class="form-control" id="ChiTietLinhKien" name="ChiTietLinhKien"
                                        placeholder="Nhập chi tiết linh kiện" value="{{ old('ChiTietLinhKien', $may->ChiTietLinhKien) }}">
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="form-group d-flex justify-content-between">
                            <a href="{{ route('may') }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> Trở lại
                            </a>
                            <button type="submit" class="btn btn-primary" form="formMay">
                                <i class="fa fa-save"></i> Cập nhật
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection