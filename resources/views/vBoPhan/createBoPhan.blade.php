@extends('layouts.main')

@section('title', 'Thêm Bộ Phận')

@section('content')
<div class="container mt-5">
  <div class="page-inner">
    <div class="card shadow-sm">
      <div class="card-header">
        <h1 class="m-3">Thêm Bộ Phận</h1>
      </div>
      <div class="card-body">
        <form action="{{ route('bophan.store') }}" method="POST">
          @csrf

          <div class="mb-3">
            <label for="TenBoPhan" class="form-label fw-bold">Tên Bộ Phận</label>
            <input type="text" name="TenBoPhan" class="form-control" value="{{ old('TenBoPhan') }}" required>
            @error('TenBoPhan')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="form-group mt-4">
            <button type="submit" class="btn btn-primary">
              <i class="fa fa-save"></i> Lưu
            </button>
            <a href="{{ route('bophan.index') }}" class="btn btn-secondary mx-3">Quay lại</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
