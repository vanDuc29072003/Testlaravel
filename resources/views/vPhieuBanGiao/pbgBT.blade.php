@extends('layouts.main')

@section('title', 'Tạo Phiếu Bàn Giao Nhà Cung Cấp')

@section('content')
<div class="container">
    <div class="page-inner">
        <form action="{{ route('phieubangiao.storeBT') }}" method="POST">
            @csrf
            <div class="row">
                <!-- Bảng danh sách linh kiện -->
                <div class="col-md-9">
                    <div class="d-flex flex-column mb-3">
                        <h3 class="mb-2">Phiếu Bàn Giao Sau Bảo Trì</h3>
                        <h4 class="fs-5 mb-2">Danh sách công việc và linh kiện sửa chữa/thay mới</h4>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">Tên Linh Kiện & Công Việc</th>
                                    <th scope="col">Đơn Vị Tính</th>
                                    <th scope="col">Số Lượng</th>
                                    <th scope="col">Đơn Giá</th>
                                    <th scope="col">Bảo Hành</th>
                                    <th scope="col">Thành Tiền</th>
                                    <th scope="col">Xóa</th>
                                </tr>
                            </thead>
                            <tbody id="linhkien-list">
                                @php
                                    $oldTenLinhKien = old('TenLinhKien', ['']);
                                    $oldDonViTinh = old('DonViTinh', ['']);
                                    $oldSoLuong = old('SoLuong', ['']);
                                    $oldGiaThanh = old('GiaThanh', ['']);
                                    $oldBaoHanh = old('BaoHanh', []);
                                    $tongTien = 0;
                                @endphp

                                @foreach ($oldTenLinhKien as $index => $tenLinhKien)
                                    @php
                                        $soLuong = (float) ($oldSoLuong[$index] ?? 0);
                                        $giaThanh = (float) ($oldGiaThanh[$index] ?? 0);
                                        $baoHanh = isset($oldBaoHanh[$index]) ? $oldBaoHanh[$index] : 0;
                                        $thanhTien = ($baoHanh == 1) ? 0 : $soLuong * $giaThanh;
                                        $tongTien += $thanhTien;
                                    @endphp
                                    <tr>
                                        <td><input type="text" class="form-control" name="TenLinhKien[]" value="{{ $tenLinhKien }}" placeholder="Nhập tên linh kiện & công việc" required></td>
                                        <td><input type="text" class="form-control" name="DonViTinh[]" value="{{ $oldDonViTinh[$index] ?? '' }}" placeholder="Nhập đơn vị tính" ></td>
                                        <td><input type="number" class="form-control soLuong" name="SoLuong[]" value="{{ $oldSoLuong[$index] ?? '' }}" min="1" placeholder="Nhập số lượng" required></td>
                                        <td><input type="number" class="form-control GiaThanh" name="GiaThanh[]" value="{{ $oldGiaThanh[$index] ?? '' }}" min="1000" placeholder="Nhập đơn giá" required></td>
                                        <td class="text-center">
                                            <input type="checkbox" class="form-check-input baoHanh" style="transform: scale(1.5);" {{ $baoHanh == 1 ? 'checked' : '' }}>
                                            <input type="hidden" class="hiddenBaoHanh" name="BaoHanh[{{ $index }}]" value="{{ $baoHanh }}">
                                        </td>
                                        <td><input type="number" class="form-control thanhTien" name="ThanhTien[]" value="{{ $thanhTien }}" readonly></td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-danger btn-sm xoaDong">X</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7" class="text-center">
                                        <button type="button" class="btn btn-success btn-lg" onclick="themDong()">+</button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Thông tin phiếu bàn giao -->
                <div class="col-md-3">
                    <div class="border p-3 rounded">
                        <div class="form-group" style="display: none;">
                            <label for="MaLichBaoTri">Mã Lịch Bảo Trì</label>
                            <input type="text" class="form-control" name="MaLichBaoTri" value="{{ $lichbaotri->MaLichBaoTri }}" readonly>
                        </div>

                        <div class="form-group" style="display: none;">
                            <label for="MaNhaCungCap">Mã Nhà Cung Cấp</label>
                            <input type="text" class="form-control" name="MaNhaCungCap" value="{{ $nhaCungCap->MaNhaCungCap }}" readonly>
                        </div>

                        <div class="form-group">
                            <label>Người Lập Phiếu</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->nhanvien->TenNhanVien }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="TenNhaCungCap">Tên Nhà Cung Cấp</label>
                            <input type="text" class="form-control" value="{{ $nhaCungCap->TenNhaCungCap }}" readonly>
                        </div>

                        <div class="form-group" style="display: none;"  >
                            <label for="MaNhanVien">Mã Nhân Viên Tạo Phiếu</label>
                            <input type="text" class="form-control" name="MaNhanVien" value="{{ Auth::user()->MaNhanVien ?? '' }}" readonly>
                        </div>
                         <div class="form-group">
                            <label for="TenMay" class="d-flex justify-content-between">Tên Máy Cần Bảo Trì
                                @if ($ngayHetBaoHanh && $ngayHetBaoHanh < \Carbon\Carbon::now())
                                    <span class="badge badge-danger">Hết bảo hành</span>
                                @elseif ($ngayHetBaoHanh)
                                    <span class="badge badge-warning">Còn bảo hành</span>
                                @endif
                            </label>
                            <input type="text" class="form-control" name="TenMay" value="{{ $lichbaotri->may->TenMay ?? 'Không xác định' }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="ThoiGianBanGiao">Thời Gian Bàn Giao</label>
                            <input type="datetime-local" class="form-control" name="ThoiGianBanGiao" id="ThoiGianBanGiao"
                                value="{{ old('ThoiGianBanGiao') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="TongTien">Tổng Tiền</label>
                            <input type="number" class="form-control" id="TongTien" name="TongTien" value="{{ $tongTien }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="LuuY">Lưu Ý</label>
                            <textarea class="form-control" name="LuuY" rows="2" placeholder="Nhập những lưu ý">{{ old('LuuY') }}</textarea>
                        </div>

                        <div class="form-group d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Lưu Phiếu
                            </button>
                            <a href="{{ route('lichbaotri') }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
