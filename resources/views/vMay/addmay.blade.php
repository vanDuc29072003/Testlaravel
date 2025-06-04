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
                                        <div class="d-flex justify-content-between">
                                            <label for="MaLoai">Loại Máy</label>
                                            <a id="btn-them-loai-may" href="#" class="btn btn-sm btn-outline-white">
                                                <i class="fa fa-plus"></i> Thêm mới
                                            </a>
                                        </div>
                                        <select class="form-control" id="MaLoai" name="MaLoai" required>
                                            <option value="">Chọn loại máy</option>
                                            @foreach ($loaiMays as $loaiMay)
                                                <option value="{{ $loaiMay->MaLoai }}" {{ old('MaLoai', $mayFormData['MaLoai'] ?? '') == $loaiMay->MaLoai ? 'selected' : '' }}>
                                                    {{ $loaiMay->TenLoai }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="ThoiGianDuaVaoSuDung">Thời Gian Đưa Vào Sử Dụng</label>
                                        <input type="date" class="form-control" id="ThoiGianDuaVaoSuDung"
                                            name="ThoiGianDuaVaoSuDung"
                                            value="{{ old('ThoiGianDuaVaoSuDung', $mayFormData['ThoiGianDuaVaoSuDung'] ?? date('Y-m-d')) }}"
                                            required>
                                    </div>

                                    {{-- Hàng 2 --}}
                                    <div class="form-group col-md-6">
                                        <label for="TenMay">Tên Máy</label>
                                        <input type="text" class="form-control" id="TenMay" name="TenMay"
                                            placeholder="Nhập tên máy"
                                            value="{{ old('TenMay', $mayFormData['TenMay'] ?? '') }}" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="SeriMay">Seri Máy</label>
                                        <input type="text" class="form-control" id="SeriMay" name="SeriMay"
                                            placeholder="Nhập seri máy"
                                            value="{{ old('SeriMay', $mayFormData['SeriMay'] ?? '') }}" required>

                                    </div>

                                    {{-- Hàng 3 --}}
                                    <div class="form-group col-md-6">
                                        <div class="d-flex justify-content-between">
                                            <label for="MaNhaCungCap">Nhà Cung Cấp</label>
                                            <a id="btn-them-ncc" href="#" class="btn btn-sm btn-outline-white">
                                                <i class="fa fa-plus"></i> Thêm mới
                                            </a>
                                        </div>
                                        <select class="form-control" id="MaNhaCungCap" name="MaNhaCungCap" required>
                                            <option value="">Chọn nhà cung cấp</option>
                                            @foreach ($nhaCungCaps as $nhaCungCap)
                                                <option value="{{ $nhaCungCap->MaNhaCungCap }}" {{ old('MaNhaCungCap', $mayFormData['MaNhaCungCap'] ?? '') == $nhaCungCap->MaNhaCungCap ? 'selected' : '' }}>
                                                    {{ $nhaCungCap->TenNhaCungCap }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="NamSanXuat">Năm Sản Xuất</label>
                                        <input type="number" class="form-control" id="NamSanXuat" name="NamSanXuat"
                                            placeholder="Nhập năm sản xuất"
                                            value="{{ old('NamSanXuat', $mayFormData['NamSanXuat'] ?? '') }}" min="1980" max="{{ date('Y') }}"
                                            required>
                                    </div>

                                    {{-- Hàng 4 --}}
                                    <div class="form-group col-md-4">
                                        <label for="ThoiGianBaoHanh">Thời Gian Bảo Hành</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="ThoiGianBaoHanh"
                                                name="ThoiGianBaoHanh" placeholder="Thời gian bảo hành"
                                                value="{{ old('ThoiGianBaoHanh', $mayFormData['ThoiGianBaoHanh'] ?? '') }}"
                                                min="1" required>

                                            <span class="input-group-text">Tháng</span>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="ChuKyBaoTri">Chu Kỳ Bảo Trì</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="ChuKyBaoTri" name="ChuKyBaoTri" placeholder="Chu kỳ bảo trì"
                                                value="{{ old('ChuKyBaoTri', $mayFormData['ChuKyBaoTri'] ?? '') }}" min="1" required>
                                            <span class="input-group-text">Tháng</span>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="ThoiGianKhauHao">Thời Gian Khấu Hao</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="ThoiGianKhauHao" name="ThoiGianKhauHao"
                                                placeholder="Thời gian khấu hao" value="{{ old('ThoiGianKhauHao', $mayFormData['ThoiGianKhauHao'] ?? '') }}"
                                                min="1" required>
                                            <span class="input-group-text">Năm</span>
                                        </div>
                                    </div>

                                    {{-- Hàng 5 --}}
                                    <div class="form-group col-md-6">
                                        <label for="GiaTriBanDau">Giá Trị Ban Đầu</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="GiaTriBanDau" name="GiaTriBanDau" placeholder="Nhập giá trị ban đầu"
                                                value="{{ old('GiaTriBanDau', $mayFormData['GiaTriBanDau'] ?? '') }}" min="0" step="1000" required>
                                            <span class="input-group-text">VND</span>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="ChiTietLinhKien">Chi Tiết Linh Kiện</label>
                                        <input type="text" class="form-control" id="ChiTietLinhKien" name="ChiTietLinhKien"
                                            placeholder="Nhập chi tiết linh kiện"
                                            value="{{ old('ChiTietLinhKien', $mayFormData['ChiTietLinhKien'] ?? '') }}">
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
        document.getElementById('btn-them-loai-may').onclick = function(e) {
            e.preventDefault();
            let form = document.getElementById('formMay');
            let formData = new FormData(form);
            fetch('{{ route('may.saveFormSession') }}', {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'ok') {
                    window.location.href = "{{ route('loaimay.createLoaiMayfromMay') }}";
                }
            });
        }
    </script>
    <script>
        document.getElementById('btn-them-ncc').onclick = function(e) {
            e.preventDefault();
            let form = document.getElementById('formMay');
            let formData = new FormData(form);
            fetch('{{ route('may.saveFormSession') }}', {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'ok') {
                    window.location.href = "{{ route('nhacungcap.createNCCfromMay') }}";
                }
            });
        }
    </script>
    <script>
        document.getElementById('TenMay').addEventListener('input', function(e) {
            // Chỉ cho phép chữ cái, số, khoảng trắng, gạch ngang, gạch dưới
            this.value = this.value.replace(/[^\p{L}0-9 _-,.()]/gu, '');
        });
        document.getElementById('SeriMay').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^\p{L}0-9]/gu, '');
        });
    </script>
    <script>
        const GiaTriBanDau = document.getElementById('GiaTriBanDau');
        GiaTriBanDau.addEventListener('input', function(e) {
            // Lưu vị trí con trỏ
            let cursor = this.selectionStart;
            // Loại bỏ ký tự không phải số
            let raw = this.value.replace(/[^0-9]/g, '');
            // Format lại
            this.value = raw ? Number(raw).toLocaleString('vi-VN') : '';
            // Đặt lại vị trí con trỏ
            this.setSelectionRange(cursor, cursor);
        });
    </script>
    <script>
        document.getElementById('formMay').addEventListener('submit', function(e) {
            const GiaTriBanDauInput = document.getElementById('GiaTriBanDau');
            if (GiaTriBanDauInput) {
                GiaTriBanDauInput.value = GiaTriBanDauInput.value.replace(/[.]/g, '').replace(',', '.');
            }
        })
    </script>
@endsection