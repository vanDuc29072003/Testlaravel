@extends('layouts.main')

@section('title', 'Chỉnh Sửa Lịch Vận Hành')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow-sm p-4">
                    <h2 class="mb-4 text-center" style="font-weight: bold;">Chỉnh Sửa Lịch Vận Hành</h2>

                    <form action="{{ route('lichvanhanh.update', $lich->MaLichVanHanh) }}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="PATCH">
                    

                        {{-- Ngày vận hành (không chỉnh sửa được) --}}
                        <div class="mb-3">
                            <label for="NgayVanHanh" class="form-label" style="font-size: 1.2rem;">Ngày vận hành</label>
                            <input type="text" id="NgayVanHanh" class="form-control form-control-lg"
                                value="{{ \Carbon\Carbon::parse($lich->NgayVanHanh)->format('d/m/Y') }}" readonly>
                        </div>

                        {{-- Tên máy --}}
                        <div class="mb-3">
                            <label for="MaMay" class="form-label" style="font-size: 1.2rem;">Tên máy</label>
                            <select name="MaMay" id="MaMay" class="form-select form-select-lg" required>
                                <option value="">-- Chọn máy --</option>
                                @foreach ($may as $m)
                                    <option value="{{ $m->MaMay }}" {{ $m->MaMay == $lich->MaMay ? 'selected' : '' }}>
                                        {{ $m->TenMay }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Người đảm nhận --}}
                        <div class="mb-3">
                            <label for="MaNhanVien" class="form-label" style="font-size: 1.2rem;">Người đảm nhận</label>
                            <select name="MaNhanVien" id="MaNhanVien" class="form-select form-select-lg" required>
                                <option value="">-- Chọn nhân viên --</option>
                                @foreach ($nhanvien as $nv)
                                    <option value="{{ $nv->MaNhanVien }}" {{ $nv->MaNhanVien == $lich->MaNhanVien ? 'selected' : '' }}>
                                        {{ $nv->TenNhanVien }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Ca làm việc --}}
                        <div class="mb-3">
                            <label for="CaLamViec" class="form-label" style="font-size: 1.2rem;">Ca làm việc</label>
                            <select name="CaLamViec" id="CaLamViec" class="form-select form-select-lg" required>
                                <option value="Sáng" {{ $lich->CaLamViec == 'Sáng' ? 'selected' : '' }}>Ca 1 (Sáng)</option>
                                <option value="Chiều" {{ $lich->CaLamViec == 'Chiều' ? 'selected' : '' }}>Ca 2 (Chiều)
                                </option>
                                <option value="Đêm" {{ $lich->CaLamViec == 'Đêm' ? 'selected' : '' }}>Ca 3 (Đêm)</option>
                            </select>
                        </div>

                        {{-- Mô tả --}}
                        <div class="mb-3">
                            <label for="MoTa" class="form-label" style="font-size: 1.2rem;">Mô tả</label>
                            <textarea name="MoTa" id="MoTa" class="form-control form-control-lg" rows="3"
                                placeholder="Nhập mô tả">{{ $lich->MoTa }}</textarea>
                        </div>

                        {{-- Nút lưu --}}
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('lichvanhanh') }}" class="btn btn-secondary btn-lg">
                                <i class="fa fa-arrow-left"></i> Quay lại
                            </a>
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fa fa-save"></i> Lưu thay đổi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection