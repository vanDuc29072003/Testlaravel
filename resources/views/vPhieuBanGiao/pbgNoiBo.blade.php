@extends('layouts.main')

@section('title', 'Tạo phiếu bàn giao nội bộ')

@section('content')
    <div class="container">

        <div class="page-inner">
            <form action="{{ route(name: 'phieubangiao.store') }}" method="POST">
                @csrf
                <div class="row">
                    <!-- Cột bên trái: Danh sách linh kiện -->
                    <div class="col-9">
                        <div class="d-flex flex-column mb-3">
                            <h3 class="mb-2">Tạo phiếu bàn giao nội bộ</h3>
                            <h4 class="fs-5 mb-2">Danh sách các linh kiện đã sửa chữa</h4>
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
                        <div class="border p-3 rounded ">
                            <div class="form-group">
                                <label for="MaLichSuaChua">Mã Lịch Sửa Chữa</label>
                                <input type="text" class="form-control" id="MaLichSuaChua" name="MaLichSuaChua"
                                value="{{ $lichSuaChua->MaLichSuaChua }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="NhanVienYeuCau">Nhân Viên Yêu Cầu</label>
                                <input type="text" class="form-control" id="NhanVienYeuCau" 
                                    value="{{ $lichSuaChua->yeuCauSuaChua->nhanVien->TenNhanVien }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="NhanVienKyThuat">Nhân Viên Đảm Nhận Sửa Chữa</label>
                                <input type="text" class="form-control" id="NhanVienKyThuat" 
                                    value="{{ $lichSuaChua->nhanVienKyThuat->TenNhanVien }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="ThoiGianYeuCau">Thời Gian Yêu Cầu</label>
                                <input type="text" class="form-control" id="ThoiGianYeuCau" 
                                    value="{{ \Carbon\Carbon::parse($lichSuaChua->yeuCauSuaChua->ThoiGianYeuCau)->format('d/m/Y H:i') }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="MoTa">Mô Tả</label>
                                <textarea class="form-control" id="MoTa" rows="3" readonly>{{ $lichSuaChua->yeuCauSuaChua->MoTa }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="ThoiGianBanGiao">Thời Gian Bàn Giao</label>
                                <input type="datetime-local" class="form-control" name="ThoiGianBanGiao" id="ThoiGianBanGiao" required>
                            </div>
                            
                            <!-- Phần Biện Pháp Xử Lý -->
                            <div class="form-group">
                                <label for="BienPhapXuLy">Biện Pháp Xử Lý</label>
                                <textarea name="BienPhapXuLy" class="form-control" id="BienPhapXuLy" rows="2" placeholder="Nhập biện pháp xử lý"></textarea>
                            </div>
                            
                            <!-- Phần Ghi Chú -->
                            <div class="form-group">
                                <label for="GhiChu">Ghi Chú</label>
                                <textarea name="GhiChu" class="form-control" id="GhiChu" rows="2" placeholder="Nhập ghi chú"></textarea>
                        </div>
    
                        <!-- Nút hành động -->
                        <div class="form-group d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Hoàn Thành
                            </button>
                            <a href="{{ route('lichsuachua.index') }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> Trở lại
                            </a>

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
            // Xử lý tìm kiếm linh kiện
            document.getElementById('searchLinhKien').addEventListener('input', function () {
                let query = this.value;
                let results = document.getElementById('searchResults');

                if (query.length > 2) {
                    fetch(`/linhkien/search1?query=${query}`)
                        .then(response => response.json())
                        .then(data => {
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
                    results.innerHTML = '';
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