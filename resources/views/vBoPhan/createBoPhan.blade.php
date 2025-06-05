@extends('layouts.main')

@section('title', 'Thêm Bộ Phận')

@section('content')
<div class="container">
  <div class="page-inner">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-header">
            <h1 class="mt-3 mx-3">Thêm Bộ Phận</h1>
          </div>
          <div class="card-body">
            <form id="formBoPhan" action="{{ route('bophan.store') }}" method="POST">
              @csrf

              <div class="form-group">
                <label for="TenBoPhan" class="form-label">Tên Bộ Phận</label>
                <input type="text" name="TenBoPhan" class="form-control" value="{{ old('TenBoPhan') }}" placeholder="Nhập tên bộ phận" required>
                @error('TenBoPhan')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="form-group">
                <label for="TenRutGon" class="form-label">Tên Rút Gọn</label>
                <input type="text" name="TenRutGon" class="form-control" value="{{ old('TenRutGon') }}" placeholder="Nhập tên rút gọn" required>
                @error('TenRutGon')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </form>
          </div>
          <div class="card-footer">
            <div class="form-group d-flex justify-content-between">
                <a href="{{ route('bophan.index') }}" class="btn btn-secondary">
                  <i class="fa fa-arrow-left"></i> Quay lại</a>
                <button type="submit" class="btn btn-primary" form="formBoPhan">
                  <i class="fa fa-save"></i> Lưu
                </button>
              </div>
          </div>
        </div>
      </div>
  </div>
</div>
@endsection