@section('scripts')
<script>
    function tinhTongTien() {
        let tong = 0;
        document.querySelectorAll('.thanhTien').forEach(input => {
            tong += parseFloat(input.value) || 0;
        });
        document.getElementById('TongTien').value = tong;
    }

    function themDong() {
        const rowCount = document.querySelectorAll('#linhkien-list tr').length;
        const row = `
        <tr>
            <td><input type="text" class="form-control" name="TenLinhKien[]" placeholder="Nhập tên linh kiện & công việc" required></td>
            <td><input type="text" class="form-control" name="DonViTinh[]" placeholder="Nhập đơn vị tính" ></td>
            <td><input type="number" class="form-control soLuong" name="SoLuong[]" min="1" placeholder="Nhập số lượng" required></td>
            <td><input type="number" class="form-control GiaThanh" name="GiaThanh[]" min="1000" placeholder="Nhập giá thành" required></td>
            <td class="text-center">
                <input type="checkbox" class="form-check-input baoHanh" style="transform: scale(1.5);">
                <input type="hidden" name="BaoHanh[${rowCount}]" value="0" class="hiddenBaoHanh">
            </td>
            <td><input type="number" class="form-control thanhTien" value="0" name="ThanhTien[]" readonly></td>
            <td class="text-center"><button type="button" class="btn btn-danger btn-sm xoaDong">X</button></td>
        </tr>`;
        document.getElementById('linhkien-list').insertAdjacentHTML('beforeend', row);
    }

    document.addEventListener('input', function (e) {
        if (e.target.classList.contains('soLuong') || e.target.classList.contains('GiaThanh')) {
            const row = e.target.closest('tr');
            const soLuong = parseFloat(row.querySelector('.soLuong')?.value) || 0;
            const giaThanh = parseFloat(row.querySelector('.GiaThanh')?.value) || 0;
            const baoHanh = row.querySelector('.baoHanh')?.checked;
            const thanhTienInput = row.querySelector('.thanhTien');
            thanhTienInput.value = baoHanh ? 0 : soLuong * giaThanh;
            tinhTongTien();
        }
    });

    document.addEventListener('change', function (e) {
        if (e.target.classList.contains('baoHanh')) {
            const row = e.target.closest('tr');
            const hiddenInput = row.querySelector('.hiddenBaoHanh');
            const soLuong = parseFloat(row.querySelector('.soLuong')?.value) || 0;
            const giaThanh = parseFloat(row.querySelector('.GiaThanh')?.value) || 0;
            const thanhTienInput = row.querySelector('.thanhTien');

            hiddenInput.value = e.target.checked ? 1 : 0;
            thanhTienInput.value = e.target.checked ? 0 : soLuong * giaThanh;
            tinhTongTien();
        }
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('xoaDong')) {
            e.target.closest('tr').remove();
            tinhTongTien();
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        tinhTongTien();
    });
</script>
  
    <script>
        @if (session('error'))
            $.notify({
                title: 'Lỗi',
                message: '{{ session('error') }}',
                icon: 'icon-bell'
            }, {
                type: 'danger',
                animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutUp'
                },
            });
        @endif
    </script>
@endsection
