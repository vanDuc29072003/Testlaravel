@extends('layouts.main')

@section('title', 'Chi Tiết Phiếu Trả')

@section('content')
    <div class="container">
        <div class="card mb-5 mx-auto mt-5" style="width: 85%;">
            <div class="card-body">
                <h5 class="card-title">Thông Tin Phiếu Trả</h5>
                <p><strong>Mã Phiếu Trả:</strong> {{ $phieuTra->MaPhieuTra }}</p>
                <p><strong>Nhân Viên Tạo (Bộ phận: Kho) :</strong> {{ $phieuTra->nhanVienTao->TenNhanVien ?? 'Không xác định' }} 
                <p><strong>Nhân Viên Trả (Bộ phận: Kĩ Thuật) :</strong> {{ $phieuTra->nhanVienTra->TenNhanVien ?? 'Không xác định' }} 
                <p><strong>Tổng Số Lượng Trả:</strong> {{ $phieuTra->TongSoLuong }}</p>
                <p><strong>Ngày Trả:</strong> {{ \Carbon\Carbon::parse($phieuTra->NgayTra)->format('d/m/Y H:i:s') }}</p>
                <!-- Danh sách chi tiết phiếu trả -->
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Danh Sách Linh Kiện</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Mã Linh Kiện</th>
                                    <th>Tên Linh Kiện</th>
                                    <th>Đơn Vị Tính</th>
                                    <th>Số Lượng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($phieuTra->chiTietPhieuTra as $chiTiet)
                                    <tr>
                                        <td>{{ $chiTiet->linhKien->MaLinhKien }}</td>
                                        <td>{{ $chiTiet->linhKien->TenLinhKien }}</td>
                                        <td>{{ $chiTiet->linhKien->donViTinh->TenDonViTinh ?? 'Không xác định' }}</td>
                                        <td>{{ $chiTiet->SoLuong }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <p><strong>Ghi Chú:</strong> {{ $phieuTra->GhiChu ?? 'Không có ghi chú' }}</p>
            </div>
            <div class="card-footer">
                <!-- Nút quay lại -->
                <div class="m-3">
                    <a href="{{ route('dsphieutra') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Quay lại
                    </a>
                    <a href="{{ route('phieutra.exportPDF', $phieuTra->MaPhieuTra) }}" class="btn btn-secondary">
                        <i class="fas fa-file-alt"></i> Xuất FILE PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection