@extends('layouts.main')

@section('title', 'Chi Tiết Phiếu Bàn Giao Nhà Cung Cấp')

@section('content')
    <div class="container">
        <div class="card mb-5 mx-auto mt-5" style="width: 85%;">
            <div class="card-header">
                <div class="mt-3 mx-3 d-flex justify-content-between">
                    <h2 class="ps-3 mb-0">Thông Tin Phiếu Bàn Giao Nhà Cung Cấp</h2>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('phieubangiao.exportPDF1', ['MaPhieuBanGiaoSuaChua' => $lichSuaChua->phieuBanGiaoSuaChuaNCC->MaPhieuBanGiaoSuaChua]) }}" class="btn btn-black btn-border ms-3">
                            <i class="fas fa-file-download"></i> Xuất FILE PDF
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body pt-3 px-5">
                @if ($lichSuaChua->phieuBanGiaoSuaChuaNCC && $lichSuaChua->MaLichSuaChua)
                    <p><strong>Mã Yêu Cầu Sửa Chữa:</strong> {{ $lichSuaChua->yeuCauSuaChua->MaYeuCauSuaChua }}</p>
                    <p><strong>Mã Lịch Sửa Chữa:</strong> {{ $lichSuaChua->MaLichSuaChua }}</p>
                    <p><strong>Mã Phiếu Bàn Giao:</strong> {{ $lichSuaChua->phieuBanGiaoSuaChuaNCC->MaPhieuBanGiaoSuaChua }}</p>
                    <p><strong>Thời Gian Yêu Cầu:</strong> {{ \Carbon\Carbon::parse($lichSuaChua->yeuCauSuaChua->ThoiGianYeuCau)->format('H:i d/m/Y') }}</p>
                    <p><strong>Thời Gian Bàn Giao:<strong>: {{ \Carbon\Carbon::parse($lichSuaChua->phieuBanGiaoSuaChuaNCC->ThoiGianBanGiao)->format('H:i d/m/Y') }}</p>
                    <p><strong>Nhân Viên Yêu Cầu:</strong> {{ $lichSuaChua->yeuCauSuaChua->nhanVien->TenNhanVien }}</p>
                    <p><strong>Nhân Viên Kỹ Thuật:</strong> {{ $lichSuaChua->nhanVienKyThuat->TenNhanVien }}</p>
                    <p><strong>Máy cần sửa chữa:</strong> {{ $lichSuaChua->yeuCauSuaChua->may->TenMay }}</p>
                    <p><strong>Nhà Cung Cấp:</strong> {{ $nhaCungCap->TenNhaCungCap }}</p>
                    <p><strong>Địa Chỉ Nhà Cung Cấp:</strong> {{ $nhaCungCap->DiaChi ?? 'Không có' }}</p>
                    <p><strong>Số Điện Thoại:</strong> {{ $nhaCungCap->SoDienThoai ?? 'Không có' }}</p>
                    <p><strong>Email:</strong> {{ $nhaCungCap->Email ?? 'Không có' }}</p>
                    <p><strong>Biện Pháp Xử Lý:</strong> {{ $lichSuaChua->phieuBanGiaoSuaChuaNCC->BienPhapXuLy ?? 'Không có' }}</p>
                    <p><strong>Ghi Chú:</strong> {{ $lichSuaChua->phieuBanGiaoSuaChuaNCC->GhiChu ?? 'Không có' }}</p>

                    <div class="card mt-4">
                        <div class="card-body">
                            <h5 class="card-title">Thông Tin Linh Kiện Bàn Giao</h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Tên Linh Kiện</th>
                                        <th>Đơn Vị Tính</th>
                                        <th>Số Lượng</th>
                                        <th>Bảo Hành</th>
                                        <th>Giá Thành</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($lichSuaChua->phieuBanGiaoSuaChuaNCC->chiTietPhieuBanGiaoSuaChuaNCC->count())
                                        @foreach ($lichSuaChua->phieuBanGiaoSuaChuaNCC->chiTietPhieuBanGiaoSuaChuaNCC as $chiTiet)
                                            <tr>
                                           
                                                <td>{{ $chiTiet->TenLinhKien}}</td>
                                                <td>{{ $chiTiet->DonViTinh }}</td>
                                                <td>{{ $chiTiet->SoLuong }}</td>
                                                <td>
                                                    <input type="checkbox" {{ $chiTiet->BaoHanh == 1 ? 'checked' : '' }} disabled>
                                                </td>
                                                <td>{{ $chiTiet->GiaThanh }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center">Không có linh kiện nào được bàn giao.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <p><strong>Tổng tiền phải thanh toán :</strong> {{ $lichSuaChua->phieuBanGiaoSuaChuaNCC->TongTien ?? 'Không có' }}</p>
                @else
                    <div class="alert alert-warning mt-4">
                        Không có Phiếu Bàn Giao Nhà Cung Cấp cho lịch sửa chữa này.
                    </div>
                @endif
            </div>

            <div class="card-footer">
                <div class="m-3 d-flex justify-content-between">
                    <a href="{{ route('lichsuachua.dahoanthanh') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
