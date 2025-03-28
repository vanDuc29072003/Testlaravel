{{-- filepath: c:\xampp\htdocs\DoAn\resources\views\addmay.blade.php --}}
@extends('layouts.main')

@section('title', 'Thêm Máy Mới')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="card">
            <div class="card-header">
                <h1>Thêm Máy Mới</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('may.store') }}" method="POST">
                    @csrf <!-- Bảo vệ form với CSRF token -->
                    <div class="row">
                        <!-- Cột 1 -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="TenMay">Tên Máy</label>
                                <input type="text" class="form-control" id="TenMay" name="TenMay" placeholder="Nhập tên máy" required>
                            </div>

                            <div class="form-group">
                                <label for="SeriMay">Seri Máy</label>
                                <input type="text" class="form-control" id="SeriMay" name="SeriMay" placeholder="Nhập seri máy" required>
                            </div>

                            <div class="form-group">
                                <label for="ChuKyBaoTri">Chu Kỳ Bảo Trì</label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" id="ChuKyBaoTri" name="ChuKyBaoTri" placeholder="Nhập chu kỳ bảo trì" required>
                                    <span class="input-group-text">Tháng</span>
                                </div>
                            </div>
                        </div>

                        <!-- Cột 2 -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="NamSanXuat">Năm Sản Xuất</label>
                                <input type="number" class="form-control" id="NamSanXuat" name="NamSanXuat" placeholder="Nhập năm sản xuất" required>
                            </div>

                            <div class="form-group">
                                <label for="HangSanXuat">Hãng Sản Xuất</label>
                                <input type="text" class="form-control" id="HangSanXuat" name="HangSanXuat" placeholder="Nhập hãng sản xuất" required>
                            </div>
                        </div>
                    </div> <!-- End Row -->

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Tạo Mới
                        </button>
                        <a href="{{ route('may') }}" class="btn btn-secondary">Trở lại</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    @if (session('error'))
        $.notify({
            title: 'Lỗi',
            message: '{{ session('error') }}',
            icon: 'icon-bell'
        }, {
            type: 'danger',
            animate: {
                enter: 'animated shake',
                exit: 'animated fadeOutUp'
            },
        });
    @endif
</script>
@endsection