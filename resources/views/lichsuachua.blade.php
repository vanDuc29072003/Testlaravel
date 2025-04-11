{{-- filepath: c:\laragon\www\DoAn\resources\views\lichsuachua.blade.php --}}
@extends('layouts.main')

@section('title', 'Lịch Sửa Chữa')

@section('content')
<div class="container">
  <div class="page-inner">
    <div class="table-responsive">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Lịch sửa chữa</h1>
        <button class="btn btn-primary">
          <i class="fa fa-plus"></i> Thêm mới
        </button>
      </div>
      <table class="table table-bordered">
        <thead style="background-color: #ffc0cb; color: black;">
          <tr>
            <th>STT</th>
            <th>TG sự cố</th>
            <th>Mã Máy</th>
            <th>Tên Máy</th>
            <th>Người Tạo</th>
            <th>Người Đảm Nhận</th>
            <th>Mô Tả</th>
            <th>Trạng thái</th>
            <th>Cập Nhật</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($lichsuachua as $lich )
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{$lich->yeucau->ThoiGianYeuCau}}</td>
            <td>{{$lich->yeucau->MaMay}}</td>
            <td>{{$lich->yeucau->may->TenMay}}</td>
            <td>{{$lich->yeucau->nhanvienyeucau->TenNhanVien}}</td>
            <td>{{$lich->nhanvienkithuat->TenNhanVien}}</td>
            <td>{{$lich->yeucau->MoTa}}</td>
            <td>
              @if ($lich->TrangThai == 0)
                <span class="badge bg-warning">Chưa hoàn thành</span>
              @elseif ($lich->TrangThai == 1)
                <span class="badge bg-success">Đã hoàn thành</span>
              @else
                <span class="badge bg-danger">Đã hủy</span>
              @endif
            <td>
              <div class="d-flex gap-2">
                <button class="btn btn-success btn-sm">
                  <i class="fas fa-check"></i> Bàn Giao
                </button>
                <button class="btn btn-warning btn-sm">
                  <i class="fa fa-edit"></i> Sửa
                </button>
                <button class="btn btn-danger btn-sm">
                  <i class="fa fa-trash"></i> Xóa
                </button>
              </div>
            </td>
          </tr>
          @endforeach
          
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection