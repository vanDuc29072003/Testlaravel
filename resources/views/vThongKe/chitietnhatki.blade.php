@extends('layouts.main')

@section('title', 'Chi Tiết Nhật Ký')

@section('content')
    <div class="container mt-5" style="margin-top: 200px;">
        <div class="card p-4" style="max-width: 800px; margin: 20px auto;">
            <h3 class="mb-3">Chi tiết Nhật ký vận hành</h3>

            <p><strong>Ngày vận hành:</strong> {{ \Carbon\Carbon::parse($lich->NgayVanHanh)->format('d/m/Y') }}</p>
            <p><strong>Tên máy:</strong> {{ $lich->may->TenMay ?? '' }}</p>
            <p><strong>Ca làm việc:</strong> {{ $lich->CaLamViec }}</p>
            <p><strong>Người đảm nhận:</strong> {{ $lich->nhanVien->TenNhanVien ?? '' }}</p>
            <p><strong>Trạng thái máy:</strong>
                @if($lich->trangthai == 0)
                    <span class="badge bg-success">Hoạt động</span>
                @elseif($lich->trangthai == 2)
                    <span class="badge bg-danger">Có sự cố</span>
                @endif
            </p>
            <hr>
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

            <a href="{{ route('nhatki.thongke') }}" class="btn btn-secondary mt-3">Quay lại</a>
        </div>
    </div>
@endsection