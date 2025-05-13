@extends('layouts.main')

@section('title', 'Nhật Ký Vận Hành')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center" style="margin-top: 20px;">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-sm p-4">
                <h2 class="mb-4 text-center" style="font-weight: bold;">Nhật Ký Vận Hành</h2>

                <form action="{{ route('lichvanhanh.updateNhatKi', $lich->MaLichVanHanh) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Ngày vận hành --}}
                    <div class="mb-3">
                        <label class="form-label" style="font-size: 1.1rem;">Ngày vận hành:</label>
                        <input type="text" class="form-control form-control-lg"
                            value="{{ \Carbon\Carbon::parse($lich->NgayVanHanh)->format('d/m/Y') }}" readonly>
                    </div>

                    {{-- Tên máy --}}
                    <div class="mb-3">
                        <label class="form-label" style="font-size: 1.1rem;">Tên máy:</label>
                        <input type="text" class="form-control form-control-lg"
                            value="{{ $lich->may->TenMay ?? 'Không xác định' }}" readonly>
                    </div>

                    {{-- Ca làm việc --}}
                    <div class="mb-3">
                        <label class="form-label" style="font-size: 1.1rem;">Ca làm việc:</label>
                        <input type="text" class="form-control form-control-lg"
                            value="{{ $lich->CaLamViec }}" readonly>
                    </div>

                    {{-- Nhật ký --}}
                    <div class="mb-3">
                        <label for="NhatKi" class="form-label" style="font-size: 1.1rem;">Nhật ký:</label>
                        <textarea name="NhatKi" id="NhatKi" class="form-control form-control-lg" rows="4"
                        placeholder="Nhập nhật ký vận hành..." disabled>{{ $lich->NhatKi }}</textarea>
                    </div>

                    {{-- Trạng thái máy (Checkbox) --}}
                    <div class="mb-3">
                        <label class="form-label" style="font-size: 3rem;">Trạng thái máy:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="TrangThai" value="0"
                                id="status_hoatdong" {{ $lich->may->TrangThai == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_hoatdong">Hoạt động bình thường</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="TrangThai" value="2"
                                id="status_suco" {{ $lich->may->TrangThai == 2 ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_suco">Có sự cố</label>
                        </div>
                    </div>

                    {{-- Nút lưu và chỉnh sửa --}}
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('lichvanhanh') }}" class="btn btn-secondary btn-lg">
                            <i class="fa fa-arrow-left"></i> Quay lại
                        </a>

                        <div>
                            <button type="submit" class="btn btn-primary btn-lg me-2">
                                <i class="fa fa-save"></i> Lưu
                            </button>

                            <button type="button" id="btnEdit" class="btn btn-success btn-lg">
                                <i class="fa fa-edit"></i> Chỉnh sửa
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Bật chỉnh sửa nhật ký
    document.getElementById('btnEdit').addEventListener('click', function () {
        document.getElementById('NhatKi').removeAttribute('disabled');
        document.getElementById('NhatKi').focus();
    });

    // Đảm bảo chỉ chọn 1 checkbox trạng thái
    const checkboxes = document.querySelectorAll('input[name="TrangThai"]');
    checkboxes.forEach(cb => {
        cb.addEventListener('change', function () {
            checkboxes.forEach(other => {
                if (other !== this) {
                    other.checked = false;
                }
            });
        });
    });
</script>
@endsection
