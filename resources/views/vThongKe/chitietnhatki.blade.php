@extends('layouts.main')

@section('title', 'Chi Tiết Nhật Ký')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="mt-3 mx-3">Chi tiết Nhật kí vận hành</h1>
                        </div>
                        <div class="card-body m-3">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>Ngày vận hành</th>
                                        <td>{{ \Carbon\Carbon::parse($lich->NgayVanHanh)->format('d/m/Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Ca làm việc</th>
                                        <td>{{ $lich->CaLamViec }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tên máy</th>
                                        <td>{{ $lich->may->TenMay ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Người đảm nhận</th>
                                        <td>{{ $lich->nhanVien->TenNhanVien ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Trạng thái máy</th>
                                        <td>
                                            @if($lich->trangthai == 0)
                                                <span class="badge bg-success">Hoạt động</span>
                                            @elseif($lich->trangthai == 2)
                                                <span class="badge bg-danger">Có sự cố</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            <p><strong>Nhật ký:</strong></p>
                            <div class="border p-3 bg-light">
                                {{ $lich->NhatKi ?: 'Chưa có nội dung' }}
                            </div>
                            @if($lich->trangthai == 2)
                                <p><strong>Mô tả sự cố:</strong></p>
                                <div class="border p-3 bg-light">
                                    {{ $lich->MoTaSuCo ?: 'Chưa có nội dung' }}
                                </div>
                            @endif
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('nhatki.thongke') }}" class="btn btn-secondary m-3">Quay lại</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection