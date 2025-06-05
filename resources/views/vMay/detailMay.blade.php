@extends('layouts.main')

@section('title', 'Thông tin máy')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <div class="mt-3 mx-3 d-flex justify-content-between">
                                <h2 class="ps-3 mb-0">Thông Tin Máy</h2>
                                <div class="d-flex justify-content-end">
                                    @if ($may->TrangThai == 0)
                                        <a href="{{ route('phieuthanhly.create', ['MaMay' => $may->MaMay]) }}"
                                            class="btn btn-black btn-border">
                                            <i class="fas fa-recycle"></i> Thanh lý
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-3 px-5">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th scope="row">Mã Máy</th>
                                        <td>{{ $may->MaMay2 }}</td>
                                        <th scope="row">Nhà Cung Cấp</th>
                                        <td>{{ $may->nhaCungCap->TenNhaCungCap ?? '---' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Tên Máy</th>
                                        <td>{{ $may->TenMay }}</td>
                                        <th scope="row">Đưa Vào Sử Dụng</th>
                                        <td>{{ \Carbon\Carbon::parse($may->ThoiGianDuaVaoSuDung)->format('d/m/Y') }}</td>
                                    </tr>

                                    <tr>
                                        <th scope="row">Loại Máy</th>
                                        <td>{{ $may->loaiMay->TenLoai ?? '---' }}</td>
                                        <th scope="row">Thời Gian Khấu Hao</th>
                                        <td>
                                            {{ $may->ThoiGianKhauHao ?? '---' }} năm
                                            @if ($ngayHetKhauHao && $ngayHetKhauHao < \Carbon\Carbon::now())
                                                <span class="badge badge-danger ms-3">Đã hết khấu hao</span>
                                            @endif
                                        </td>
                                        
                                        
                                    </tr>

                                    <tr>
                                        <th scope="row">Seri Máy</th>
                                        <td>{{ $may->SeriMay }}</td>
                                        <th scope="row">Thời Gian Bảo Hành</th>
                                        <td>{{ $may->ThoiGianBaoHanh ?? '---' }} tháng
                                            @if ($ngayHetBaoHanh && $ngayHetBaoHanh < \Carbon\Carbon::now())
                                                <span class="badge badge-danger ms-3">Đã hết bảo hành</span>
                                            @endif
                                        </td>
                                        
                                    </tr>
                                    <tr>
                                        <th scope="row">Năm Sản Xuất</th>
                                        <td>{{ $may->NamSanXuat }}</td>
                                        <th scope="row">Chu Kỳ Bảo Trì</th>
                                        <td>{{ $may->ChuKyBaoTri }} tháng</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Giá trị ban đầu</th>
                                        <td>{{ number_format($may->GiaTriBanDau, 0, ',', '.') }} VND</td>
                                        <th scope="row">Trạng thái</th>
                                        <td>
                                            @if ($may->TrangThai == 1)
                                                <span class="badge badge-danger">Đã thanh lý</span>
                                            @else
                                                <span class="badge badge-success">Đang sử dụng</span>
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <th scope="row">Chi Tiết Linh Kiện</th>
                                        <td colspan="3">
                                            <a href="{{ $may->ChiTietLinhKien }}" target="_blank">
                                                <i class="fas fa-link"></i> Mở file chi tiết
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                        <div class="card-footer">
                            <!-- Nút quay lại -->
                            <div class="m-3">
                                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> Quay lại
                                </a>
                                <a href="{{ route('may.edit', $may->MaMay) }}" class="btn btn-warning mx-3">
                                    <i class="fa fa-edit"></i> Sửa
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


