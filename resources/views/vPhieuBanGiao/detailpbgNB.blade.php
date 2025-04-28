@extends('layouts.main')

@section('title', 'Chi Tiết Phiếu Bàn Giao Nội Bộ')

@section('content')
    <div class="container">
        <div class="card mb-5 mx-auto mt-5" style="width: 85%;">
            <div class="card-header">
                <div class="mt-3 mx-3 d-flex justify-content-between">
                    <h2 class="ps-3 mb-0">Thông Tin Phiếu Bàn Giao Nội Bộ</h2>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('phieubangiao.exportPDF', $phieuBanGiaoNoiBo->MaPhieuBanGiaoNoiBo) }}" class="btn btn-black btn-border ms-3">
                            <i class="fas fa-file-download"></i> Xuất FILE PDF
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body pt-3 px-5">
                @if ($lichSuaChua->phieuBanGiaoNoiBo &&  $lichSuaChua->MaLichSuaChua) 

                <p><strong>Mã Yêu Cầu Sửa Chữa:</strong> {{ $lichSuaChua->yeuCauSuaChua->MaYeuCauSuaChua }}</p>
                <p><strong>Mã Lịch Sửa Chữa:</strong> {{ $lichSuaChua->MaLichSuaChua }}</p>
                <p><strong>Mã Phiếu Bàn Giao:</strong> {{ $lichSuaChua->phieuBanGiaoNoiBo->MaPhieuBanGiaoNoiBo }}</p>
                <p><strong>Máy cần sửa chữa:</strong> {{ $lichSuaChua->yeuCauSuaChua->may->TenMay }}</p>
                <p><strong>Thời Gian Yêu Cầu:</strong> {{ \Carbon\Carbon::parse($lichSuaChua->yeuCauSuaChua->ThoiGianYeuCau)->format('H:i d/m/Y') }}</p>
                <p><strong>Thời Gian Bàn Giao:</strong> {{ \Carbon\Carbon::parse($lichSuaChua->phieuBanGiaoNoiBo->ThoiGianBanGiao)->format('H:i d/m/Y') }}</p>
                <p><strong>Nhân Viên Yêu Cầu:</strong> {{ $lichSuaChua->yeuCauSuaChua->nhanVien->TenNhanVien }}</p>
                <p><strong>Nhân Viên Kỹ Thuật:</strong> {{ $lichSuaChua->nhanVienKyThuat->TenNhanVien }}</p>
                <p><strong>Biện Pháp Xử Lý:</strong> {{ $lichSuaChua->phieuBanGiaoNoiBo->BienPhapXuLy ?? 'Không có' }}</p>
                <p><strong>Ghi Chú:</strong> {{ $lichSuaChua->phieuBanGiaoNoiBo->GhiChu ?? 'Không có' }}</p>

             
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Thông Tin Linh Kiện Sửa Chữa</h5>
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
                                @if ($phieuBanGiaoNoiBo && $phieuBanGiaoNoiBo->chiTietPhieuBanGiaoNoiBo->count())
                                @foreach ($phieuBanGiaoNoiBo->chiTietPhieuBanGiaoNoiBo as $chiTiet)
                                    <tr>
                                        <td>{{ $chiTiet->LinhKienSuaChua->MaLinhKien  }}</td>
                                        <td>{{ $chiTiet->LinhKienSuaChua->TenLinhKien  }}</td>
                                        <td>{{ $chiTiet->LinhKienSuaChua->donViTinh->TenDonViTinh }}</td>
                                        <td>{{ $chiTiet->SoLuong }}</td>
                                    </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                
                @else
                    <div class="alert alert-warning mt-4">
                        Không có Phiếu Bàn Giao Nội Bộ cho lịch sửa chữa này.
                    </div>
                @endif
            </div>
            <div class="card-footer">
                <!-- Nút quay lại -->
                <div class="m-3 d-flex justify-content-between">
                    <a href="{{ route('lichsuachua.dahoanthanh') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
