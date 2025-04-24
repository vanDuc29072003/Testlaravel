@extends('layouts.main')

@section('title', 'Chi Tiết Phiếu Nhập')

@section('content')
    <div class="container">
        <div class="card mb-5 mx-auto mt-5" style="width: 85%;">
            <div class="card-body">
                <h5 class="card-title">Thông Tin Phiếu Nhập</h5>
                <p><strong>Mã Phiếu Nhập:</strong> {{ $phieuNhap->MaPhieuNhap }}</p>
                <p><strong>Nhà Cung Cấp:</strong> {{ $phieuNhap->nhaCungCap->TenNhaCungCap }}</p>
                <p><strong>Nhân Viên Nhập (Bộ phận: Kho) :</strong> {{ $phieuNhap->nhanVien->TenNhanVien }}</p>
                <p><strong>Số Lượng:</strong> {{ $phieuNhap->TongSoLuong}}</p>
                <p><strong>Ngày Nhập:</strong> {{ $phieuNhap->NgayNhap }}</p>

                <!-- Danh sách chi tiết phiếu nhập -->
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Danh Sách Linh Kiện</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Mã Linh Kiện</th>
                                    <th>Tên Linh Kiện</th>
                                    <th>Số Lượng</th>
                                    <th>Giá Nhập</th>
                                    <th>Thành Tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($phieuNhap->chiTietPhieuNhap as $chiTiet)
                                    <tr>
                                        <td>{{ $chiTiet->linhKien->MaLinhKien }}</td>
                                        <td>{{ $chiTiet->linhKien->TenLinhKien }}</td>
                                        <td>{{ $chiTiet->linhKien->donViTinh->TenDonViTinh }}</td>                                        <td>{{ $chiTiet->SoLuong }}</td>
                                        <td>{{ number_format($chiTiet->GiaNhap, 0, ',', '.') }} VND</td>
                                        <td>{{ number_format($chiTiet->TongCong, 0, ',', '.') }} VND</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <p><strong>Tổng Tiền:</strong> {{ number_format($phieuNhap->TongTien, 0, ',', '.') }} VND</p>
                <p><strong>Ghi Chú:</strong> {{ $phieuNhap->GhiChu }}</p>
                <p><strong>Trạng Thái:</strong>
                    @if ($phieuNhap->TrangThai == 0)
                        <span class="badge bg-warning text-dark">Chờ duyệt</span>
                    @elseif ($phieuNhap->TrangThai == 1)
                        <span class="badge bg-success text-white">Đã nhập kho</span>
                    @endif
                </p>
            </div>
            <div class="card-footer">
                <!-- Nút quay lại -->
                <div class="m-3">
                    <a href="{{ route('dsphieunhap') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Quay lại
                    </a>
                    <a href="{{ route('dsphieunhap.edit', $phieuNhap->MaPhieuNhap) }}" class="btn btn-warning text-black">
                        <i class="fa fa-edit"></i> Sửa
                    </a>
                    <a href="{{ route('phieunhap.exportPDF', $phieuNhap->MaPhieuNhap) }}" class="btn btn-secondary">
                        <i class="fas fa-file-alt"></i> Xuất FILE PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection