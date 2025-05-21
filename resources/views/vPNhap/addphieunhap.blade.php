@extends('layouts.main')

@section('title', 'Thêm mới Phiếu Nhập Hàng')

@section('content')
    <div class="container">
        <div class="page-inner">
            <form action="{{ route('dsphieunhap.store') }}" method="POST">
                @csrf

                <div class="row">
                    <!-- Cột bên trái: Danh sách linh kiện -->
                    <div class="col-9">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="mb-4">Thêm mới Phiếu Nhập Hàng</h3>
                            <div>
                                <a href="{{ route('linhkien.add') }}" class="btn btn-primary">
                                    <i class="fa fa-plus"></i> Thêm mới linh kiện
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
                                        <th scope="col">Mã Linh Kiện</th>
                                        <th scope="col">Tên Linh Kiện</th>
                                        <th scope="col">Đơn Vị Tính</th>
                                        <th scope="col">Số Lượng</th>
                                        <th scope="col">Giá Nhập</th>
                                        <th scope="col">Tổng Cộng</th>
                                        <th scope="col">Cập Nhật</th>
                                    </tr>
                                </thead>
                                <tbody id="product-list">
                                    <!-- Dữ liệu linh kiện sẽ được thêm tại đây -->
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
                                    <option value="">Chọn nhà cung cấp</option>
                                    @foreach ($nhaCungCaps as $nhaCungCap)
                                        <option value="{{ $nhaCungCap->MaNhaCungCap }}">
                                            {{ $nhaCungCap->TenNhaCungCap }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="MaNhanVien">Nhân Viên</label>
                                <input type="text" class="form-control" id="MaNhanVien" name="MaNhanVien"
                                    value="{{ Auth::user()->nhanVien->MaNhanVien }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="NgayNhap">Ngày Nhập</label>
                                <input type="datetime-local" class="form-control" id="NgayNhap" name="NgayNhap"
                                    value="{{ date('Y-m-d\TH:i') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="TongSoLuong">Tổng Số Lượng</label>
                                <input type="number" class="form-control" id="TongSoLuong" name="TongSoLuong" readonly>
                            </div>
                            <div class="form-group">
                                <label for="TongThanhTien">Tổng Thành Tiền</label>
                                <input type="number" class="form-control" id="TongThanhTien" name="TongTien" readonly>
                            </div>
                            <div class="form-group">
                                <label for="GhiChu">Ghi Chú</label>
                                <textarea class="form-control" id="GhiChu" name="GhiChu" rows="3"></textarea>
                            </div>

                            <!-- Nút nằm dưới form thông tin phiếu nhập -->
                            <div class="form-group mt-4 d-flex justify-content-between">
                                <a href="{{ route('dsphieunhap') }}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> Trở lại
                                </a>
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
                total.value = rowTotal.toFixed(0); // Hiển thị thành tiền với 0 chữ số thập phân

                // Cộng dồn tổng số lượng và tổng thành tiền
                totalQty += parseInt(quantity);
                totalPriceValue += rowTotal;
            });

            // Cập nhật tổng số lượng và tổng thành tiền
            document.getElementById('TongSoLuong').value = totalQty;
            document.getElementById('TongThanhTien').value = totalPriceValue.toFixed(0); // Hiển thị tổng thành tiền với 0 chữ số thập phân
        }
    </script>

@endsection