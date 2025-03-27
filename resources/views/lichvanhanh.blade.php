@extends('layouts.main')

@section('title', 'Lịch Sửa Chữa')

@section('content')
<div class="container">
  <div class="page-inner">
    <div class="table-responsive">
      <table class="table table-bordered">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h1 class="mb-0">Lịch vận hành</h1>
          <button class="btn btn-primary">
            <i class="fa fa-plus"></i> Thêm mới
          </button>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead style="background-color: pink; color: black;">
              <tr>
                <th>#</th>
                <th>Ngày</th>
                <th>Mã Máy</th>
                <th>Tên Máy</th>
                <th>Người Đảm Nhận</th>
                <th>Ghi Chú</th>
                <th>Cập Nhật</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">1</th>
                <td>15/3/2025</td>
                <td>17</td>
                <td>Máy ép UV</td>
                <td>Lò Văn Hóa</td>
                <td></td>
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
              <tr>
                <th scope="row">2</th>
                <td>15/3/2025</td>
                <td>10</td>
                <td>Máy bế</td>
                <td>Vũ Văn Dương</td>
                <td>Hiệu suất giảm nhẹ, kiểm tra hệ thống làm mát.</td>
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
              <tr>
                <th scope="row">3</th>
                <td>15/3/2025</td>
                <td>42</td>
                <td>Máy in</td>
                <td>Nguyễn Văn Chiến</td>
                <td></td>
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
              <tr>
                <th scope="row">4</th>
                <td>15/3/2025</td>
                <td>43</td>
                <td>Máy ép sóng</td>
                <td>Vũ Văn Hai</td>
                <td>Có tiếng ồn bất thường, cần theo dõi.</td>
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