@extends('layouts.main')

@section('title', 'Chỉnh Sửa Lịch Vận Hành')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-md-8 col-sm-12">
                    <div class="card mx-auto">
                        <div class="card-header">
                            <h1 class="mt-3 mx-3">Chỉnh Sửa Lịch Vận Hành</h1>
                        </div>
                        <div class="card-body">
                            <form id="formLichVanHanh" action="{{ route('lichvanhanh.update', $lich->MaLichVanHanh) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                {{-- Ngày vận hành (readonly) --}}
                                <div class="form-group">
                                    <label for="NgayVanHanh">Ngày vận hành</label>
                                    <input type="text" id="NgayVanHanh" class="form-control"
                                        value="{{ \Carbon\Carbon::parse($lich->NgayVanHanh)->format('d/m/Y') }}" readonly>
                                </div>

                                {{-- Tên máy --}}
                                <div class="form-group">
                                    <label for="MaMay">Tên máy</label>
                                    <select name="MaMay" id="MaMay" class="form-control" required>
                                        <option value="">-- Chọn máy --</option>
                                        @foreach ($may as $m)
                                            <option value="{{ $m->MaMay }}" {{ $m->MaMay == $lich->MaMay ? 'selected' : '' }}>
                                                {{ $m->TenMay }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Người đảm nhận --}}
                                <div class="form-group">
                                    <label for="MaNhanVien">Người đảm nhận</label>
                                    <select name="MaNhanVien" id="MaNhanVien" class="form-control" required>
                                        <option value="">-- Chọn nhân viên --</option>
                                        @foreach ($nhanvien as $nv)
                                            <option value="{{ $nv->MaNhanVien }}" {{ $nv->MaNhanVien == $lich->MaNhanVien ? 'selected' : '' }}>
                                                {{ $nv->TenNhanVien }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Ca làm việc --}}
                                <div class="form-group">
                                    <label for="CaLamViec">Ca làm việc</label>
                                    <select name="CaLamViec" id="CaLamViec" class="form-control" required>
                                        <option value="Sáng" {{ $lich->CaLamViec == 'Sáng' ? 'selected' : '' }}>Ca 1 (Sáng)
                                        </option>
                                        <option value="Chiều" {{ $lich->CaLamViec == 'Chiều' ? 'selected' : '' }}>Ca 2 (Chiều)
                                        </option>
                                        <option value="Đêm" {{ $lich->CaLamViec == 'Đêm' ? 'selected' : '' }}>Ca 3 (Đêm)
                                        </option>
                                    </select>
                                </div>

                                {{-- Mô tả --}}
                                <div class="form-group">
                                    <label for="MoTa">Mô tả</label>
                                    <textarea name="MoTa" id="MoTa" class="form-control" rows="3"
                                        placeholder="Nhập mô tả">{{ $lich->MoTa }}</textarea>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer">
                            {{-- Thời gian bắt đầu --}}
                            {{-- Nút hành động --}}
                            <div class="form-group d-flex justify-content-between">
                                <a href="{{ route('lichvanhanh') }}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> Trở lại
                                </a>
                                <button type="submit" class="btn btn-primary" form="formLichVanHanh">
                                    <i class="fa fa-save"></i> Lưu Thay Đổi
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

