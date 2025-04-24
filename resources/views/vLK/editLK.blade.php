<style>
    /* Dropdown nội dung có scroll nếu danh sách quá dài */
    .dropdown-menu.p-3 {
        max-height: 300px;
        overflow-y: auto;
    }
    #nhaCungCapButton {
        white-space: normal;
        overflow-wrap: break-word;
        text-align: left;
    }

</style>
@extends('layouts.main')

@section('title', 'Chỉnh Sửa Linh Kiện')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="card w-50 mx-auto">
                <div class="card-header">
                    <h1 class="m-3">Chỉnh Sửa Linh Kiện</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('linhkien.update', $linhKien->MaLinhKien) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <!-- Mã Linh Kiện -->
                        <div class="form-group">
                            <label for="MaLinhKien">Mã Linh Kiện</label>
                            <input type="text" class="form-control" id="MaLinhKien" name="MaLinhKien"
                                value="{{ $linhKien->MaLinhKien }}" readonly>
                        </div>

                        <!-- Tên Linh Kiện -->
                        <div class="form-group">
                            <label for="TenLinhKien">Tên Linh Kiện</label>
                            <input type="text" class="form-control" id="TenLinhKien" name="TenLinhKien"
                                value="{{ $linhKien->TenLinhKien }}" readonly>
                        </div>

                        <!-- Mô Tả -->
                        <div class="form-group">
                            <label for="MoTa">Mô Tả</label>
                            <textarea class="form-control" id="MoTa" name="MoTa" rows="3" readonly>{{ $linhKien->MoTa }}</textarea>
                        </div>
                        <!-- Đơn Vị Tính -->
                        <div class="form-group">
                            <label for="MaDonViTinh">Đơn Vị Tính</label>
                            <select class="form-control" id="MaDonViTinh" name="MaDonViTinh" disabled>
                                <option value="">Chọn đơn vị tính</option>
                                @foreach ($donViTinhs as $donViTinh)
                                    <option value="{{ $donViTinh->MaDonViTinh }}"
                                        {{ $linhKien->MaDonViTinh == $donViTinh->MaDonViTinh ? 'selected' : '' }}>
                                        {{ $donViTinh->TenDonViTinh }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                         <!-- Số Lượng -->
                         <div class="form-group">
                            <label for="SoLuong">Số Lượng</label>
                            <input type="number" class="form-control" id="SoLuong" name="SoLuong"
                                value="{{ $linhKien->SoLuong }}" required>
                        </div>
                        <!-- Nhà Cung Cấp -->
                        <div class="form-group">
                            <label>Tên Nhà Cung Cấp</label>
                            <div class="dropdown">
                                <button 
                                    id="nhaCungCapButton"
                                    class="btn btn-outline-secondary dropdown-toggle w-100 text-start"
                                    type="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Chọn nhà cung cấp
                                </button>
                        
                                <ul class="dropdown-menu p-3" style="width: 100%;">
                                    @foreach ($nhaCungCaps as $nhaCungCap)
                                        <li>
                                            <div class="form-check">
                                                <input 
                                                    class="form-check-input nha-cung-cap-checkbox"
                                                    type="checkbox"
                                                    name="MaNhaCungCap[]"
                                                    value="{{ $nhaCungCap->MaNhaCungCap }}"
                                                    {{ in_array($nhaCungCap->MaNhaCungCap, old('MaNhaCungCap', $selectedNhaCungCaps ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label">
                                                    {{ $nhaCungCap->TenNhaCungCap }}
                                                </label>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                       

                        <!-- Nút hành động -->
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Lưu Thay Đổi
                            </button>
                            <a href="{{ route('linhkien') }}" class="btn btn-secondary mx-3">Trở lại</a>
                            <a href="{{ route('nhacungcap.add') }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Thêm mới nhà cung cấp
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkboxes = document.querySelectorAll('.nha-cung-cap-checkbox');
        const button = document.getElementById('nhaCungCapButton');

        function updateButtonLabel() {
            const selected = [];
            checkboxes.forEach(cb => {
                if (cb.checked) {
                    selected.push(cb.parentElement.querySelector('label').innerText);
                }
            });

            if (selected.length > 0) {
                // nối từng tên với dấu xuống dòng
                button.innerHTML = selected.join('<br>');
            } else {
                button.textContent = "Chọn nhà cung cấp";
            }
        }

        updateButtonLabel(); // load sẵn nếu có dữ liệu cũ

        checkboxes.forEach(cb => {
            cb.addEventListener('change', updateButtonLabel);
        });
    });
</script>

@endsection
