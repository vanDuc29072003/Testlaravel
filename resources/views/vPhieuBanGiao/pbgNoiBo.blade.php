@extends('layouts.main')

@section('title', 'Tạo phiếu bàn giao nội bộ')

@section('content')
    <div class="container">

        <div class="page-inner">
            <form action="{{ route(name: 'phieubangiao.store') }}" method="POST">
                @csrf
                <div class="row">
                    <!-- Cột bên trái: Danh sách linh kiện -->
                    <div class="col-9" id="linhKienSection">
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
                            <div style="display: none" class="form-group">
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
                                <label for="TenMay">Tên Máy Cần Sửa Chữa</label>
                               <input type="text" class="form-control" id="TenMay" 
                                 value="{{ $lichSuaChua->yeuCauSuaChua->may->TenMay ?? 'Không xác định' }}" readonly>

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
                            <!-- Checkbox Không thay thế linh kiện -->
                           <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="KhongThayLinhKien" required name="KhongThayLinhKien" value="1" style="transform: scale(1.5);">
                            <label class="form-check-label" for="KhongThayLinhKien" style="margin-left: 5px; font-size: 30px;">Không thay thế linh kiện</label>
                            </div>
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
        const searchInput = document.getElementById('searchLinhKien');
        const checkbox = document.getElementById('KhongThayLinhKien');
        const checkboxContainer = checkbox.closest('.form-group');
        const linhKienSection = document.getElementById('linhKienSection');
        const productList = document.getElementById('product-list');
        const form = document.querySelector('form');

        const blockedChars = /[!@~`#$%^&*()+=\[\]{};:"\\|,.<>\/?]/;

        // Ngăn nhập ký tự đặc biệt
        searchInput.addEventListener('keydown', function (e) {
            if (blockedChars.test(e.key)) {
                e.preventDefault();
            }
        });

        // Xử lý tìm kiếm linh kiện
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

      

        // Gán lại sự kiện cho các dòng cũ nếu có
        document.querySelectorAll('#product-list tr').forEach(setupRowEvents);

        // Thêm linh kiện vào bảng
        function addLinhKienToTable(maLinhKien, tenLinhKien, tenDonViTinh) {
            let existingRows = document.querySelectorAll('input[name="MaLinhKien[]"]');
            for (let row of existingRows) {
                if (row.value === maLinhKien) {
                    $.notify({
                        title: 'Lỗi',
                        message: 'Linh kiện này đã được thêm!',
                        icon: 'icon-bell'
                    },{ 
                        type: 'danger',
                        animate: {
                        enter: 'animated fadeInDown',
                        exit: 'animated fadeOutUp'
                    }
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
            productList.appendChild(row);
            setupRowEvents(row);
           
            updateCheckboxState();
        }

        // Gán sự kiện cho 1 dòng linh kiện
        function setupRowEvents(row) {
            row.querySelector('.remove-product').addEventListener('click', function () {
                row.remove();
               
                updateCheckboxState();
            });

         
        }

        // Cập nhật trạng thái checkbox
        function updateCheckboxState() {
            const hasRows = productList.querySelectorAll('tr').length > 0;

            if (hasRows) {
                checkbox.disabled = true;
                checkboxContainer.style.opacity = 0.5;
                checkboxContainer.style.pointerEvents = 'none';
            } else {
                checkbox.disabled = false;
                checkboxContainer.style.opacity = 1;
                checkboxContainer.style.pointerEvents = 'auto';
            }
        }

        // Gọi khi trang load
        updateCheckboxState();
     

        // Hiển thị thông báo lỗi nếu có
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
        @endif
    });
</script>
@endsection
