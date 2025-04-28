@extends('layouts.main')

@section('title', 'Lịch Sửa Chữa')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive mb-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="mb-3">Lịch sửa chữa</h3>
                        </div>
                        <div id="bang-chua-hoan-thanh">
                            @if ($dsLSCChuaHoanThanh->count() > 0)
                                @foreach($dsLSCtheongay as $date => $group)
                                    <h6 class="mt-4">Ngày {{ $date }}</h6>
                                    <table class="table table-responsive table-bordered table-hover">
                                        <thead>
                                            <tr class="text-center">
                                                <th scope="col">Mã</th>
                                                <th scope="col">TGYC</th>
                                                <th scope="col">Máy</th>
                                                <th scope="col">Mô Tả</th>
                                                <th scope="col">NVYC</th>
                                                <th scope="col">Người đảm nhận</th>
                                                <th scope="col">Trạng thái</th>
                                                <th scope="col">Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($group as $cht)
                                                <tr class="text-center">
                                                    <td>{{ $cht->MaLichSuaChua}}</td>
                                                    <td>{{ \Carbon\Carbon::parse($cht->yeuCauSuaChua->ThoiGianYeuCau)->format('H:i') }}</td>
                                                    <td>{{ $cht->yeuCauSuaChua->may->TenMay }}</td>
                                                    <td>{{ $cht->yeuCauSuaChua->MoTa }}</td>
                                                    <td>{{ $cht->yeuCauSuaChua->nhanVien->TenNhanVien }}</td>
                                                    <td>{{ $cht->nhanVienKyThuat->TenNhanVien }}</td>
                                                    <td><span class="badge bg-warning">Chưa hoàn thành</span></td>
                                                    <td>
                                                        <div class="d-flex justify-content-center gap-3">
                                                            <a href="{{ route('lichsuachua.taophieubangiaonoibo', $cht->MaLichSuaChua) }}" class="btn btn-sm btn-success">
                                                                <i class="fa fa-check"></i> Bàn giao
                                                            </a>
                                                            <form action="{{ route('lichsuachua.lienhencc', $cht->MaLichSuaChua) }}"
                                                                method="POST" class="d-inline-block">
                                                                @csrf
                                                                @method('POST')
                                                                <a href="{{ route('lichsuachua.xemncc', $cht->MaLichSuaChua) }}" class="btn btn-danger btn-sm">
                                                                    <i class="fa fa-phone"></i> Liên hệ NCC
                                                                </a>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody> 
                                    </table>
                                @endforeach
                            @else
                                <div class="alert alert-info text-center" role="alert" style="width: 99%;">
                                    <p class="fst-italic m-0">Không có lịch sửa chữa nào chưa hoàn thành.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
              
                
                
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function confirmLienHe(button) {
            swal({
                title: 'Xác nhận?',
                icon: 'warning',
                buttons: {
                    confirm: {
                        text: 'Đồng ý',
                        className: 'btn btn-danger'
                    },
                    cancel: {
                        text: 'Hủy',
                        visible: true,
                        className: 'btn btn-success'
                    }
                }
            }).then((confirm) => {
                if (confirm) {
                    button.closest('form').submit();
                } else {
                    swal.close();
                }
            });
        }
    </script>
    <script>
        pusher.subscribe('channel-all').bind('eventUpdateTable', function (data) {
            if (data.reload) {
                console.log('Có cập nhật mới');

                $.ajax({
                    url: window.location.href,
                    type: 'GET',

                    success: function (response) {
                        const newChuaHoanThanh = $(response).find('#bang-chua-hoan-thanh').html();
                        const newDaHoanThanh = $(response).find('#bang-da-hoan-thanh').html();

                        $('#bang-chua-hoan-thanh').html(newChuaHoanThanh);
                        $('#bang-da-hoan-thanh').html(newDaHoanThanh);
                    },
                    error: function () {
                        console.error('Lỗi khi load lại bảng!');
                    }
                });
            }
        })
    </script>
@endsection