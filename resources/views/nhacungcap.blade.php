@extends('layouts.main')

@section('title', 'Danh sách Nhà Cung Cấp')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="table-responsive">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h1 class="mb-0">Danh sách Nhà Cung Cấp</h1>

                    <a href="{{ route('nhacungcap.add') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i> Thêm mới
                    </a>
                </div>
                <table class="table table-responsive table-bordered table-hover">
                    <thead>
                        <tr class="text-center">
                            <th scope="col">Mã Nhà Cung Cấp</th>
                            <th scope="col">Tên Nhà Cung Cấp</th>
                           
                            <th scope="col">Số Điện Thoại</th>
                           
                            <th scope="col">Cập Nhật</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dsNhaCungCap as $ncc)
                            <tr class="text-center" onclick="window.location='{{ route('nhacungcap.detail', $ncc->MaNhaCungCap) }}'"
                                style="cursor: pointer;">
                                <td>{{ $ncc->MaNhaCungCap }}</td>
                                <td>{{ $ncc->TenNhaCungCap }}</td>
                              
                                <td>{{ $ncc->SDT }}</td>
                               
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('nhacungcap.edit', $ncc->MaNhaCungCap) }}"
                                            class="btn btn-warning btn-sm text-black">
                                            <i class="fa fa-edit"></i> Sửa
                                        </a>
                                        <form action="{{ route('nhacungcap.delete', $ncc->MaNhaCungCap) }}" method="POST"
                                            class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="event.stopPropagation(); confirmDelete(this)">
                                                <i class="fa fa-trash"></i> Xóa
                                            </button>
                                        </form>
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
