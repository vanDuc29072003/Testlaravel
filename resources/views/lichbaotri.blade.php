{{-- filepath: c:\laragon\www\DoAn\resources\views\lichsuachua.blade.php --}}
@extends('layouts.main')

@section('title', 'Lịch Bảo trì')

@section('content')
  <div class="container">
    <div class="page-inner">
    <div class="row">
      <!-- Phần bảng -->
      <div class="col-md-9">
      <div class="table-responsive">
        <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Lịch bảo trì</h1>
        <a href="" class="btn btn-primary">
          <i class="fa fa-plus"></i> Thêm mới
        </a>
        </div>
        <table class="table table-bordered">
        <thead style="background-color: #ffc0cb; color: black;">
          <tr>
          <th>STT</th>
          <th>Mô tả</th>
          <th>Ngày bảo trì</th>
          <th>Tên máy</th>
          <th style="width: 200px;">Trạng thái</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($lichbaotri as $index => $lich)
        <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $lich->MoTa }}</td>
        <td>{{ $lich->NgayBaoTri }}</td>
        <td>{{ $lich->may->TenMay ?? 'Không xác định' }}</td>
        <td style="width: 200px;">
        <div class="d-flex gap-2">
        <form action="" method="POST">
          @csrf
          <button type="submit" class="btn btn-success btn-sm">Hoàn thành</button>
        </form>
        <form action="" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger btn-sm">Hủy</button>
        </form>
        </div>
        </td>
        </tr>
      @endforeach
        </tbody>
        </table>
      </div>
      </div>

      <!-- Phần lọc -->
      <div class="col-md-3">
      <div style="margin-top :50px">
        <h5 class="mb-3">Bộ lọc</h5>
        <form action="{{ route('lichbaotri') }}" method="GET">
        <div class="mb-3">
          <label for="quy" class="form-label">Chọn quý</label>
          <select name="quy" id="quy" class="form-select">
          <option value="">-- Chọn quý --</option>
          <option value="1" {{ request('quy') == 1 ? 'selected' : '' }}>Quý 1</option>
          <option value="2" {{ request('quy') == 2 ? 'selected' : '' }}>Quý 2</option>
          <option value="3" {{ request('quy') == 3 ? 'selected' : '' }}>Quý 3</option>
          <option value="4" {{ request('quy') == 4 ? 'selected' : '' }}>Quý 4</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="nam" class="form-label">Chọn năm</label>
          <select name="nam" id="nam" class="form-select">
          <option value="">-- Chọn năm --</option>
          @for ($year = now()->year; $year >= 2000; $year--)
        <option value="{{ $year }}" {{ request('nam') == $year ? 'selected' : '' }}>{{ $year }}</option>
      @endfor
          </select>
        </div>
        <button type="submit" class="btn btn-primary w-100">Lọc</button>
        </form>
      </div>
      </div>
    </div>
    </div>
  </div>
@endsection