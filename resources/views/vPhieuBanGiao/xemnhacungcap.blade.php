@extends('layouts.main')

@section('title', 'Chi Tiết Nhà Cung Cấp')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="card w-50 mx-auto">
                <div class="card-header">
                    <h1 class="m-3">Thông Tin Nhà Cung Cấp</h1>
                </div>
                <div class="card-body p-5">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th scope="row">Mã Nhà Cung Cấp</th>
                                <td>{{ $nhaCungCap->MaNhaCungCap }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Tên Nhà Cung Cấp</th>
                                <td>{{ $nhaCungCap->TenNhaCungCap }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Địa Chỉ</th>
                                <td>{{ $nhaCungCap->DiaChi }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Số Điện Thoại</th>
                                <td>{{ $nhaCungCap->SDT}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Email</th>
                                <td>{{ $nhaCungCap->Email }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Ghi Chú</th>
                                <td>{{ $nhaCungCap->GhiChu ?? 'Không có' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <!-- Nút quay lại -->
                    <div class="m-3">
                        <a href="{{ route('lichsuachua.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                
                    <!-- Nút tạo phiếu bàn giao -->
                    <div class="m-3">
                        <a href="{{ route('lichsuachua.bangiaonhacungcap', $lichSuaChua->MaLichSuaChua) }}" class="btn btn-success">
                            <i class="fa fa-save"></i> Tạo Phiếu Bàn Giao
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection