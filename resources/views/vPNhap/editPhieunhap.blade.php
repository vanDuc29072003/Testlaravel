@extends('layouts.main')

@section('title', 'Chỉnh sửa Phiếu Nhập Hàng')

@section('content')
    <div class="container">
        <div class="page-inner">
            <form action="{{ route('dsphieunhap.update', $phieuNhap->MaPhieuNhap) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Cột bên trái: Danh sách linh kiện -->
                    <div class="col-9">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3>Chỉnh sửa Phiếu Nhập Hàng</h3>
                            <div>
                                <a href="{{ route('linhkien.add') }}" class="btn btn-primary">
                                    <i class="fa fa-plus"></i> Thêm linh kiện mới
                                </a>
                            </div>
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
                                        <th scope="col">Mã</th>
                                        <th scope="col">Tên Linh Kiện</th>
                                        <th scope="col">Đơn Vị Tính</th>
                                        <th scope="col">Số Lượng</th>
                                        <th scope="col">Giá Nhập</th>
                                        <th scope="col">Tổng Cộng</th>
                                        <th scope="col">Cập Nhật</th>
                                    </tr>
                                </thead>
                                <tbody id="product-list">
                                    @foreach ($phieuNhap->chiTietPhieuNhap as $chiTiet)
                                        <tr>
                                            <td><input type="text" class="form-control" name="MaLinhKien[]"
                                                    value="{{ $chiTiet->MaLinhKien }}" readonly></td>
                                            <td><input type="text" class="form-control" name="TenLinhKien[]"
                                                    value="{{ $chiTiet->linhKien->TenLinhKien }}" readonly></td>
                                            <td><input type="text" class="form-control" name="TenDonViTinh[]"
                                                    value="{{ $chiTiet->linhKien->donViTinh->TenDonViTinh }}" readonly></td>
                                            <td><input type="number" class="form-control quantity" name="SoLuong[]"
                                                    value="{{ $chiTiet->SoLuong }}" required></td>
                                            <td><input type="number" class="form-control price" name="GiaNhap[]"
                                                    value="{{ $chiTiet->GiaNhap }}" required></td>
                                            <td><input type="number" class="form-control total" name="TongCong[]"
                                                    value="{{ $chiTiet->TongCong }}" readonly></td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-danger btn-sm remove-product">
                                                    <i class="fa fa-trash"></i> Xóa
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Cột bên phải: Thông tin phiếu nhập -->
                    <div class="col-3">
                        <div class="border p-3 rounded">
                            <div class="form-group">
                                <label for="MaNhaCungCap">Nhà Cung Cấp</label>
                                <select class="form-control" id="MaNhaCungCap" name="MaNhaCungCap" required>
                                    @foreach ($nhaCungCaps as $nhaCungCap)
                                        <option value="{{ $nhaCungCap->MaNhaCungCap }}" {{ $phieuNhap->MaNhaCungCap == $nhaCungCap->MaNhaCungCap ? 'selected' : '' }}>
                                            {{ $nhaCungCap->TenNhaCungCap }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="TenNhanVien">Nhân Viên</label>
                                <input type="text" class="form-control" id="TenNhanVien" name="TenNhanVien"
                                    value="{{ $phieuNhap->nhanVien->TenNhanVien}}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="NgayNhap">Ngày Nhập</label>
                                <input type="datetime-local" class="form-control" id="NgayNhap" name="NgayNhap"
                                    value="{{ $phieuNhap->NgayNhap }}" required>
                            </div>
                            <div class="form-group">
                                <label for="TongSoLuong">Tổng Số Lượng</label>
                                <input type="number" class="form-control" id="TongSoLuong" name="TongSoLuong"
                                    value="{{ $phieuNhap->TongSoLuong }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="TongThanhTien">Tổng Thành Tiền</label>
                                <input type="number" class="form-control" id="TongThanhTien" name="TongTien"
                                    value="{{ $phieuNhap->TongTien }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="GhiChu">Ghi Chú</label>
                                <textarea class="form-control" id="GhiChu" name="GhiChu"
                                    rows="3">{{ $phieuNhap->GhiChu }}</textarea>
                            </div>

                            <div class="form-group mt-4 text-right">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Lưu
                                </button>
                                <a href="{{ route('dsphieunhap') }}" class="btn btn-secondary ml-2">Trở lại</a>
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
        document.getElementById('searchLinhKien').addEventListener('input', function () {
            let query = this.value;

            if (query.length > 2) { // Chỉ tìm kiếm khi có ít nhất 3 ký tự
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

                                // Thêm sự kiện click để chọn linh kiện
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

        function addLinhKienToTable(maLinhKien, tenLinhKien, tenDonViTinh) {
            // Kiểm tra xem mã linh kiện đã tồn tại trong bảng chưa
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


            // Nếu không trùng, thêm linh kiện vào bảng
            let row = document.createElement('tr');
            row.innerHTML = `
                <td><input type="text" class="form-control" name="MaLinhKien[]" value="${maLinhKien}" readonly></td>
                <td><input type="text" class="form-control" name="TenLinhKien[]" value="${tenLinhKien}" readonly></td>
                <td><input type="text" class="form-control" name="TenDonViTinh[]" value="${tenDonViTinh}" readonly></td>
                <td><input type="number" class="form-control quantity" name="SoLuong[]" placeholder="Số lượng" min="1" required></td>
                <td><input type="number" class="form-control price" name="GiaNhap[]" placeholder="Giá nhập" min="1000" required></td>
                <td><input type="number" class="form-control total" name="TongCong[]" readonly></td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm remove-product">
                        <i class="fa fa-trash"></i> Xóa
                    </button>
                </td>
            `;
            document.getElementById('product-list').appendChild(row);

            // Gọi hàm cập nhật tổng số lượng và tổng thành tiền
            updateTotals();

            // Thêm sự kiện xóa hàng
            row.querySelector('.remove-product').addEventListener('click', function () {
                row.remove();
                updateTotals();
            });

            // Thêm sự kiện tính toán lại thành tiền khi thay đổi số lượng hoặc giá nhập
            row.querySelector('.quantity').addEventListener('input', updateTotals);
            row.querySelector('.price').addEventListener('input', updateTotals);
        }
        function updateTotals() {
            let rows = document.querySelectorAll('#product-list tr');
            let totalQty = 0;
            let totalPriceValue = 0;

            rows.forEach(row => {
                let quantity = row.querySelector('.quantity').value || 0;
                let price = row.querySelector('.price').value || 0;
                let total = row.querySelector('.total');

                // Tính toán thành tiền cho từng hàng
                let rowTotal = parseInt(quantity) * parseFloat(price);
                total.value = rowTotal.toFixed(4); // Hiển thị thành tiền với 2 chữ số thập phân

                // Cộng dồn tổng số lượng và tổng thành tiền
                totalQty += parseInt(quantity);
                totalPriceValue += rowTotal;
            });

            // Cập nhật tổng số lượng và tổng thành tiền
            document.getElementById('TongSoLuong').value = totalQty;
            document.getElementById('TongThanhTien').value = totalPriceValue.toFixed(2); // Hiển thị tổng thành tiền với 2 chữ số thập phân
        } function updateTotals() {
            let rows = document.querySelectorAll('#product-list tr');
            let totalQty = 0;
            let totalPriceValue = 0;

            rows.forEach(row => {
                let quantity = parseInt(row.querySelector('.quantity').value) || 0;
                let price = parseFloat(row.querySelector('.price').value) || 0;
                let total = row.querySelector('.total');

                // Tính toán thành tiền cho từng hàng
                let rowTotal = quantity * price;
                total.value = rowTotal.toFixed(2); // Hiển thị thành tiền với 2 chữ số thập phân

                // Cộng dồn tổng số lượng và tổng thành tiền
                totalQty += quantity;
                totalPriceValue += rowTotal;
            });

            // Cập nhật tổng số lượng và tổng thành tiền
            document.getElementById('TongSoLuong').value = totalQty;
            document.getElementById('TongThanhTien').value = totalPriceValue.toFixed(2); // Hiển thị tổng thành tiền với 2 chữ số thập phân
        }

        // Gắn sự kiện cho tất cả các trường số lượng và giá nhập
        function attachInputEvents() {
            let quantityInputs = document.querySelectorAll('.quantity');
            let priceInputs = document.querySelectorAll('.price');

            quantityInputs.forEach(input => {
                input.addEventListener('input', updateTotals);
            });

            priceInputs.forEach(input => {
                input.addEventListener('input', updateTotals);
            });
        }
        document.addEventListener('DOMContentLoaded', function () {
            attachInputEvents();
        });
        function attachRemoveEvents() {
            let removeButtons = document.querySelectorAll('.remove-product');

            removeButtons.forEach(button => {
                button.addEventListener('click', function () {
                    // Xóa hàng tương ứng
                    this.closest('tr').remove();
                    // Cập nhật tổng số lượng và tổng thành tiền
                    updateTotals();
                });
            });
        }
        document.addEventListener('DOMContentLoaded', function () {
            attachInputEvents(); // Gắn sự kiện cho các trường số lượng và giá nhập
            attachRemoveEvents(); // Gắn sự kiện "Xóa" cho các hàng đã có sẵn
            updateTotals(); // Tính toán tổng số lượng và tổng thành tiền ban đầu
        });
    </script>

@endsection