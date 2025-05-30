@extends('layouts.main')

@section('title', 'Thêm Đơn vị tính')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="mt-3 mx-3">Thêm Đơn vị tính</h1>
                        </div>
                        <div class="card-body">
                            <form id="formDonViTinh" action="{{ route('donvitinh.storeDVTfromLinhKien') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="TenDonViTinh" class="form-label">Tên Đơn vị tính</label>
                                    <input type="text" name="TenDonViTinh" class="form-control"
                                        value="{{ old('TenDonViTinh') }}" placeholder="Nhập tên đơn vị tính" required>
                                    @error('TenDonViTinh')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                            </form>
                        </div>
                        <div class="card-footer">
                            <div class="form-group d-flex justify-content-between">
                                <a href="{{ route('linhkien.add') }}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> Quay lại</a>
                                <button type="submit" class="btn btn-primary" form="formDonViTinh">
                                    <i class="fa fa-save"></i> Lưu
                                </button>
                            </div>
                        </div>
                    </div>
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
                    enter: 'animated fadeInDown'
                    , exit: 'animated fadeOutUp'
                },
            });
        @endif
    </script>
@endsection