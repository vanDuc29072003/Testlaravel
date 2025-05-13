@extends('layouts.main')

@section('title', 'Chi Tiết Sửa Chữa Máy')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="card w-75 mx-auto">
                <div class="card-header">
                    <h1 class="m-3">Chi Tiết Sửa Chữa Máy</h1>
                    <h5 class="mx-3">
                       <strong> Mã Máy: </strong> <strong>{{ $chiTietSuaChua->first()?->may->MaMay2 ?? 'Không rõ' }}</strong>
                    </h5>
                </div>
                <div class="card-body p-5">
                    @if($chiTietSuaChua->isEmpty())
                        <div class="alert alert-warning">Không có dữ liệu sửa chữa cho máy này.</div>
                    @else
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Yêu Cầu Thứ</th>
                                    <th>Ngày Yêu Cầu</th>
                                    <th>Nhân Viên</th>
                                    <th>Mô Tả</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($chiTietSuaChua as $yc)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ \Carbon\Carbon::parse($yc->thoigianyeucau)->format('d/m/Y H:i') }}</td>
                                        <td>{{ $yc->nhanVien->TenNhanVien ?? 'N/A' }}</td>
                                        <td>{{ $yc->MoTa }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
                <div class="card-footer">
                    <div class="m-3">
                        <a href="{{ route('thongkesuachua') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
