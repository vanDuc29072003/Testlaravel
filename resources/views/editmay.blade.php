@extends('layouts.main')

@section('title', 'Chỉnh sửa thông tin máy')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <!-- Cột 1 -->
                    <div class="col-md-6">
                        <h1>Chỉnh sửa thông tin máy</h1>
                    </div>
                    <div class="col-md-6">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('may.edit', $may->MaMay) }}" method="POST">
                    @csrf
                    <div class="row">
                        <!-- Cột 1 -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="TenMay">Tên Máy</label>
                                <input type="text" class="form-control" id="TenMay" name="TenMay"
                                    value="{{ $may->TenMay }}">
                            </div>

                            <div class="form-group">
                                <label for="SeriMay">Seri Máy</label>
                                <input type="text" class="form-control" id="SeriMay" name="SeriMay"
                                    value="{{ $may->SeriMay }}">
                            </div>

                            <div class="form-group">
                                <label for="ChuKyBaoTri">Chu Kỳ Bảo Trì</label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" id="ChuKyBaoTri" name="ChuKyBaoTri"
                                        value="{{ $may->ChuKyBaoTri }}">
                                    <span class="input-group-text">Tháng</span>
                                </div>
                            </div>
                        </div>

                        <!-- Cột 2 -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="NamSanXuat">Năm Sản Xuất</label>
                                <input type="number" class="form-control" id="NamSanXuat" name="NamSanXuat"
                                    value="{{ $may->NamSanXuat }}">
                            </div>

                            <div class="form-group">
                                <label for="HangSanXuat">Hãng Sản Xuất</label>
                                <input type="text" class="form-control" id="HangSanXuat" name="HangSanXuat"
                                    value="{{ $may->HangSanXuat }}">
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Cập nhật
                                </a>
                            </button>
                            <a href="{{ route('may') }}" class="btn btn-secondary text-white">Trở lại</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection