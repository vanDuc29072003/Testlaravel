@extends('layouts.main')

@section('title', 'Thêm Loại Máy')

@section('content')
  <div class="container">
    <div class="page-inner">
      <div class="row justify-content-center">
        <div class="col-xl-6 col-md-8 col-sm-12">
          <div class="card">
            <div class="card-header">
              <h1 class="mt-3 mx-3">Thêm Loại Máy</h1>
            </div>
            <div class="card-body">
              <form id="formLoaiMay" action="{{ route('loaimay.store') }}" method="POST">
                @csrf

                <div class="form-group">
                  <label for="TenLoai">Tên Loại</label>
                  <input type="text" name="TenLoai" class="form-control" placeholder="Vui lòng nhập..." value="{{ old('TenLoai') }}" required>
                </div>

                <div class="form-group">
                  <label for="MoTa">Tên Viết Tắt</label>
                  <input type="text" name="MoTa" class="form-control" rows="3" placeholder="Vui lòng nhập..." value="{{ old('MoTa') }}" required></input>
                </div>
              </form>
            </div>
            <div class="card-footer">
              <div class="form-group d-flex justify-content-between">
                <a href="{{ route('loaimay.index') }}" class="btn btn-secondary">
                  <i class="fa fa-arrow-left"></i> Quay lại</a>
                <button type="submit" class="btn btn-primary" form="formLoaiMay">
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
        document.getElementById('TenLoai').addEventListener('input', function(e) {
            // Chỉ cho phép chữ cái, số, khoảng trắng, gạch ngang, gạch dưới
            this.value = this.value.replace(/[^\p{L}0-9 _\-,.()]/gu, '');
        })
        document.getElementById('MoTa').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^\p{L}0-9_-]/gu, '');
        })
    </script>
@endsection