<meta name="csrf-token" content="{{ csrf_token() }}">

@extends('layouts.main')

@section('title', 'Chỉnh sửa Phiếu Nhập Hàng')

@section('content')
    <div class="container">
        <div class="page-inner">
            <form action="{{ route('dsphieunhap.update', $phieuNhap->MaPhieuNhap) }}" method="POST">
                @csrf
                
                @method('PUT')
            <input type="hidden" name="MaPhieuNhap" value="{{ session('phieuNhapSession1.MaPhieuNhap') }}">

                <div class="row">
                    <!-- Cột bên trái: Danh sách linh kiện -->
                    <div class="col-9">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3>Chỉnh sửa Phiếu Nhập Hàng</h3>
                           
                        </div>

                        <div class="form-group">
                           <div class="d-flex justify-content-between">
                                <label for="searchLinhKien">Tìm kiếm linh kiện</label>
                                <a href="#" id="btnAddLinhKien" class="btn btn-sm btn-outline-white">
                                        <i class="fa fa-plus"></i> Thêm mới linh kiện
                                    </a>
                               </div>
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
                                @php
                                    $linhKienList = session('phieuNhapSession1')['LinhKienList'] ?? null;
                                @endphp

                                @if ($linhKienList)
                                    @foreach ($linhKienList as $item)
                                        <tr>
                                            <td><input type="text" class="form-control" name="MaLinhKien[]" value="{{ $item['MaLinhKien'] }}" readonly></td>
                                            <td><input type="text" class="form-control" name="TenLinhKien[]" value="{{ $item['TenLinhKien'] }}" readonly></td>
                                            <td><input type="text" class="form-control" name="TenDonViTinh[]" value="{{ $item['TenDonViTinh'] }}" readonly></td>
                                            <td><input type="text" class="form-control quantity" name="SoLuong[]" value="{{ number_format($item['SoLuong'],0,',','.') }}" required></td>
                                            <td><input type="text" class="form-control price" name="GiaNhap[]" value="{{number_format($item['GiaNhap'],0,',','.') }}" required></td>
                                            <td><input type="text" class="form-control total" name="TongCong[]" value="{{number_format($item['TongCong'],0,',','.') }}" readonly></td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-danger btn-sm remove-product">
                                                    <i class="fa fa-trash"></i> Xóa
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    @foreach ($phieuNhap->chiTietPhieuNhap as $chiTiet)
                                        <tr>
                                            <td><input type="text" class="form-control" name="MaLinhKien[]" value="{{ $chiTiet->MaLinhKien }}" readonly></td>
                                            <td><input type="text" class="form-control" name="TenLinhKien[]" value="{{ $chiTiet->linhKien->TenLinhKien }}" readonly></td>
                                            <td><input type="text" class="form-control" name="TenDonViTinh[]" value="{{ $chiTiet->linhKien->donViTinh->TenDonViTinh }}" readonly></td>
                                            <td><input type="text" class="form-control quantity" name="SoLuong[]" value="{{number_format($chiTiet->SoLuong,0,',','.') }}" required></td>
                                            <td><input type="text" class="form-control price" name="GiaNhap[]" value="{{number_format($chiTiet->GiaNhap,0,',','.') }}" required></td>
                                            <td><input type="text" class="form-control total" name="TongCong[]" value="{{number_format($chiTiet->TongCong,0,',','.') }}" readonly></td>
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

                    <!-- Cột bên phải: Thông tin phiếu nhập -->
                    <div class="col-3">
                        <div class="border p-3 rounded">
                            <div class="form-group">
                                <label for="TenNhanVien">Nhân Viên</label>
                               <input type="text" class="form-control" id="TenNhanVien" name="TenNhanVien"
                                value="{{ session('phieuNhapSession1.TenNhanVien') ?? $phieuNhap->nhanVien->TenNhanVien }}" readonly>
                                <input type="hidden" id="MaNhanVien" name="MaNhanVien" value="{{ session('phieuNhapSession1.MaNhanVien') ?? $phieuNhap->MaNhanVien }}">

                            </div>
                            <div class="form-group">
                                <label for="MaNhaCungCap">Nhà Cung Cấp</label>
                                <select class="form-control" id="MaNhaCungCap" name="MaNhaCungCap" required>
                                    @php
                                        $selectedNCC = session('phieuNhapSession1.MaNhaCungCap') ?? $phieuNhap->MaNhaCungCap;
                                    @endphp
                                    @foreach ($nhaCungCaps as $nhaCungCap)
                                        <option value="{{ $nhaCungCap->MaNhaCungCap }}" {{ $selectedNCC == $nhaCungCap->MaNhaCungCap ? 'selected' : '' }}>
                                            {{ $nhaCungCap->TenNhaCungCap }}
                                        </option>
                                    @endforeach
                                    </select>

                            </div>
                           
                            <div class="form-group">
                                <label for="NgayNhap">Ngày Nhập</label>
                               <input type="datetime-local" class="form-control" id="NgayNhap" name="NgayNhap"
                                value="{{ session('phieuNhapSession1.NgayNhap') ?? $phieuNhap->NgayNhap }}" required>

                            </div>
                            <div class="form-group">
                                <label for="TongSoLuong">Tổng Số Lượng</label>
                                 <input type="text" class="form-control" id="TongSoLuong" name="TongSoLuong"
                                value="{{ number_format(session('phieuNhapSession1.TongSoLuong') ?? $phieuNhap->TongSoLuong, 0, ',', '.') }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="TongThanhTien">Tổng Thành Tiền</label>
                               <input type="text" class="form-control" id="TongThanhTien" name="TongTien"
                                value="{{ number_format(session('phieuNhapSession1.TongThanhTien') ?? $phieuNhap->TongTien, 0, ',', '.') }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="GhiChu">Ghi Chú</label>
                                <textarea class="form-control" id="GhiChu" name="GhiChu" rows="3">{{ session('phieuNhapSession1.GhiChu') ?? $phieuNhap->GhiChu }}</textarea>

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
document.addEventListener('DOMContentLoaded', function () {
     document.querySelectorAll('.remove-product').forEach(button => {
        button.addEventListener('click', function () {
            this.closest('tr').remove();
            updateTotals();
        });
    });

    // Gán sự kiện cập nhật tổng tiền cho các input hiện có
    document.querySelectorAll('.quantity, .price').forEach(input => {
        input.addEventListener('input', updateTotals);
    });

    // Bắt sự kiện nút "Thêm mới linh kiện"
    document.getElementById('btnAddLinhKien').addEventListener('click', saveFormDataToSession1);

    // Xử lý tìm kiếm
    const searchInput = document.getElementById('searchLinhKien');
    const blockedChars = /[!@~`#$%^&*()+=\[\]{};:"\\|<>\/?]/;

    if (searchInput) {
        searchInput.addEventListener('keydown', function (e) {
            if (blockedChars.test(e.key)) {
                e.preventDefault();
            }
        });

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
    }
});

// Hàm lưu dữ liệu vào session
function saveFormDataToSession1(event) {
    event.preventDefault();
    const data = {
        MaPhieuNhap: "{{ $phieuNhap->MaPhieuNhap }}",
        MaNhaCungCap: document.getElementById('MaNhaCungCap').value,
        NgayNhap: document.getElementById('NgayNhap').value,
        GhiChu: document.getElementById('GhiChu').value,
        MaNhanVien: document.getElementById('MaNhanVien').value, 
        TenNhanVien: document.getElementById('TenNhanVien').value,
        LinhKienList: [],
        TongSoLuong: unformat(document.getElementById('TongSoLuong').value),
        TongThanhTien: unformat(document.getElementById('TongThanhTien').value),
    };

    document.querySelectorAll('#product-list tr').forEach(row => {
        data.LinhKienList.push({
            MaLinhKien: row.querySelector('input[name="MaLinhKien[]"]').value,
            TenLinhKien: row.querySelector('input[name="TenLinhKien[]"]').value,
            TenDonViTinh: row.querySelector('input[name="TenDonViTinh[]"]').value,
            SoLuong: unformat(row.querySelector('input[name="SoLuong[]"]').value),
            GiaNhap: unformat(row.querySelector('input[name="GiaNhap[]"]').value),
            TongCong: unformat(row.querySelector('input[name="TongCong[]"]').value)

        });
    });

    fetch("{{ route('phieunhap.saveSession1') }}", {
    method: 'POST', 
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify(data)

    }).then(() => {
        window.location.href = "{{ route('linhkien.add3') }}";
    });
}   
function formatNumber(value) {
    const number = Number(value);
    return isNaN(number) ? '0' : number.toLocaleString('vi-VN');
}

// Bỏ định dạng (loại bỏ dấu chấm ngăn cách)
function unformat(value) {
    return value.toString().replace(/\./g, '').replace(/[^0-9]/g, '');
}
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
        <td><input type="text" class="form-control quantity" name="SoLuong[]" placeholder="Số lượng" min="1" required></td>
        <td><input type="text" class="form-control price" name="GiaNhap[]" placeholder="Giá nhập" min="1000" required></td>
        <td><input type="text" class="form-control total" name="TongCong[]" readonly></td>
        <td class="text-center">
            <button type="button" class="btn btn-danger btn-sm remove-product">
                <i class="fa fa-trash"></i> Xóa
            </button>
        </td>
    `;
    document.getElementById('product-list').appendChild(row);

    updateTotals();

    row.querySelector('.remove-product').addEventListener('click', function () {
        row.remove();
        updateTotals();
    });

    row.querySelector('.quantity').addEventListener('input', updateTotals);
    row.querySelector('.price').addEventListener('input', updateTotals);
}

function updateTotals() {
    let rows = document.querySelectorAll('#product-list tr');
    let totalQty = 0;
    let totalPriceValue = 0;

    rows.forEach(row => {
        let quantityInput = row.querySelector('.quantity');
        let priceInput = row.querySelector('.price');
        let totalInput = row.querySelector('.total');

        let quantity = parseInt(unformat(quantityInput.value)) || 0;
        let price = parseFloat(unformat(priceInput.value)) || 0;
        let rowTotal = quantity * price;

        // Cập nhật lại từng trường đã định dạng
        quantityInput.value = formatNumber(quantity);
        priceInput.value = formatNumber(price);
        totalInput.value = formatNumber(rowTotal);

        totalQty += quantity;
        totalPriceValue += rowTotal;
    });

    document.getElementById('TongSoLuong').value = formatNumber(totalQty);
    document.getElementById('TongThanhTien').value = formatNumber(totalPriceValue);
}
document.querySelector('form').addEventListener('submit', function () {
    document.querySelectorAll('.quantity, .price, .total, #TongSoLuong, #TongThanhTien').forEach(input => {
        input.value = unformat(input.value);
    });
});
</script>


@endsection