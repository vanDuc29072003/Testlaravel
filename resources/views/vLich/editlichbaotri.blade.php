@extends('layouts.main')

@section('title', 'Chỉnh Sửa Lịch Bảo Trì')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-md-8 col-sm-12">
                    <div class="card mx-auto">
                        <div class="card-header">
                            <h1 class="mt-3 mx-3">Chỉnh Sửa Lịch Bảo Trì</h1>
                        </div>
                        <div class="card-body">
                            <form id="formLichBaoTri" action="{{ route('lichbaotri.update', $lich->MaLichBaoTri) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                {{-- Ngày bảo trì --}}
                                <div class="form-group">
                                    <label for="NgayBaoTri">Ngày bảo trì</label>
                                    <input type="date" id="NgayBaoTri" name="NgayBaoTri" class="form-control"
                                        value="{{ \Carbon\Carbon::parse($lich->NgayBaoTri)->format('Y-m-d') }}" required>
                                </div>

                                {{-- Tên máy --}}
                                <div class="form-group">
                                    <label for="TenMay">Tên máy</label>
                                    <input type="text" id="TenMay" class="form-control"
                                        value="{{ $lich->may->TenMay ?? 'Không xác định' }}" readonly>
                                </div>

                                {{-- Mô tả --}}
                                <div class="form-group">
                                    <label for="MoTa">Mô tả</label>
                                    <textarea id="MoTa" class="form-control" rows="3" readonly>{{ $lich->MoTa }}</textarea>
                                </div>

                                {{-- Nhà cung cấp --}}
                                <div class="form-group">
                                    <label for="NhaCungCap">Nhà cung cấp</label>
                                    <input type="text" id="NhaCungCap" class="form-control"
                                        value="{{ $lich->may->nhaCungCap->TenNhaCungCap ?? 'Không xác định' }}" readonly>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer">
                            <div class="form-group d-flex justify-content-between">
                                <a href="{{ route('lichbaotri') }}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> Trở lại
                                </a>
                                <button type="submit" class="btn btn-primary" form="formLichBaoTri">
                                    <i class="fa fa-save"></i> Lưu Thay Đổi
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
