@extends('layouts.main')

@section('title', 'Tạo Phiếu Thanh Lý')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="card w-75 mx-auto">
                <div class="card-header">
                    <h1 class="m-3">Tạo Phiếu thanh lý</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('phieuthanhly.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="MaNhanVien">Nhân viên</label>
                                    <input type="text" class="form-control" id="MaNhanVien" name="MaNhanVien"
                                        value="{{ Auth::user()->nhanVien->MaNhanVien }}" readonly>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="NgayLapPhieu">Ngày lập phiếu</label>
                                    <!-- Lấy thời gian hiện tại -->
                                    <input type="datetime-local" class="form-control" id="NgayLapPhieu" name="NgayLapPhieu"
                                        value="{{ now() }}" readonly>
                                </div>
                            </div>
                            <hr class="mt-3">
                            <div class="col-6">
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

                            <!-- Các trường hiển thị thông tin chi tiết của máy -->
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="SeriMay">Số Seri</label>
                                    <input type="text" class="form-control" id="SeriMay" name="SeriMay" readonly>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="TenLoai">Loại Máy</label>
                                    <input type="text" class="form-control" id="TenLoai" name="TenLoai" readonly>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="TenNhaCungCap">Nhà Cung Cấp</label>
                                    <input type="text" class="form-control" id="TenNhaCungCap" name="TenNhaCungCap"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="NamSanXuat">Năm Sản Xuất</label>
                                    <input type="text" class="form-control" id="NamSanXuat" name="NamSanXuat" readonly>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="HangSanXuat">Hãng Sản Xuất</label>
                                    <input type="text" class="form-control" id="HangSanXuat" name="HangSanXuat" readonly>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="ThoiGianDuaVaoSuDung">Thời Gian Đưa Vào Sử Dụng</label>
                                    <input type="text" class="form-control" id="ThoiGianDuaVaoSuDung"
                                        name="ThoiGianDuaVaoSuDung" readonly>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="ThoiGianKhauHao">Thời Gian Khấu Hao</label>
                                    <input type="text" class="form-control" id="ThoiGianKhauHao" name="ThoiGianKhauHao"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="GiaTriBanDau">Giá trị ban đầu</label>
                                    <input type="number" class="form-control" id="GiaTriBanDau" name="GiaTriBanDau"
                                        placeholder="Nhập giá trị ban đầu..." required>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="GiaTriConLai">Giá trị còn lại</label>
                                    <input type="number" class="form-control" id="GiaTriConLai" name="GiaTriConLai"
                                        placeholder="Nhập giá trị còn lại..." required>
                                </div>
                            </div>

                            <hr class="mt-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="DanhGia">Đánh giá</label>
                                    <textarea class="form-control" id="DanhGia" name="DanhGia" rows="3"
                                        placeholder="Nhập đánh giá..." required></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="GhiChu">Ghi chú</label>
                                    <textarea class="form-control" id="GhiChu" name="GhiChu" rows="2"
                                        placeholder="Nhập ghi chú..."></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- Nút hành động -->
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Tạo Mới
                            </button>
                            <a href="{{ route('phieuthanhly.index') }}" class="btn btn-secondary mx-3">Trở lại</a>
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const maMaySelect = document.getElementById('MaMay');

            maMaySelect.addEventListener('change', function () {
                const maMay = this.value;

                if (maMay) {
                    fetch(`/may/${maMay}/thongtin`)
                        .then(response => response.json())
                        .then(data => {
                            // Cập nhật các trường thông tin chi tiết
                            document.getElementById('SeriMay').value = data.SeriMay || '';
                            document.getElementById('ThoiGianDuaVaoSuDung').value = data.ThoiGianDuaVaoSuDung || '';
                            document.getElementById('ThoiGianKhauHao').value = data.ThoiGianKhauHao || '';
                            document.getElementById('NamSanXuat').value = data.NamSanXuat || '';
                            document.getElementById('HangSanXuat').value = data.HangSanXuat || '';
                            document.getElementById('TenNhaCungCap').value = data.TenNhaCungCap || '';
                            document.getElementById('TenLoai').value = data.TenLoai || '';
                        })
                        .catch(error => {
                            console.error('Error fetching machine details:', error);
                        });
                } else {
                    // Xóa dữ liệu nếu không chọn máy
                    document.getElementById('SeriMay').value = '';
                    document.getElementById('ThoiGianDuaVaoSuDung').value = '';
                    document.getElementById('ThoiGianKhauHao').value = '';
                    document.getElementById('NamSanXuat').value = '';
                    document.getElementById('HangSanXuat').value = '';
                    document.getElementById('TenNhaCungCap').value = '';
                    document.getElementById('TenLoai').value = '';
                }
            });
        });
    </script>
@endsection