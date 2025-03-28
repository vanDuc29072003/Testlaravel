@extends('layouts.main')

@section('title', 'Danh sach May')
@section('content')
<div class="container">
    <div class="page-inner">
      <div class="table-responsive">
        <table class="table table-bordered">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="mb-0">Danh sách máy</h1>
            <button class="btn btn-primary">
              <i class="fa fa-plus"></i> Thêm mới
            </button>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead style="background-color: pink; color: black;">
                <tr>
                  <th>Mã Máy</th>
                  <th>Tên Máy</th>
                  <th>Seri Máy</th>
                  <th>Chu Kì Bảo Trì(Tháng)</th>
                  <th>Năm Sản Xuất</th>
                  <th>Hãng Sản Xuất</th>
                  <th>Cập Nhật</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">1</th>
                  <td>In Sóng</td>
                  <td>17TQMN1</td>
                  <td>4</td>
                  <td>2024</td>
                  <td>Toshiba</td>
                  <td>
                    <div class="d-flex gap-2">
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
      </table>
    </div>
  </div>
@endsection