@extends('layouts.main')

@section('title', 'Chi Tiết Phiếu Thanh Lý')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card mx-auto">
                        <div class="card-header">
                            <div class="mt-3 mx-3 d-flex justify-content-between">
                                <h2 class="ps-3 mb-0">Thông Tin Phiếu Thanh Lý</h2>
                                <div class="d-flex justify-content-end">
                                    @if ($phieuThanhLy->TrangThai == 0)
                                        <a href="{{ route('phieuthanhly.edit', $phieuThanhLy->MaPhieuThanhLy) }}"
                                            class="btn btn-warning text-black">
                                            <i class="fa fa-edit"></i> Sửa
                                        </a>
                                    @else
                                        <a href="{{ route('phieuthanhly.exportPDF', $phieuThanhLy->MaPhieuThanhLy) }}"
                                            class="btn btn-black btn-border ms-3">
                                            <i class="fas fa-file-download"></i> Xuất FILE PDF
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-3 px-5">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="NgayLapPhieu">Ngày lập phiếu</label>
                                        <input type="text" class="form-control" id="NgayLapPhieu" name="NgayLapPhieu"
                                            value="{{ \Carbon\Carbon::parse($phieuThanhLy->NgayLapPhieu)->format('d-m-Y') }}"
                                            readonly>
                                    </div>
                                </div>
                                @if ($phieuThanhLy->TrangThai == 1)
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="MaNhanVien">Nhân viên tạo</label>
                                            <input type="text" class="form-control" id="MaNhanVien" name="MaNhanVien"
                                                value="{{ $phieuThanhLy->nhanVien->TenNhanVien }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="MaNhanVienDuyet">Nhân viên duyệt</label>
                                            <input type="text" class="form-control" id="MaNhanVienDuyet" name="MaNhanVienDuyet"
                                                value="{{ $phieuThanhLy->nhanVienDuyet->TenNhanVien }}" readonly>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="MaNhanVien">Nhân viên tạo</label>
                                            <input type="text" class="form-control" id="MaNhanVien" name="MaNhanVien"
                                                value="{{ $phieuThanhLy->nhanVien->TenNhanVien }}" readonly>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="MaMay">Máy</label>
                                        <input type="text" class="form-control" id="MaMay" name="MaMay"
                                            value="{{ $phieuThanhLy->may->TenMay }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="SeriMay">Số Seri</label>
                                        <input type="text" class="form-control" id="SeriMay" name="SeriMay"
                                            value="{{ $phieuThanhLy->may->SeriMay ?? '' }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="TenLoai">Loại Máy</label>
                                        <input type="text" class="form-control" id="TenLoai" name="TenLoai"
                                            value="{{ $phieuThanhLy->may->loaiMay->TenLoai ?? '' }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="TenNhaCungCap">Nhà Cung Cấp</label>
                                        <input type="text" class="form-control" id="TenNhaCungCap" name="TenNhaCungCap"
                                            value="{{ $phieuThanhLy->may->nhaCungCap->TenNhaCungCap ?? '' }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="NamSanXuat">Năm Sản Xuất</label>
                                        <input type="text" class="form-control" id="NamSanXuat" name="NamSanXuat"
                                            value="{{ $phieuThanhLy->may->NamSanXuat ?? '' }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="HangSanXuat">Hãng Sản Xuất</label>
                                        <input type="text" class="form-control" id="HangSanXuat" name="HangSanXuat"
                                            value="{{ $phieuThanhLy->may->HangSanXuat ?? '' }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="ThoiGianDuaVaoSuDung">Thời Gian Đưa Vào Sử Dụng</label>
                                        <input type="text" class="form-control" id="ThoiGianDuaVaoSuDung"
                                            name="ThoiGianDuaVaoSuDung" value="{{ $phieuThanhLy->may->ThoiGianDuaVaoSuDung ?? '' }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="ThoiGianKhauHao">Thời Gian Khấu Hao</label>
                                        <input type="text" class="form-control" id="ThoiGianKhauHao" name="ThoiGianKhauHao"
                                            value="{{ $phieuThanhLy->may->ThoiGianKhauHao ?? '' }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="GiaTriBanDau">Giá trị ban đầu</label>
                                        <input type="text" class="form-control" id="GiaTriBanDau" name="GiaTriBanDau"
                                            value="{{ number_format($phieuThanhLy->GiaTriBanDau, 0, ',', '.') }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="GiaTriConLai">Giá trị còn lại</label>
                                        <input type="text" class="form-control" id="GiaTriConLai" name="GiaTriConLai"
                                            value="{{ number_format($phieuThanhLy->GiaTriConLai, 0, ',', '.') }}" readonly>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="DanhGia">Đánh giá</label>
                                        <textarea class="form-control" id="DanhGia" name="DanhGia" rows="3"
                                            readonly>{{ $phieuThanhLy->DanhGia }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="GhiChu">Ghi chú</label>
                                        <textarea class="form-control" id="GhiChu" name="GhiChu" rows="2"
                                            readonly>{{ $phieuThanhLy->GhiChu }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <!-- Nút quay lại -->
                            <div class="m-3 d-flex justify-content-between">
                                <a href="{{ route('phieuthanhly.index') }}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> Quay lại
                                </a>
                                @if ($phieuThanhLy->TrangThai == 0)
                                    <div class="d-flex justify-content-end">
                                        <form action="{{ route('phieuthanhly.duyet', $phieuThanhLy->MaPhieuThanhLy) }}" method="POST"
                                            class="d-inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <button type="button" class="btn btn-success" onclick="confirmApprove(this)">
                                                <i class="fa fa-check"></i> Duyệt
                                            </button>
                                        </form>
                                        <form action="{{ route('phieuthanhly.tuchoi', $phieuThanhLy->MaPhieuThanhLy) }}" method="POST"
                                            class="d-inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <button type="button" class="btn btn-danger ms-3" onclick="confirmDelete(this)">
                                                <i class="fa fa-times"></i> Từ Chối
                                            </button>
                                        </form>
                                    </div>
                                @endif
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
        function confirmApprove(button) {
            swal({
                title: 'Xác nhận các thông tin là chính xác',
                text: "Hành động này không thể hoàn tác!",
                icon: 'warning',
                buttons: {
                    confirm: {
                        text: 'Đồng ý',
                        className: 'btn btn-danger'
                    },
                    cancel: {
                        text: 'Hủy',
                        visible: true,
                        className: 'btn btn-success'
                    }
                }
            }).then((willDelete) => {
                if (willDelete) {
                    button.closest('form').submit(); // Gửi form
                } else {
                    swal.close(); // Đóng hộp thoại
                }
            });
        }
        function confirmDelete(button) {
            swal({
                title: 'Bạn có chắc chắn?',
                text: "Hành động này không thể hoàn tác!",
                icon: 'warning',
                buttons: {
                    confirm: {
                        text: 'Xóa',
                        className: 'btn btn-danger'
                    },
                    cancel: {
                        text: 'Hủy',
                        visible: true,
                        className: 'btn btn-success'
                    }
                }
            }).then((willDelete) => {
                if (willDelete) {
                    button.closest('form').submit(); // Gửi form
                } else {
                    swal.close(); // Đóng hộp thoại
                }
            });
        }
    </script>
@endsection