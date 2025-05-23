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
                  <input type="text" name="TenLoai" class="form-control" placeholder="Vui lòng nhập..." required>
                </div>

                <div class="form-group">
                  <label for="MoTa">Mô Tả</label>
                  <textarea name="MoTa" class="form-control" rows="3" placeholder="Vui lòng nhập..."></textarea>
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