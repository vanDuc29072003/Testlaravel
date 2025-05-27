@extends('layouts.main')

@section('title', 'Chi Tiết Sửa Chữa Máy')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="card w-75 mx-auto">
                <div class="card-header">
                    <h1 class="m-3">Chi Tiết Sửa Chữa Máy</h1>
                    <h5 class="mx-3">
                        <strong>Mã Máy  :</strong> <strong>{{ $chiTietSuaChua->first()?->yeuCauSuaChua?->may?->MaMay2  }}</strong>
                    </br>
                        <strong>Tên Máy :</strong> <strong>{{ $chiTietSuaChua->first()?->yeuCauSuaChua?->may?->TenMay }}</strong>
                    </h5>
                </div>
                <div class="card-body p-5">
                    @if($chiTietSuaChua->isEmpty())
                         <div class="alert alert-info text-center" role="alert" style="width: 99%;">
                                    <p class="fst-italic m-0">Không có dữ liệu lịch sửa chữa nào cho máy này.</p>
                        </div>
                    @else
                        <table class="table table-bordered table-striped">
                            <thead class="text-center bg-light">
                            <tr>
                                <th rowspan="2">#</th>
                                <th rowspan="2">Thời gian sửa chữa</th>
                                <th colspan="2">Cách thức bàn giao</th>
                                <th rowspan="2">Đảm nhận sửa chữa</th>
                                <th rowspan="2">Nhân viên bàn giao</th>
                                <th rowspan="2">Chi phí (nếu có)</th>
                                <th rowspan="2">Xem chi tiết</th>
                            </tr>
                            <tr>
                                <th>Nội Bộ</th>
                                <th>Nhà CC</th>
                            </tr>
                            </thead>

                            <tbody>
                                @foreach($chiTietSuaChua as $index => $sc)
                                    <tr class="text-center align-middle">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $sc->created_at->format('d/m/Y H:i') }}</td>

                                     
                                        <td>
                                            @if($sc->TrangThai == 1)
                                                <i class="fa fa-check text-success"></i>
                                            @endif
                                        </td>
                                        <td>
                                            @if($sc->TrangThai == 2)
                                                <i class="fa fa-check text-success"></i>
                                            @endif
                                        </td>

                                       
                                        <td>
                                            @if($sc->TrangThai == 1)
                                                {{ $sc->nhanVienKyThuat?->TenNhanVien ?? 'Không rõ' }}
                                            @elseif($sc->TrangThai == 2)
                                                {{ $sc->phieuBanGiaoSuaChuaNCC?->nhaCungCap?->TenNhaCungCap ?? 'Không rõ' }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($sc->TrangThai == 1)
                                                {{ $sc->phieuBanGiaoNoiBo->nhanVienTao->TenNhanVien ?? 'Không rõ' }}
                                            @elseif($sc->TrangThai == 2)
                                                {{ $sc->phieuBanGiaoSuaChuaNCC?->nhanVienTao->TenNhanVien ?? 'Không rõ' }}
                                            @endif
                                      
                                        <td>
                                            @if($sc->TrangThai == 1)
                                                0đ
                                            @elseif($sc->TrangThai == 2)
                                                {{ number_format($sc->phieuBanGiaoSuaChuaNCC?->TongTien ?? 0, 0, ',', '.') }}đ
                                            @endif
                                        </td>

                                       
                                       <td>
                                        @if ($sc->TrangThai == 1)
                                            <a href="{{ route('lichsuachua.showpbg', $sc->MaLichSuaChua) }}" class="btn btn-info btn-sm">Chi tiết</a>
                                        @elseif ($sc->TrangThai == 2)
                                            <a href="{{ route('lichsuachua.showpbg1', $sc->MaLichSuaChua) }}" class="btn btn-info btn-sm">Chi tiết</a>
                                        @else
                                            <span class="text-muted">Không rõ</span>
                                        @endif
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
