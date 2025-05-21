@extends('layouts.main')

@section('title', 'Thêm mới Phiếu Xuất Kho')

@section('content')
    <div class="container">

        <div class="page-inner">
            <form action="{{ route('dsphieuxuat.store') }}" method="POST">
                @csrf

                <div class="row">
                    <!-- Cột bên trái: Danh sách linh kiện -->
                    <div class="col-9">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="mb-4">Thêm mới Phiếu Xuất Kho</h3>
                        </div>

                        <div class="form-group">
                            <label for="searchLinhKien">Tìm kiếm linh kiện</label>
                            <input type="text" class="form-control" id="searchLinhKien" placeholder="Nhập tên linh kiện">
                            <div id="searchResults" class="list-group mt-2" style="max-height: 200px; overflow-y: auto;">
                                <!-- Kết quả tìm kiếm sẽ được hiển thị ở đây -->
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">Mã Linh Kiện</th>
                                        <th scope="col">Tên Linh Kiện</th>
                                        <th scope="col">Đơn Vị Tính</th>
                                        <th scope="col">Số Lượng</th>

                                        <th scope="col">Cập Nhật</th>
                                    </tr>
                                </thead>
                                <tbody id="product-list">
                                    @if (old('MaLinhKien') && old('SoLuong'))
                                        @foreach (old('MaLinhKien') as $index => $maLinhKien)
                                            <tr>
                                                <td><input type="text" class="form-control" name="MaLinhKien[]"
                                                        value="{{ $maLinhKien }}" readonly></td>
                                                <td><input type="text" class="form-control" name="TenLinhKien[]"
                                                        value="{{ old('TenLinhKien')[$index] ?? '' }}" readonly></td>
                                                <td><input type="text" class="form-control" name="TenDonViTinh[]"
                                                        value="{{ old('TenDonViTinh')[$index] ?? '' }}" readonly></td>
                                                <td>
                                                    <input type="number" class="form-control quantity" name="SoLuong[]"
                                                        value="{{ old('SoLuong')[$index] }}" min="1" required>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger btn-sm remove-product">
                                                        <i class="fa fa-trash"></i> Xóa
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>

                            </table>
                        </div>
                    </div>

                    <!-- Cột bên phải: Thông tin phiếu xuất -->
                    <div class="col-3">
                        <div class="border p-3 rounded">
                    
                            <div class="form-group">
                                <label for="MaNhanVienTao">Nhân Viên Tạo</label>
                                <input type="text" class="form-control" id="MaNhanVienTao" name="MaNhanVienTao"
                                    value="{{ old('MaNhanVienTao', Auth::user()->nhanVien->MaNhanVien) }}" readonly>
                            </div>
                    
                            <div class="form-group">
                                <label for="MaNhanVienNhan">Nhân Viên Nhận</label>
                                <select class="form-control" id="MaNhanVienNhan" name="MaNhanVienNhan" required>
                                    <option value="">Chọn nhân viên nhận</option>
                                    @foreach ($nhanViens as $nhanVien)
                                        <option value="{{ $nhanVien->MaNhanVien }}" 
                                            {{ old('MaNhanVienNhan') == $nhanVien->MaNhanVien ? 'selected' : '' }}>
                                            {{ $nhanVien->TenNhanVien }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                    
                            <div class="form-group">
                                <label for="NgayXuat">Ngày Xuất</label>
                                <input type="datetime-local" class="form-control" id="NgayXuat" name="NgayXuat"
                                    value="{{ old('NgayXuat', date('Y-m-d\TH:i')) }}" required>
                            </div>
                    
                            <div class="form-group">
                                <label for="TongSoLuong">Tổng Số Lượng</label>
                                <input type="number" class="form-control" id="TongSoLuong" name="TongSoLuong"
                                    value="{{ old('TongSoLuong') }}" readonly>
                            </div>
                    
                            <div class="form-group">
                                <label for="GhiChu">Ghi Chú</label>
                                <textarea class="form-control" id="GhiChu" name="GhiChu" rows="3">{{ old('GhiChu') }}</textarea>
                            </div>
                    
                            <div class="form-group mt-4 d-flex justify-content-between">
                                <a href="{{ route('dsphieuxuat') }}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> Trở lại</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Hoàn Thành
                                </button>
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
    document.addEventListener('DOMContentLoaded', function () {
       const searchInput = document.getElementById('searchLinhKien');

    // Danh sách ký tự không cho nhập
    const blockedChars = /[!@~`#$%^&*()+=\[\]{};:"\\|,.<>\/?]/;

    // Chặn nhập ký tự đặc biệt
    searchInput.addEventListener('keydown', function (e) {
        const char = e.key;
        if (blockedChars.test(char)) {
            e.preventDefault(); // Ngăn không cho nhập
        }
    });

    // Xử lý tìm kiếm
    searchInput.addEventListener('input', function () {
        let query = this.value;

        if (query.length > 2) {
            fetch(`/linhkien/search1?query=${query}`)
                .then(response => response.json())
                .then(data => {
                    let results = document.getElementById('searchResults');
                    results.innerHTML = '';

                    if (data.length > 0) {
                        data.forEach(item => {
                            let resultItem = document.createElement('a');
                            resultItem.href = '#';
                            resultItem.classList.add('list-group-item', 'list-group-item-action');
                            resultItem.textContent = `${item.TenLinhKien} (${item.MaLinhKien})`;
                            resultItem.dataset.id = item.MaLinhKien;
                            resultItem.dataset.name = item.TenLinhKien;
                            resultItem.dataset.unit = item.don_vi_tinh ? item.don_vi_tinh.TenDonViTinh : 'Không xác định';

                            // Sự kiện click
                            resultItem.addEventListener('click', function (e) {
                                e.preventDefault();
                                addLinhKienToTable(this.dataset.id, this.dataset.name, this.dataset.unit);
                            });

                            results.appendChild(resultItem);
                        });
                    } else {
                        results.innerHTML = '<div class="list-group-item">Không tìm thấy linh kiện</div>';
                    }
                });
        } else {
            document.getElementById('searchResults').innerHTML = '';
        }
        });

        // Thêm sự kiện cho các dòng linh kiện cũ (old input) sau khi load trang
        document.querySelectorAll('#product-list tr').forEach(row => {
            let quantityInput = row.querySelector('.quantity');
            let removeBtn = row.querySelector('.remove-product');

            if (quantityInput) {
                quantityInput.addEventListener('input', updateTotals);
            }

            if (removeBtn) {
                removeBtn.addEventListener('click', function () {
                    row.remove();
                    updateTotals();
                });
            }
        });

        // Khi trang load xong, luôn tính lại tổng số lượng
        updateTotals();
    });

    // Hàm thêm linh kiện vào bảng
    function addLinhKienToTable(maLinhKien, tenLinhKien, tenDonViTinh) {
        let existingRows = document.querySelectorAll('input[name="MaLinhKien[]"]');
        for (let row of existingRows) {
            if (row.value === maLinhKien) {
                $.notify({
                title: 'Lỗi',
                message: 'Linh kiện này đã được thêm!',
                icon: 'icon-bell'
            }, {
                type: 'danger',
                animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutUp'
                },
            });

            return;
            }
            }
        

        let row = document.createElement('tr');
        row.innerHTML = `
            <td><input type="text" class="form-control" name="MaLinhKien[]" value="${maLinhKien}" readonly></td>
            <td><input type="text" class="form-control" name="TenLinhKien[]" value="${tenLinhKien}" readonly></td>
            <td><input type="text" class="form-control" name="TenDonViTinh[]" value="${tenDonViTinh}" readonly></td>
            <td><input type="number" class="form-control quantity" name="SoLuong[]" placeholder="Số lượng" min="1" required></td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm remove-product">
                    <i class="fa fa-trash"></i> Xóa
                </button>
            </td>
        `;
        document.getElementById('product-list').appendChild(row);

        // Bắt sự kiện xóa
        row.querySelector('.remove-product').addEventListener('click', function () {
            row.remove();
            updateTotals();
        });

        // Bắt sự kiện thay đổi số lượng
        row.querySelector('.quantity').addEventListener('input', updateTotals);

        updateTotals();
    }

    // Hàm tính tổng số lượng linh kiện
    function updateTotals() {
        let totalQty = 0;
        document.querySelectorAll('#product-list .quantity').forEach(input => {
            let quantity = parseInt(input.value) || 0;
            totalQty += quantity;
        });
        document.getElementById('TongSoLuong').value = totalQty;
    }

    // Thông báo lỗi từ session nếu có
    @if (session('error'))
        $.notify({
            title: 'Lỗi',
            message: '{!! session('error') !!}',
            icon: 'icon-bell'
        }, {
            type: 'danger',
            animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutUp'
            },
        });

        // Cập nhật tổng số lượng sau khi hiển thị lỗi
        updateTotals();
    @endif
</script>
@endsection
