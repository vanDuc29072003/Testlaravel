@extends('layouts.main')

@section('title', 'Thêm Loại Máy')

@section('content')
<div class="container mt-5">
  <div class="page-inner">
    <div class="card shadow-sm">
      <div class="card-header">
        <h1 class="m-3">Thêm Loại Máy</h1>
      </div>
      <div class="card-body">
        <form action="{{ route('loaimay.store') }}" method="POST">
          @csrf

          <div class="mb-3">
            <label for="TenLoai" class="form-label fw-bold">Tên Loại</label>
            <input type="text" name="TenLoai" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="MoTa" class="form-label fw-bold">Mô Tả</label>
            <textarea name="MoTa" class="form-control" rows="3"></textarea>
          </div>

          <div class="form-group mt-4">
            <button type="submit" class="btn btn-primary">
              <i class="fa fa-save"></i> Lưu
            </button>
            <a href="{{ route('loaimay.index') }}" class="btn btn-secondary mx-3">Quay lại</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
