@extends('layouts.main')

@section('title', 'Chi Tiết Phiếu Xuất')

@section('content')
    <div class="container">
        <div class="card mb-5 mx-auto mt-5" style="width: 85%;">
            <div class="card-header">
                <div class="mt-3 mx-3 d-flex justify-content-between">
                    <h2 class="ps-3 mb-0">Thông Tin Phiếu Xuất</h2>
                    <a href="{{ route('phieuxuat.exportPDF', $phieuXuat->MaPhieuXuat) }}"
                        class="btn btn-black btn-border ms-3">
                        <i class="fas fa-file-download"></i> Xuất FILE PDF
                    </a>
                </div>
            </div>
            <div class="card-body pt-3 px-5">
                <h5 class="fst-italic ms-3">Thông tin chung</h5>
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>Mã Phiếu Xuất</th>
                            <td>{{ $phieuXuat->MaHienThi }}</td>
                            <th>Ngày Xuất</th>
                            <td>{{ \Carbon\Carbon::parse($phieuXuat->NgayXuat)->format('H:i d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th>Người Lập Phiếu:</th>
                            <td>{{ $phieuXuat->nhanVienTao->TenNhanVien ?? 'Không xác định' }}</td>
                            <th>Người Nhận:</th>
                            <td>{{ $phieuXuat->nhanVienNhan->TenNhanVien ?? 'Không xác định' }}</td>
                        </tr>
                        <tr>
                            <th>Ghi Chú</th>
                            <td colspan="3">{{ $phieuXuat->GhiChu ?? 'Không có ghi chú' }}</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Danh sách chi tiết phiếu xuất -->
                <h5 class="fst-italic ms-3">Danh sách linh kiện</h5>
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
                        <!-- Dòng tổng số lượng -->
                        <tr>
                            <th colspan="3" class="text-end">Tổng số lượng</th>
                            <td>{{ $phieuXuat->TongSoLuong }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <!-- Nút quay lại -->
                <div class="m-3">
                    <a href="{{ route('dsphieuxuat') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection