@extends('layouts.main')

@section('title', 'Chi Tiết Phiếu Xuất')

@section('content')
    <div class="container">
        <div class="card mb-5 mx-auto mt-5" style="width: 85%;">
            <div class="card-body">
                <h5 class="card-title">Thông Tin Phiếu Xuất</h5>
                <p><strong>Mã Phiếu Xuất:</strong> {{ $phieuXuat->MaPhieuXuat }}</p>
                <p><strong>Nhân Viên Tạo (Bộ phận: Kho):</strong> {{ $phieuXuat->nhanVienTao->TenNhanVien ?? 'Không xác định' }}</p>
                <p><strong>Nhân Viên Nhận (Bộ phận: Kĩ Thuật):</strong> {{ $phieuXuat->nhanVienNhan->TenNhanVien ?? 'Không xác định' }}</p>
                <p><strong>Tổng Số Lượng Xuất:</strong> {{ $phieuXuat->TongSoLuong }}</p>
                <p><strong>Ngày Xuất:</strong> {{ \Carbon\Carbon::parse($phieuXuat->NgayXuat)->format('d/m/Y H:i:s') }}</p>
                <!-- Danh sách chi tiết phiếu xuất -->
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
                                @foreach ($phieuXuat->chiTietPhieuXuat as $chiTiet)
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

                <p><strong>Ghi Chú:</strong> {{ $phieuXuat->GhiChu ?? 'Không có ghi chú' }}</p>
            </div>
            <div class="card-footer">
                <!-- Nút quay lại -->
                <div class="m-3">
                    <a href="{{ route('dsphieuxuat') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Quay lại
                    </a>
                    <a href="{{ route('phieuxuat.exportPDF', $phieuXuat->MaPhieuXuat) }}" class="btn btn-secondary">
                        <i class="fas fa-file-alt"></i> Xuất FILE PDF
                    </a>
                    
                </div>
            </div>
        </div>
    </div>
@endsection