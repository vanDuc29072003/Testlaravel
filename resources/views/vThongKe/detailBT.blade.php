@extends('layouts.main')

@section('title', 'Chi Tiết Bảo Trì Máy')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="card w-75 mx-auto">
                <div class="card-header">
                    <h1 class="m-3">Chi Tiết Bảo Trì Máy</h1>
                    <h5 class="mx-3">
                        <strong>Mã Máy  :</strong> 
                         <strong>{{ $chiTietBaoTri->lichBaoTri->first()?->may?->MaMay2 ?? 'Không rõ' }}</strong>
                        </br>
                        <strong>Tên Máy :</strong> 
                      <strong>{{ $chiTietBaoTri->lichBaoTri->first()?->may?->TenMay?? 'Không rõ' }}</strong>

                    </h5>
                </div>
                <div class="card-body p-5">
                    @if($chiTietBaoTri === null || $chiTietBaoTri->lichBaoTri->isEmpty())

                        <div class="alert alert-warning">Không có dữ liệu bảo trì cho máy này.</div>
                    @else
                       <table class="table table-bordered table-striped">
                            <thead class="text-center bg-light">
                                <tr>
                                    <th>#</th>
                                    <th>Ngày Bảo Trì</th>
                                    <th>Đơn Vị Bảo Trì</th>
                                    <th>Nhân Viên Bàn Giao</th>
                                    <th>Chi Phí Bảo Trì</th>
                                    <th>Xem Chi Tiết</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($chiTietBaoTri->lichBaoTri as $index => $bt)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ \Carbon\Carbon::parse($bt->NgayBaoTri)->format('d/m/Y') }}</td>
                                      @if ($index == 0)
                                           
                                            <td rowspan="{{ count($chiTietBaoTri->lichBaoTri) }}" class="align-middle text-center">
                                                {{ $chiTietBaoTri->nhaCungCap->TenNhaCungCap ?? 'Không rõ' }}
                                            </td>
                                        @endif
                                        <td>{{ $bt->phieuBanGiaoBaoTri?->nhanVien?->TenNhanVien ?? 'Không rõ' }}</td>
                                        <td>{{ number_format($bt->phieuBanGiaoBaoTri?->TongTien ?? 0, 0, ',', '.') }} đ</td>
                                        <td>
                                                <a href="{{ route('lichbaotri.showpbg', $bt->MaLichBaoTri) }}" class="btn btn-sm btn-primary">
                                                    Xem Chi Tiết
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
                        <a href="{{ route('thongkesuachua') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
