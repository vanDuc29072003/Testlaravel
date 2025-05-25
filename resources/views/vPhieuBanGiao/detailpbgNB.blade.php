@extends('layouts.main')

@section('title', 'Chi Tiết Phiếu Bàn Giao Nội Bộ')

@section('content')
    <div class="container">
        <div class="card mb-5 mx-auto mt-5" style="width: 85%;">
            <div class="card-header">
                <div class="mt-3 mx-3 d-flex justify-content-between">
                    <h2 class="ps-3 mb-0">Thông Tin Phiếu Bàn Giao Nội Bộ</h2>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('phieubangiao.exportPDF', $phieuBanGiaoNoiBo->MaPhieuBanGiaoNoiBo) }}"
                            class="btn btn-black btn-border ms-3">
                            <i class="fas fa-file-download"></i> Xuất FILE PDF
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body pt-3 px-5">
                @if ($lichSuaChua->phieuBanGiaoNoiBo && $lichSuaChua->MaLichSuaChua)
                    <div class="card-body pt-3 px-5">
                        <h5 class="fst-italic ms-3">I. Thông tin bàn giao</h5>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Nhân Viên Yêu Cầu</th>
                                    <td>{{ $lichSuaChua->yeuCauSuaChua->nhanVien->TenNhanVien }}</td>
                                    <th>Mã Máy</th>
                                    <td>{{ $lichSuaChua->yeuCauSuaChua->may->MaMay }}</td>
                                </tr>
                                <tr>
                                    <th>Thời Gian Yêu Cầu</th>
                                    <td>{{ \Carbon\Carbon::parse($lichSuaChua->yeuCauSuaChua->ThoiGianYeuCau)->format('H:i d/m/Y') }}
                                    </td>
                                    <th>Tên Máy</th>
                                    <td>{{ $lichSuaChua->yeuCauSuaChua->may->TenMay }}</td>
                                </tr>
                                <tr>
                                    <th>Nhân Viên Đảm Nhận</th>
                                    <td>{{ $phieuBanGiaoNoiBo->lichSuaChua->nhanVienKyThuat->TenNhanVien }}</td>
                                    <th>Seri Máy</th>
                                    <td>{{ $lichSuaChua->yeuCauSuaChua->may->SeriMay }}</td>
                                </tr>
                                <tr>
                                    <th>Thời Gian Bàn Giao</th>
                                    <td>{{ \Carbon\Carbon::parse($lichSuaChua->phieuBanGiaoNoiBo->ThoiGianBanGiao)->format('H:i d/m/Y') }}
                                    </td>
                                    <th>Ngày Nhập</th>
                                    <td>{{ \Carbon\Carbon::parse($lichSuaChua->yeuCauSuaChua->may->ThoiGianDuaVaoSuDung)->format('d/m/Y') }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Người lập phiếu</th>
                                    <td>{{ $lichSuaChua->phieuBanGiaoNoiBo->nhanVienTao->TenNhanVien }}</td>
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

                        <h5 class="fst-italic ms-3">II. Nội dung bàn giao</h5>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Biện Pháp Xử Lý</th>
                                    <td>{{ $lichSuaChua->phieuBanGiaoNoiBo->BienPhapXuLy ?? 'Không có' }}</td>
                                </tr>
                                <tr>
                                    <th>Ghi Chú</th>
                                    <td>{{ $lichSuaChua->phieuBanGiaoNoiBo->GhiChu ?? 'Không có' }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5 class="fst-italic ms-3">III. Danh sách linh kiện</h5>
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
                                            <td>{{ $chiTiet->LinhKienSuaChua->MaLinhKien }}</td>
                                            <td>{{ $chiTiet->LinhKienSuaChua->TenLinhKien }}</td>
                                            <td>{{ $chiTiet->LinhKienSuaChua->donViTinh->TenDonViTinh }}</td>
                                            <td>{{ $chiTiet->SoLuong }}</td>
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