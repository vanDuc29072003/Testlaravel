@extends('layouts.main')

@section('title', 'Chỉnh sửa Phiếu Thanh Lý')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row d-flex justify-content-center">
                <div class="col-xl-9 col-lg-12 col-md-8 col-sm-10">
                    <div class="card mx-auto">
                        <div class="card-header">
                            <h1 class="m-3">Chỉnh sửa Phiếu Thanh Lý</h1>
                        </div>
                        <div class="card-body px-5">
                            <form id="formPhieuThanhLy"
                                action="{{ route('phieuthanhly.update', $phieuThanhLy->MaPhieuThanhLy) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label for="MaNhanVien">Nhân viên</label>
                                        <input type="text" class="form-control" id="MaNhanVien" name="MaNhanVien"
                                            value="{{ $phieuThanhLy->nhanVien->TenNhanVien }}" readonly>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="NgayLapPhieu">Ngày lập phiếu</label>
                                        <input type="datetime-local" class="form-control" id="NgayLapPhieu"
                                            name="NgayLapPhieu" value="{{ $phieuThanhLy->NgayLapPhieu }}" readonly>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="MaMay">Máy</label>
                                        <select class="form-control" id="MaMay" name="MaMay" required>
                                            <option value="">-- Chọn máy --</option>
                                            @foreach ($dsMay as $may)
                                                <option value="{{ $may->MaMay }}" {{ $may->MaMay == $phieuThanhLy->MaMay ? 'selected' : '' }}>
                                                    {{ $may->TenMay }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label for="SeriMay">Số Seri</label>
                                        <input type="text" class="form-control" id="SeriMay" name="SeriMay"
                                            value="{{ $phieuThanhLy->may->SeriMay ?? '' }}" readonly>
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label for="TenLoai">Loại Máy</label>
                                        <input type="text" class="form-control" id="TenLoai" name="TenLoai"
                                            value="{{ $phieuThanhLy->may->loaiMay->TenLoai ?? '' }}" readonly>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="TenNhaCungCap">Nhà Cung Cấp</label>
                                        <input type="text" class="form-control" id="TenNhaCungCap" name="TenNhaCungCap"
                                            value="{{ $phieuThanhLy->may->nhaCungCap->TenNhaCungCap ?? '' }}" readonly>
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label for="NamSanXuat">Năm Sản Xuất</label>
                                        <input type="text" class="form-control" id="NamSanXuat" name="NamSanXuat"
                                            value="{{ $phieuThanhLy->may->NamSanXuat ?? '' }}" readonly>
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label for="ThoiGianDuaVaoSuDung">Thời Gian Đưa Vào Sử Dụng</label>
                                        <input type="text" class="form-control" id="ThoiGianDuaVaoSuDung"
                                            name="ThoiGianDuaVaoSuDung"
                                            value="{{ $phieuThanhLy->may->ThoiGianDuaVaoSuDung ?? '' }}" readonly>
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label for="ThoiGianBaoHanh">Thời Gian Bảo Hành</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="ThoiGianBaoHanh"
                                                name="ThoiGianBaoHanh" readonly>
                                            <span class="input-group-text">Tháng</span>
                                        </div>
                                        <div id="badgeBaoHanh" class="mt-1"></div>
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label for="ThoiGianKhauHao">Thời Gian Khấu Hao</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="ThoiGianKhauHao"
                                                name="ThoiGianKhauHao"
                                                value="{{ $phieuThanhLy->may->ThoiGianKhauHao ?? '' }}" readonly>
                                            <span class="input-group-text">Năm</span>
                                        </div>
                                        <div id="badgeKhauHao" class="mt-1"></div>
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label for="GiaTriBanDau">Giá trị ban đầu</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="GiaTriBanDau" name="GiaTriBanDau"
                                                readonly style="display: none;">
                                            <input type="text" class="form-control" id="GiaTriBanDauHienThi"
                                                name="GiaTriBanDauHienThi" readonly>
                                            <span class="input-group-text">VNĐ</span>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-3">
                                    <label for="GiaTriConLai">Giá trị còn lại</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="GiaTriConLai" name="GiaTriConLai"
                                                value="{{ number_format($phieuThanhLy->GiaTriConLai, 0, ',', '.') }}" required>
                                            <span class="input-group-text">VNĐ</span>
                                        </div>
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="DanhGia">Đánh giá</label>
                                        <textarea class="form-control" id="DanhGia" name="DanhGia" rows="3"
                                            required>{{ $phieuThanhLy->DanhGia }}</textarea>
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="GhiChu">Ghi chú</label>
                                        <textarea class="form-control" id="GhiChu" name="GhiChu"
                                            rows="2">{{ $phieuThanhLy->GhiChu }}</textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between m-3">
                                <a href="{{ route('phieuthanhly.index') }}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> Trở lại</a>
                                <button type="submit" class="btn btn-primary" form="formPhieuThanhLy">
                                    <i class="fa fa-save"></i> Lưu Thay Đổi
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
        document.addEventListener('DOMContentLoaded', function () {
            //Hàm format lại GiaTriBanDau
            function formatCurrency(value) {
                if (!value) return '';
                return Number(value).toLocaleString('vi-VN');
            }

            const maMaySelect = document.getElementById('MaMay');
            function loadThongTinMay(maMay) {
                if (maMay) {
                    fetch(`/may/${maMay}/thongtin`)
                        .then(response => response.json())
                        .then(data => {
                            // Cập nhật các trường thông tin chi tiết
                            document.getElementById('SeriMay').value = data.SeriMay || '';
                            document.getElementById('ThoiGianDuaVaoSuDung').value = data.ThoiGianDuaVaoSuDung || '';
                            document.getElementById('ThoiGianKhauHao').value = data.ThoiGianKhauHao || '';
                            document.getElementById('NamSanXuat').value = data.NamSanXuat || '';
                            document.getElementById('ThoiGianBaoHanh').value = data.ThoiGianBaoHanh || '';
                            document.getElementById('GiaTriBanDau').value = data.GiaTriBanDau || '';
                            document.getElementById('GiaTriBanDauHienThi').value = formatCurrency(data.GiaTriBanDau) || '';
                            document.getElementById('TenNhaCungCap').value = data.TenNhaCungCap || '';
                            document.getElementById('TenLoai').value = data.TenLoai || '';
                            document.getElementById('badgeBaoHanh').innerHTML =
                                data.TrangThaiBaoHanh === 'Còn bảo hành'
                                    ? '<span class="badge bg-success">Còn bảo hành</span>'
                                    : '<span class="badge bg-danger">Đã hết bảo hành</span>';

                            document.getElementById('badgeKhauHao').innerHTML =
                                data.TrangThaiKhauHao === 'Còn khấu hao'
                                    ? '<span class="badge bg-success">Còn khấu hao</span>'
                                    : '<span class="badge bg-danger">Đã hết khấu hao</span>';
                        })
                        .catch(error => {
                            console.error('Load dữ liệu máy lỗi: ', error);
                        });
                } else {
                    // Xóa dữ liệu nếu không chọn máy
                    document.getElementById('SeriMay').value = '';
                    document.getElementById('ThoiGianDuaVaoSuDung').value = '';
                    document.getElementById('ThoiGianKhauHao').value = '';
                    document.getElementById('NamSanXuat').value = '';
                    document.getElementById('ThoiGianBaoHanh').value = '';
                    document.getElementById('GiaTriBanDau').value = '';
                    document.getElementById('GiaTriBanDauHienThi').value = '';
                    document.getElementById('TenNhaCungCap').value = '';
                    document.getElementById('TenLoai').value = '';
                    document.getElementById('badgeBaoHanh').innerHTML = '<span style="display: none;"></span>';
                    document.getElementById('badgeKhauHao').innerHTML = '<span style="display: none;"></span>';
                }
            }

            maMaySelect.addEventListener('change', function () {
                const maMay = this.value;
                loadThongTinMay(maMay);
            });

            // Gọi hàm khi trang được tải nếu đã có selectedMaMay
            const selectedMaMay = maMaySelect.value;
            if (selectedMaMay) {
                loadThongTinMay(selectedMaMay);
            }
        });
    </script>
    <script>
        const giaTriConLaiInput = document.getElementById('GiaTriConLai');
        giaTriConLaiInput.addEventListener('input', function(e) {
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
        document.getElementById('formPhieuThanhLy').addEventListener('submit', function () {
            const giaTriConLaiInput = document.getElementById('GiaTriConLai');
            if (giaTriConLaiInput) {
                // Loại bỏ tất cả dấu chấm, nếu là dấu phẩy thì đổi thành dấu chấm cho đúng định dạng
                giaTriConLaiInput.value = giaTriConLaiInput.value.replace(/[.]/g, '').replace(',', '.');
            }
        });
    </script>
@endsection