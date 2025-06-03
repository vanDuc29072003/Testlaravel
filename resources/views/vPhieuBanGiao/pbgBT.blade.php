@extends('layouts.main')

@section('title', 'Tạo Phiếu Bàn Giao Nhà Cung Cấp')

@section('content')
<div class="container">
    <div class="page-inner">
        <form action="{{ route('phieubangiao.storeBT') }}" method="POST">
            @csrf
            <div class="row">
                <!-- DANH SÁCH LINH KIỆN -->
                <div class="col-md-9">
                    <h3>Phiếu Bàn Giao Sau Bảo Trì</h3>
                    <h4 class="fs-5 mb-3">Danh sách công việc và linh kiện sửa chữa/thay mới</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="text-center">
                                <tr>
                                    <th>Tên Linh Kiện & Công Việc</th>
                                    <th>Đơn Vị Tính</th>
                                    <th>Số Lượng</th>
                                    <th>Đơn Giá</th>
                                    <th>Bảo Hành</th>
                                    <th>Thành Tiền</th>
                                    <th>Xóa</th>
                                </tr>
                            </thead>
                            <tbody id="linhkien-list">
                                @php
                                    $oldTenLinhKien = old('TenLinhKien', ['']);
                                    $oldDonViTinh = old('DonViTinh', ['']);
                                    $oldSoLuong = old('SoLuong', ['']);
                                    $oldGiaThanh = old('GiaThanh', ['']);
                                    $oldBaoHanh = old('BaoHanh', []);
                                    $oldThanhTien = old('ThanhTien', ['0']);
                                    $tongTien = 0;
                                @endphp

                                @foreach ($oldTenLinhKien as $index => $tenLinhKien)
                                <tr>
                                    <td><input type="text" name="TenLinhKien[]" class="form-control" value="{{ $tenLinhKien }}" required placeholder="Nhập tên linh kiện hoặc công việc"></td>
                                    <td><input type="text" name="DonViTinh[]" class="form-control" value="{{ $oldDonViTinh[$index] ?? '' }}" placeholder="Nhập đơn vị tính"></td>
                                    <td><input type="text" name="SoLuong[]" class="form-control soLuong text-end" value="{{ $oldSoLuong[$index] ?? '' }}" required placeholder="Nhập số lượng"></td>
                                    <td><input type="text" name="GiaThanh[]" class="form-control GiaThanh text-end" value="{{ $oldGiaThanh[$index] ?? '' }}" required placeholder="Nhập giá thành"></td>
                                    <td class="text-center">
                                        <input type="checkbox" class="form-check-input baoHanh" style="transform: scale(1.5);" {{ isset($oldBaoHanh[$index]) && $oldBaoHanh[$index] == 1 ? 'checked' : '' }}>
                                        <input type="hidden" name="BaoHanh[{{ $index }}]" class="hiddenBaoHanh" value="{{ $oldBaoHanh[$index] ?? 0 }}">
                                    </td>
                                    <td><input type="text" name="ThanhTien[]" class="form-control thanhTien text-end" value="{{ $oldThanhTien[$index] ?? '' }}" readonly></td>
                                    <td class="text-center"><button type="button" class="btn btn-danger btn-sm xoaDong">X</button></td>
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

                <!-- THÔNG TIN PHIẾU BÀN GIAO -->
                <div class="col-md-3">
                    <div class="border p-3 rounded">
                        <input type="hidden" name="MaLichBaoTri" value="{{ $lichbaotri->MaLichBaoTri }}">
                        <input type="hidden" name="MaNhaCungCap" value="{{ $nhaCungCap->MaNhaCungCap }}">
                        <input type="hidden" name="MaNhanVien" value="{{ Auth::user()->MaNhanVien ?? '' }}">

                        <div class="form-group">
                            <label>Người Lập Phiếu</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->nhanvien->TenNhanVien }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="TenNhaCungCap">Tên Nhà Cung Cấp</label>
                            <input type="text" class="form-control" value="{{ $nhaCungCap->TenNhaCungCap }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="TenMay">Tên Máy Cần Bảo Trì
                                @if ($ngayHetBaoHanh && $ngayHetBaoHanh < \Carbon\Carbon::now())
                                    <span class="badge badge-danger">Hết bảo hành</span>
                                @elseif ($ngayHetBaoHanh)
                                    <span class="badge badge-warning">Còn bảo hành</span>
                                @endif
                            </label>
                            <input type="text" class="form-control" value="{{ $lichbaotri->may->TenMay ?? 'Không xác định' }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="ThoiGianBanGiao">Thời Gian Bàn Giao</label>
                            <input type="datetime-local" name="ThoiGianBanGiao" class="form-control" value="{{ old('ThoiGianBanGiao') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="TongTien">Tổng Tiền</label>
                        <input type="text" id="TongTien" name="TongTien" class="form-control" value="{{ old('TongTien', '0') }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="LuuY">Lưu Ý</label>
                            <textarea class="form-control" name="LuuY" rows="2">{{ old('LuuY') }}</textarea>
                        </div>

                        <div class="form-group d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Lưu Phiếu</button>
                            <a href="{{ route('lichbaotri') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Quay lại</a>
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
    function formatNumber(value) {
         const number = Number(value);
    return isNaN(number) ? '0' : number.toLocaleString('vi-VN');
    }

    function unformat(value) {
        return value.replace(/\./g, '').replace(/[^0-9]/g, '');
    }

    function tinhThanhTien(row) {
        const soLuong = parseFloat(unformat(row.querySelector('.soLuong')?.value)) || 0;
        const giaThanh = parseFloat(unformat(row.querySelector('.GiaThanh')?.value)) || 0;
        const baoHanh = row.querySelector('.baoHanh')?.checked;
        const thanhTien = baoHanh ? 0 : soLuong * giaThanh;
        row.querySelector('.thanhTien').value = formatNumber(thanhTien);
    }

    function tinhTongTien() {
        let tong = 0;
        document.querySelectorAll('.thanhTien').forEach(input => {
            tong += parseFloat(unformat(input.value)) || 0;
        });
        document.getElementById('TongTien').value = formatNumber(tong);
    }

    function themDong() {
        const rowCount = document.querySelectorAll('#linhkien-list tr').length;
        const row = `
        <tr>
            <td><input type="text" class="form-control" name="TenLinhKien[]" required placeholder="Nhập tên linh kiện hoặc công việc"></td>
            <td><input type="text" class="form-control" name="DonViTinh[]" placeholder="Nhập đơn vị tính"></td>
            <td><input type="text" class="form-control soLuong text-end" name="SoLuong[]" required placeholder="Nhập số lượng"></td>
            <td><input type="text" class="form-control GiaThanh text-end" name="GiaThanh[]" required placeholder="Nhập giá thành"></td>
            <td class="text-center">
                <input type="checkbox" class="form-check-input baoHanh" style="transform: scale(1.5);">
                <input type="hidden" name="BaoHanh[${rowCount}]" value="0" class="hiddenBaoHanh">
            </td>
            <td><input type="text" class="form-control thanhTien text-end" name="ThanhTien[]" value="0" readonly></td>
            <td class="text-center"><button type="button" class="btn btn-danger btn-sm xoaDong">X</button></td>
        </tr>`;
        document.getElementById('linhkien-list').insertAdjacentHTML('beforeend', row);
    }

    document.addEventListener('input', function (e) {
        if (e.target.classList.contains('soLuong') || e.target.classList.contains('GiaThanh')) {
            const raw = unformat(e.target.value);
            e.target.value = formatNumber(raw);
            const row = e.target.closest('tr');
            tinhThanhTien(row);
            tinhTongTien();
        }
    });

    document.addEventListener('change', function (e) {
        if (e.target.classList.contains('baoHanh')) {
            const row = e.target.closest('tr');
            row.querySelector('.hiddenBaoHanh').value = e.target.checked ? 1 : 0;
            tinhThanhTien(row);
            tinhTongTien();
        }
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('xoaDong')) {
            e.target.closest('tr').remove();
            tinhTongTien();
        }
    });

    document.querySelector('form').addEventListener('submit', function () {
        document.querySelectorAll('.soLuong, .GiaThanh, .thanhTien, #TongTien').forEach(input => {
            input.value = unformat(input.value);
        });

        document.querySelectorAll('.baoHanh').forEach((checkbox, index) => {
            const hiddenInput = checkbox.closest('tr').querySelector('.hiddenBaoHanh');
            hiddenInput.name = `BaoHanh[${index}]`;
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('tbody#linhkien-list tr').forEach(row => {
            tinhThanhTien(row);
        });
        tinhTongTien();
    });
</script>
@endsection
