@extends('layouts.main')

@section('title', 'Chi Tiết Phiếu Bàn Giao Bảo Trì')

@section('content')
    <div class="container">
        <div class="card mb-5 mx-auto mt-5" style="width: 85%;">
            <div class="card-header">
                <div class="mt-3 mx-3 d-flex justify-content-between">
                    <h2 class="ps-3 mb-0">Thông Tin Phiếu Bàn Giao Bảo Trì</h2>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('phieubangiaobaotri.exportPDF', ['MaPhieuBanGiaoBaoTri' => $lichBaoTri->phieuBanGiaoBaoTri->MaPhieuBanGiaoBaoTri]) }}" class="btn btn-black btn-border ms-3">
                            <i class="fas fa-file-download"></i> Xuất FILE PDF
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body pt-3 px-5">
                @if ($lichBaoTri->phieuBanGiaoBaoTri && $lichBaoTri->MaLichBaoTri)
                    <p><strong>Mã Lịch Bảo Trì:</strong> {{ $lichBaoTri->MaLichBaoTri }}</p>
                    <p><strong>Mã Phiếu Bàn Giao:</strong> {{ $lichBaoTri->phieuBanGiaoBaoTri->MaPhieuBanGiaoBaoTri }}</p>
                    <p><strong>Ngày Bảo Trì:</strong> {{ \Carbon\Carbon::parse($lichBaoTri->NgayBaoTri)->format('H:i d/m/Y') }}</p>
                    <p><strong>Thời Gian Bàn Giao:</strong> {{ \Carbon\Carbon::parse($lichBaoTri->phieuBanGiaoBaoTri->ThoiGianBanGiao)->format('H:i d/m/Y') }}</p>
                    <p><strong>Máy:</strong> {{ $lichBaoTri->may->TenMay }}</p>
                    <p><strong>Nhà Cung Cấp:</strong> {{ $lichBaoTri->may->nhaCungCap->TenNhaCungCap ?? 'Không có' }}</p>
                    <p><strong>Địa Chỉ Nhà Cung Cấp:</strong> {{ $lichBaoTri->may->nhaCungCap->DiaChi ?? 'Không có' }}</p>
                    <p><strong>Số Điện Thoại:</strong> {{ $lichBaoTri->may->nhaCungCap->SoDienThoai ?? 'Không có' }}</p>
                    <p><strong>Email:</strong> {{ $lichBaoTri->may->nhaCungCap->Email ?? 'Không có' }}</p>
                    <p><strong>Nhân Viên Xác Nhận:</strong> {{ $lichBaoTri->phieuBanGiaoBaoTri->nhanVien->TenNhanVien ?? 'Không có' }}</p>
                    <p><strong>Ghi Chú:</strong> {{ $lichBaoTri->phieuBanGiaoBaoTri->GhiChu ?? 'Không có' }}</p>

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
                                    @if ($lichBaoTri->phieuBanGiaoBaoTri->chiTietPhieuBanGiaoBaoTri->count())
                                        @foreach ($lichBaoTri->phieuBanGiaoBaoTri->chiTietPhieuBanGiaoBaoTri as $chiTiet)
                                            <tr>
                                                <td>{{ $chiTiet->TenLinhKien }}</td>
                                                <td>{{ $chiTiet->DonViTinh }}</td>
                                                <td>{{ $chiTiet->SoLuong }}</td>
                                                <td>
                                                    <input type="checkbox" {{ $chiTiet->BaoHanh == 1 ? 'checked' : '' }} disabled>
                                                </td>
                                                <td>{{ number_format($chiTiet->GiaThanh, 0, ',', '.') }} đ</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center">Không có linh kiện nào được bàn giao.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <p><strong>Tổng tiền phải thanh toán:</strong> {{ number_format($lichBaoTri->phieuBanGiaoBaoTri->TongTien, 0, ',', '.') ?? 'Không có' }} đ</p>
                @else
                    <div class="alert alert-warning mt-4">
                        Không có Phiếu Bàn Giao Bảo Trì cho lịch bảo trì này.
                    </div>
                @endif
            </div>

            <div class="card-footer">
                <div class="m-3 d-flex justify-content-between">
                    <a href="{{ route('lichbaotri.dabangiao') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
