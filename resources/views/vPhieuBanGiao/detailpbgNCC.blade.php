@extends('layouts.main')

@section('title', 'Chi Tiết Phiếu Bàn Giao Nhà Cung Cấp')

@section('content')
    <div class="container">
        <div class="card mb-5 mx-auto mt-5" style="width: 85%;">
            <div class="card-header">
                <div class="mt-3 mx-3 d-flex justify-content-between">
                    <h2 class="ps-3 mb-0">Thông Tin Phiếu Bàn Giao Nhà Cung Cấp</h2>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('phieubangiao.exportPDF1', ['MaPhieuBanGiaoSuaChua' => $lichSuaChua->phieuBanGiaoSuaChuaNCC->MaPhieuBanGiaoSuaChua]) }}"
                            class="btn btn-black btn-border ms-3">
                            <i class="fas fa-file-download"></i> Xuất FILE PDF
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body pt-3 px-5">
                @if ($lichSuaChua->phieuBanGiaoSuaChuaNCC && $lichSuaChua->MaLichSuaChua)
                    <div class="card-body pt-3 px-5">
                        <h5 class="fst-italic ms-3">I. Thông tin bàn giao</h5>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Nhân Viên Yêu Cầu</th>
                                    <td>{{ $lichSuaChua->yeuCauSuaChua->nhanVien->TenNhanVien ?? 'Không xác định' }}</td>
                                    <th>Mã Máy</th>
                                    <td>{{ $lichSuaChua->yeuCauSuaChua->may->MaMay }}</td>
                                </tr>
                                <tr>
                                    <th>Thời Gian Yêu Cầu</th>
                                    <td>{{ \Carbon\Carbon::parse($lichSuaChua->yeuCauSuaChua->ThoiGianYeuCau)->format('H:i d/m/Y') }}</td>
                                    <th>Tên Máy</th>
                                    <td>{{ $lichSuaChua->yeuCauSuaChua->may->TenMay }}</td>
                                </tr>
                                <tr>
                                    <th>Thời Gian Bàn Giao</th>
                                    <td>{{ \Carbon\Carbon::parse($lichSuaChua->phieuBanGiaoSuaChuaNCC->ThoiGianBanGiao)->format('H:i d/m/Y') }}</td>
                                    <th>Seri Máy</th>
                                    <td>{{ $lichSuaChua->yeuCauSuaChua->may->SeriMay }}</td>
                                </tr>
                                <tr>
                                    <th>Người lập phiếu</th>
                                    <td>{{ $lichSuaChua->phieuBanGiaoSuaChuaNCC->nhanVienTao->TenNhanVien }}</td>
                                    <th>Ngày Nhập</th>
                                    <td>{{ \Carbon\Carbon::parse($lichSuaChua->yeuCauSuaChua->may->ThoiGianDuaVaoSuDung)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <td></td>
                                    <th>Thời Gian Bảo Hành</th>
                                    <td>{{ $lichSuaChua->yeuCauSuaChua->may->ThoiGianBaoHanh }} tháng</td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <td></td>
                                    <th>Tình Trạng</th>
                                    <td>{{ $lichSuaChua->yeuCauSuaChua->MoTa }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5 class="fst-italic ms-3">II. Thông tin nhà cung cấp</h5>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Nhà Cung Cấp</th>
                                    <td>{{ $nhaCungCap->TenNhaCungCap }}</td>
                                    <th>Địa Chỉ</th>
                                    <td>{{ $nhaCungCap->DiaChi ?? 'Không có' }}</td>
                                </tr>
                                <tr>
                                    <th>Số Điện Thoại</th>
                                    <td>{{ $nhaCungCap->SDT ?? 'Không có' }}</td>
                                    <th>Email</th>
                                    <td>{{ $nhaCungCap->Email ?? 'Không có' }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5 class="fst-italic ms-3">III. Nội dung bàn giao</h5>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Biện Pháp Xử Lý</th>
                                    <td colspan="3">{{ $lichSuaChua->phieuBanGiaoSuaChuaNCC->BienPhapXuLy ?? 'Không có' }}</td>
                                </tr>
                                <tr>
                                    <th>Ghi Chú</th>
                                    <td colspan="3">{{ $lichSuaChua->phieuBanGiaoSuaChuaNCC->GhiChu ?? 'Không có' }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5 class="fst-italic ms-3">Danh sách công việc và linh kiện sửa chữa</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Tên Công Việc & Linh Kiện Sửa Chữa</th>
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
                                            <td>{{ $chiTiet->TenLinhKien }}</td>
                                            <td>{{ $chiTiet->DonViTinh }}</td>
                                            <td>{{ $chiTiet->SoLuong }}</td>
                                            <td>
                                                <input type="checkbox" {{ $chiTiet->BaoHanh == 1 ? 'checked' : '' }} disabled>
                                            </td>
                                            <td>{{ number_format($chiTiet->GiaThanh, 0, ',', '.') }} VND</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th colspan="4" class="text-end">Tổng tiền</th>
                                        <td>{{ number_format($lichSuaChua->phieuBanGiaoSuaChuaNCC->TongTien, 0, ',', '.') }} VND</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">Không có linh kiện nào được bàn giao.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-warning mt-4">
                        Không có Phiếu Bàn Giao Nhà Cung Cấp cho lịch sửa chữa này.
                    </div>
                @endif
                <div class="card-footer">
                    <div class="m-3 d-flex justify-content-between">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>
            </div>
        </div>
@endsection