@extends('layouts.main')

@section('title', 'Tạo Yêu Cầu Sửa Chữa')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-md-8 col-sm-12">
                    <div class="card mx-auto">
                        <div class="card-header">
                            <h1 class="m-3">Tạo yêu cầu sửa chữa</h1>
                        </div>
                        <div class="card-body">
                            <form id="formYCSC" action="{{ route('yeucausuachua.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="TenNhanVien">Nhân Viên</label>
                                            <input type="text" class="form-control" id="TenNhanVien" name="TenNhanVien"
                                                value="{{ $nhanVien->TenNhanVien }}" readonly>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="ThoiGianYeuCau">Thời Gian Yêu Cầu</label>
                                            <input type="text" class="form-control" id="ThoiGianYeuCau" name="ThoiGianYeuCau"
                                                value="{{ now()->format('d-m-Y H:i:s') }}" readonly>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="MaMay">Máy</label>
                                            <select class="form-control" id="MaMay" name="MaMay" required>
                                                <option value="">-- Chọn máy --</option>
                                                @foreach ($dsMay as $may)
                                                    <option value="{{ $may->MaMay }}"
                                                        @if (isset($lichVanHanh) && $lichVanHanh->MaMay == $may->MaMay) selected @endif>
                                                        {{ $may->TenMay }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="MoTa">Mô Tả</label>
                                                <textarea class="form-control" id="MoTa" name="MoTa" rows="3"
                                                    placeholder="Nhập mô tả..." required>{{ isset($lichVanHanh) ? 'Ca làm việc: ' . $lichVanHanh->CaLamViec : '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer">
                            <div class="form-group d-flex justify-content-between">
                                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> Trở lại</a>
                                <button type="submit" class="btn btn-primary" form="formYCSC">
                                    <i class="fa fa-save"></i> Tạo Mới
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
        document.getElementById('MoTa').addEventListener('input', function (e) {
            this.value = this.value.replace(/[^\p{L}0-9 _\-,.()]/gu, '');
        });
   </script>
@endsection