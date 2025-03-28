@extends('layouts.main')

@section('title', 'Danh sách Máy')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="table-responsive">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="mb-0">Danh sách máy</h1>
                <button class="btn btn-primary">
                    <a href="{{ route('add.may') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i> Thêm mới
                    </a>
                </button>
            </div>
            <table class="table table-bordered">
                <thead style="background-color: pink; color: black;">
                    <tr>
                        <th>Mã Máy</th>
                        <th>Tên Máy</th>
                        <th>Seri Máy</th>
                        <th>Chu Kì Bảo Trì (Tháng)</th>
                        <th>Năm Sản Xuất</th>
                        <th>Hãng Sản Xuất</th>
                        <th>Cập Nhật</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dsMay as $may)
                        <tr>
                            <td>{{ $may->MaMay }}</td>
                            <td>{{ $may->TenMay }}</td>
                            <td>{{ $may->SeriMay }}</td>
                            <td>{{ $may->ChuKyBaoTri }}</td>
                            <td>{{ $may->NamSanXuat }}</td>
                            <td>{{ $may->HangSanXuat }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i> Sửa
                                    </button>
                                    <button class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i> Xóa
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection