@extends('layouts.main')

@section('title', 'Nhật Ký Vận Hành')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-md-8 col-sm-12">
                    <div class="card mx-auto">
                        <div class="card-header">
                            <h1 class="mt-3 mx-3">Nhật Ký Vận Hành</h1>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('lichvanhanh.updateNhatKi', $lich->MaLichVanHanh) }}" method="POST"
                                id="formNhatKi">
                                @csrf
                                @method('PUT')

                                <div class="row px-3">
                                    {{-- Ngày vận hành --}}
                                    <div class="form-group col-md-6">
                                        <label for="NgayVanHanh">Ngày vận hành</label>
                                        <input type="text" class="form-control" id="NgayVanHanh"
                                            value="{{ \Carbon\Carbon::parse($lich->NgayVanHanh)->format('d/m/Y') }}"
                                            readonly>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="NhanVien">Nhân viên</label>
                                        <input type="text" class="form-control" id="NhanVien"
                                            value="{{ $lich->nhanvien->TenNhanVien ?? 'Không xác định' }}" readonly>
                                    </div>
                                    {{-- Tên máy --}}
                                    <div class="form-group col-md-6">
                                        <label for="TenMay">Tên máy</label>
                                        <input type="text" class="form-control" id="TenMay"
                                            value="{{ $lich->may->TenMay ?? 'Không xác định' }}" readonly>
                                    </div>

                                    {{-- Ca làm việc --}}
                                    <div class="form-group col-md-6">
                                        <label for="CaLamViec">Ca làm việc</label>
                                        <input type="text" class="form-control" id="CaLamViec"
                                            value="{{ $lich->CaLamViec }}" readonly>
                                    </div>
                                </div>

                                {{-- Nhật ký (editable & required) --}}
                                <div class="form-group">
                                    <label for="NhatKi">Nhật ký <span class="text-danger">*</span></label>
                                    <textarea name="NhatKi" id="NhatKi" class="form-control" rows="4"
                                        placeholder="Nhập nhật ký vận hành...">{{ old('NhatKi', $lich->NhatKi) }}</textarea>
                                    <small id="nhatKiError" class="text-danger d-none">Vui lòng nhập nội dung nhật ký trước
                                        khi lưu.</small>
                                </div>

                                {{-- Trạng thái máy --}}
                                <div class="form-group">
                                    <label>Trạng thái máy</label>
                                    <div class="form-check p-1">
                                        <input class="form-check-input" type="radio" name="TrangThai" value="0"
                                            id="status_hoatdong" {{ $lich->may->TrangThai == 0 ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="status_hoatdong">Hoạt động bình thường</label>
                                    </div>
                                    <div class="form-check p-1">
                                        <input class="form-check-input" type="radio" name="TrangThai" value="2"
                                            id="status_suco" {{ $lich->may->TrangThai == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status_suco">Có sự cố</label>
                                    </div>
                                </div>

                                {{-- Mô tả sự cố (ẩn/hiện theo chọn) --}}
                                <div class="form-group" id="moTaSuCoGroup" style="display: none;">
                                    <label for="MoTaSuCo">Mô tả sự cố <span class="text-danger">*</span></label>
                                    <textarea name="MoTaSuCo" id="MoTaSuCo" class="form-control" rows="3"
                                        placeholder="Nhập mô tả sự cố nếu có...">{{ old('MoTaSuCo') }}</textarea>
                                </div>

                            </form>
                        </div>

                        <div class="card-footer">
                            <div class="form-group d-flex justify-content-between">
                                <a href="{{ route('lichvanhanh') }}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> Trở lại
                                </a>

                                <button type="submit" class="btn btn-primary" form="formNhatKi">
                                    <i class="fa fa-save"></i> Lưu
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Hiển thị hoặc ẩn phần mô tả sự cố
            function toggleMoTaSuCo() {
                const isSuCoChecked = document.getElementById('status_suco').checked;
                const moTaSuCoGroup = document.getElementById('moTaSuCoGroup');

                if (isSuCoChecked) {
                    moTaSuCoGroup.style.display = 'block';
                    document.getElementById('MoTaSuCo').setAttribute('required', 'required');
                } else {
                    moTaSuCoGroup.style.display = 'none';
                    document.getElementById('MoTaSuCo').removeAttribute('required');
                }
            }

            toggleMoTaSuCo(); // Gọi khi load trang

            document.getElementById('status_hoatdong').addEventListener('change', toggleMoTaSuCo);
            document.getElementById('status_suco').addEventListener('change', toggleMoTaSuCo);

            // Kiểm tra Nhật ký trước khi submit
            const form = document.getElementById('formNhatKi');
            const nhatKi = document.getElementById('NhatKi');
            const error = document.getElementById('nhatKiError');

            form.addEventListener('submit', function (e) {
                if (!nhatKi.value.trim()) {
                    e.preventDefault();
                    error.classList.remove('d-none');
                    nhatKi.focus();
                } else {
                    error.classList.add('d-none');
                }
            });
        });
    </script>
    
@endsection