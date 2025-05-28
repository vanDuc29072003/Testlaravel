@extends('layouts.main')

@section('title', 'Chi Tiết Phiếu Bàn Giao Bảo Trì')

@section('content')
    <div class="container">
        <div class="card mb-5 mx-auto mt-5" style="width: 85%;">
            <div class="card-header">
                <div class="mt-3 mx-3 d-flex justify-content-between">
                    <h2 class="ps-3 mb-0">Thông Tin Phiếu Bàn Giao Bảo Trì</h2>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('phieubangiaobaotri.exportPDF', ['MaPhieuBanGiaoBaoTri' => $lichBaoTri->phieuBanGiaoBaoTri->MaPhieuBanGiaoBaoTri]) }}"
                            class="btn btn-black btn-border ms-3">
                            <i class="fas fa-file-download"></i> Xuất FILE PDF
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body pt-3 px-5">
                @if ($lichBaoTri->phieuBanGiaoBaoTri && $lichBaoTri->MaLichBaoTri)
                    <div class="card-body pt-3 px-5">
                        <h5 class="fst-italic ms-3">I. Thông tin bàn giao</h5>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Mã Lịch Bảo Trì</th>
                                    <td>{{ $lichBaoTri->MaLichBaoTri }}</td>
                                    <th>Mã Máy</th>
                                    <td>{{ $lichBaoTri->may->MaMay }}</td>
                                </tr>
                                <tr>
                                    <th>Ngày Bảo Trì</th>
                                    <td>{{ \Carbon\Carbon::parse($lichBaoTri->NgayBaoTri)->format('H:i d/m/Y') }}</td>
                                    <th>Tên Máy</th>
                                    <td>{{ $lichBaoTri->may->TenMay }}</td>
                                </tr>
                                <tr>
                                    <th>Nội Dung Bảo Trì</th>
                                    <td>{{ $lichBaoTri->MoTa ?? 'Không có' }}</td>
                                    <th>Seri Máy</th>
                                    <td>{{ $lichBaoTri->may->SeriMay }}</td>
                                </tr>
                                <tr>
                                    <th>Trạng Thái</th>
                                    <td>
                                        @if ($lichBaoTri->TrangThai == 1)
                                            <span class="badge bg-success">Đã bàn giao</span>
                                        @else
                                            <span class="badge bg-danger">Chờ bàn giao</span>
                                        @endif
                                    </td>
                                    <th>Ngày Nhập</th>
                                    <td>{{ \Carbon\Carbon::parse($lichBaoTri->may->ThoiGianDuaVaoSuDung)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Người Lập</th>
                                    <td>{{ $lichBaoTri->phieuBanGiaoBaoTri->nhanVien->TenNhanVien ?? 'Không xác định' }}</td>
                                    <th>Thời Gian Bảo Hành</th>
                                    <td>{{ $lichBaoTri->may->ThoiGianBaoHanh }} tháng</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5 class="fst-italic ms-3">II. Thông tin nhà cung cấp</h5>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Nhà Cung Cấp</th>
                                    <td>{{ $lichBaoTri->may->nhaCungCap->TenNhaCungCap ?? 'Không có' }}</td>
                                    <th>Địa Chỉ</th>
                                    <td>{{ $lichBaoTri->may->nhaCungCap->DiaChi ?? 'Không có' }}</td>
                                </tr>
                                <tr>
                                    <th>Số Điện Thoại</th>
                                    <td>{{ $lichBaoTri->may->nhaCungCap->SoDienThoai ?? 'Không có' }}</td>
                                    <th>Email</th>
                                    <td>{{ $lichBaoTri->may->nhaCungCap->Email ?? 'Không có' }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5 class="fst-italic ms-3">III. Nội dung bàn giao</h5>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Ghi Chú</th>
                                    <td colspan="3">{{ $lichBaoTri->phieuBanGiaoBaoTri->LuuY ?? 'Không có' }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5 class="fst-italic ms-3">IV. Danh sách linh kiện</h5>
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
                                            <td>{{ number_format($chiTiet->GiaThanh, 0, ',', '.') }} VNĐ</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th colspan="4" class="text-end">Tổng tiền</th>
                                        <td>{{ number_format($lichBaoTri->phieuBanGiaoBaoTri->TongTien, 0, ',', '.') }} VNĐ</td>
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
                        Không có Phiếu Bàn Giao Bảo Trì cho lịch bảo trì này.
                    </div>
                @endif
            </div>

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