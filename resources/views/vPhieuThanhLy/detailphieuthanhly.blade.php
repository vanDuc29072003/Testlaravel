@extends('layouts.main')

@section('title', 'Chi Tiết Phiếu Thanh Lý')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row d-flex justify-content-center">
            <div class="col-xl-9 col-lg-12 col-md-8 col-sm-10">
                <div class="card mx-auto">
                    <div class="card-header">
                        <div class="mt-3 mx-3 d-flex justify-content-between">
                            <h2 class="ps-3 mb-0">Chi Tiết Phiếu Thanh Lý</h2>
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('phieuthanhly.exportPDF', $phieuThanhLy->MaPhieuThanhLy) }}"
                                    class="btn btn-black btn-border ms-3">
                                    <i class="fas fa-file-download"></i> Xuất FILE PDF
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-5">
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label>Ngày lập phiếu</label>
                                <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($phieuThanhLy->NgayLapPhieu)->format('d-m-Y') }}" readonly>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Nhân viên tạo</label>
                                <input type="text" class="form-control" value="{{ $phieuThanhLy->nhanVien->TenNhanVien ?? 'Không xác định' }}" readonly>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Máy</label>
                                <input type="text" class="form-control" value="{{ $phieuThanhLy->may->TenMay }}" readonly>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Số Seri</label>
                                <input type="text" class="form-control" value="{{ $phieuThanhLy->may->SeriMay ?? '' }}" readonly>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Loại Máy</label>
                                <input type="text" class="form-control" value="{{ $phieuThanhLy->may->loaiMay->TenLoai ?? '' }}" readonly>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Nhà Cung Cấp</label>
                                <input type="text" class="form-control" value="{{ $phieuThanhLy->may->nhaCungCap->TenNhaCungCap ?? '' }}" readonly>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Năm Sản Xuất</label>
                                <input type="text" class="form-control" value="{{ $phieuThanhLy->may->NamSanXuat ?? '' }}" readonly>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Thời Gian Đưa Vào Sử Dụng</label>
                                <input type="text" class="form-control" value="{{ $phieuThanhLy->may->ThoiGianDuaVaoSuDung ?? '' }}" readonly>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Thời Gian Bảo Hành</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ $phieuThanhLy->may->ThoiGianBaoHanh ?? '' }}" readonly>
                                    <span class="input-group-text">Tháng</span>
                                </div>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Thời Gian Khấu Hao</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ $phieuThanhLy->may->ThoiGianKhauHao ?? '' }}" readonly>
                                    <span class="input-group-text">Năm</span>
                                </div>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Giá trị ban đầu</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ number_format($phieuThanhLy->GiaTriBanDau, 0, ',', '.') }}" readonly>
                                    <span class="input-group-text">VNĐ</span>
                                </div>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Giá trị còn lại</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ number_format($phieuThanhLy->GiaTriConLai, 0, ',', '.') }}" readonly>
                                    <span class="input-group-text">VNĐ</span>
                                </div>
                            </div>
                            <div class="form-group col-12">
                                <label>Đánh giá</label>
                                <textarea class="form-control" rows="3" readonly>{{ $phieuThanhLy->DanhGia }}</textarea>
                            </div>
                            <div class="form-group col-12">
                                <label>Ghi chú</label>
                                <textarea class="form-control" rows="2" readonly>{{ $phieuThanhLy->GhiChu }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between m-3">
                            <a href="{{ route('phieuthanhly.index') }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> Quay lại
                            </a>
                            @if ($phieuThanhLy->TrangThai == 0)
                                <div class="d-flex justify-content-end">
                                    <form action="{{ route('phieuthanhly.duyet', $phieuThanhLy->MaPhieuThanhLy) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <button type="button" class="btn btn-success" onclick="confirmApprove(this)">
                                            <i class="fa fa-check"></i> Duyệt
                                        </button>
                                    </form>
                                    <form action="{{ route('phieuthanhly.tuchoi', $phieuThanhLy->MaPhieuThanhLy) }}" method="POST" class="d-inline-block">
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