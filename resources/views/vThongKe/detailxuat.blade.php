@extends('layouts.main')

@section('title', 'Chi Tiết Xuất Kho')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="card w-75 mx-auto">
            <div class="card-header">
                <h1 class="m-3">Chi Tiết Xuất Kho</h1>
                 <h5 class="mx-3">
                @foreach($chiTiet as $item)
                    <strong>Mã linh kiện  :</strong> <strong>{{ $item->MaLinhKien }}</strong><br>
                    <strong>Tên linh kiện :</strong> <strong>{{ $item->TenLinhKien }}</strong>
                    <hr>
                @endforeach

                </h5>
            </div>
            <div class="card-body p-5">
                @if($chiTiet->isEmpty())
                    <div class="alert alert-info text-center" role="alert" style="width: 99%;">
                        <p class="fst-italic m-0">Không có dữ liệu xuất kho trong khoảng thời gian đã chọn.</p>
                    </div>
                @else
                    <table class="table table-bordered table-striped">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>#</th>
                                <th>Ngày xuất</th>
                                <th>Nhân viên xuất</th>
                                <th>Số lượng xuất</th>
                                <th>Chi tiết</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($chiTiet as $index => $row)
                                <tr class="text-center align-middle">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($row->NgayXuat)->format('d/m/Y H:i') }}</td>
                                    <td>{{ $row->TenNhanVien ?? 'Không rõ' }}</td>
                                    <td>{{ number_format($row->SoLuong, 0, ',', '.') }}</td>
                                    <td>
                                        <a href="{{ route('phieuxuat.show', $row->MaPhieuXuat) }}" class="btn btn-info btn-sm">
                                            Chi tiết
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
            <div class="card-footer">
                <div class="m-3">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
