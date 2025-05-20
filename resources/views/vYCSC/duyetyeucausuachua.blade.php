@extends('layouts.main')

@section('title', 'Duyệt Yêu Cầu Sửa Chữa')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-md-8 col-sm-12">
                    <div class="card mx-auto">
                        <div class="card-header">
                            <h3>Duyệt Yêu Cầu Sửa Chữa</h3>
                        </div>
                        <div class="card-body">
                            <form id="formDuyetYCSC"
                                action="{{ route('yeucausuachua.duyet', $yeuCauSuaChua->MaYeuCauSuaChua) }}" method="POST">
                                @csrf
                                @method('POST')
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="MaYeuCauSuaChua">Mã Yêu Cầu</label>
                                            <input type="text" class="form-control" id="MaYeuCauSuaChua"
                                                name="MaYeuCauSuaChua" value="{{ $yeuCauSuaChua->MaYeuCauSuaChua }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="ThoiGianYeuCau">Thời Gian Yêu Cầu</label>
                                            <input type="text" class="form-control" id="ThoiGianYeuCau"
                                                name="ThoiGianYeuCau" value="{{ $yeuCauSuaChua->ThoiGianYeuCau }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="TenNhanVien">Nhân Viên</label>
                                            <input type="text" class="form-control" id="TenNhanVien" name="TenNhanVien"
                                                value="{{ $yeuCauSuaChua->nhanVien->TenNhanVien }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="MaNhanVienKyThuat">Nhân Viên Kỹ Thuật</label>
                                            <select class="form-control" id="MaNhanVienKyThuat" name="MaNhanVienKyThuat"
                                                required>
                                                <option value="">-- Chọn nhân viên --</option>
                                                @foreach ($dsNhanVienKyThuat as $nvkt)
                                                    <option value="{{ $nvkt->MaNhanVien }}">{{ $nvkt->TenNhanVien }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="MaMay">Máy</label>
                                            <input type="text" class="form-control" id="MaMay" name="MaMay"
                                                value="{{ $yeuCauSuaChua->may->TenMay }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="MoTa">Mô Tả</label>
                                            <textarea class="form-control" id="MoTa" name="MoTa" rows="3"
                                                placeholder="Nhập mô tả..." readonly>{{ $yeuCauSuaChua->MoTa }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer">
                            <div class="form-group d-flex justify-content-between">
                                <a href="{{ route('yeucausuachua.index') }}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> Trở lại</a>
                                <button type="submit" class="btn btn-primary" form="formDuyetYCSC">
                                    <i class="fa-solid fa-check"></i> Duyệt
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
        @if (session('success'))
            $.notify({
                title: 'Thành công',
                message: '{{ session('success') }}',
            }, {
                type: 'success',
                delay: 5000,
                placement: {
                    from: "top",
                    align: "right"
                }
            });
        @endif
    </script>
@endsection