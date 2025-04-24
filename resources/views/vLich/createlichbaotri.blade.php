@extends('layouts.main')

@section('title', 'Thêm Lịch Bảo trì')

@section('content')
<div class="container">
  <div class="page-inner">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <h1 class="mb-4">Thêm Lịch Bảo trì</h1>

        <form action="{{ route('lichbaotri.store') }}" method="POST">
          @csrf

          <!-- Mô tả -->
          <div class="mb-3">
            <label for="MoTa" class="form-label">Mô tả</label>
            <input type="text" name="MoTa" id="MoTa" class="form-control" value="{{ old('MoTa') }}" required>
          </div>

          <!-- Ngày bảo trì -->
          <div class="mb-3">
            <label for="NgayBaoTri" class="form-label">Ngày bảo trì bắt đầu</label>
            <input type="date" name="NgayBaoTri" id="NgayBaoTri" class="form-control" value="{{ old('NgayBaoTri') }}" required>
          </div>

          <!-- Tên máy -->
          <div class="mb-3">
            <label for="MaMay" class="form-label">Tên máy</label>
            <select name="MaMay" id="MaMay" class="form-select" required>
              <option value="">-- Chọn máy --</option>
              @foreach ($machines as $machine)
                <option value="{{ $machine->MaMay }}" {{ old('MaMay') == $machine->MaMay ? 'selected' : '' }}>
                  {{ $machine->TenMay }}
                </option>
              @endforeach
            </select>
          </div>

          <!-- Nút -->
          <div class="d-flex justify-content-between">
            <a href="{{ route('lichbaotri') }}" class="btn btn-secondary">Trở về</a>
            <button type="submit" class="btn btn-primary">Lưu lịch bảo trì</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
