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
            <th>#</th>
            <th>TG sự cố</th>
            <th>Mã Máy</th>
            <th>Tên Máy</th>
            <th>Người Tạo</th>
            <th>Người Đảm Nhận</th>
            <th>Mô Tả</th>
            <th>Cập Nhật</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">1</th>
            <td>27/3/2025</td>
            <td>17</td>
            <td>Máy cắt giấy</td>
            <td>Nguyễn Văn Hoang</td>
            <td>Nguyễn Văn Hoan</td>
            <td>Sửa bộ phận cấp giấy, kiểm tra lại cảm biến.</td>
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
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection