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
            <div class="row justify-content-center">
                <div class="col-xl-6 col-md-8 col-sm-12">
                    <div class="card mx-auto">
                        <div class="card-header">
                            <h1 class="m-3">Chỉnh Sửa Linh Kiện</h1>
                        </div>
                        <div class="card-body">
                            <form id="formLinhKien" action="{{ route('linhkien.update', $linhKien->MaLinhKien) }}" method="POST">
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
                                       value="{{ old('TenLinhKien', $formData['TenLinhKien'] ?? $linhKien->TenLinhKien) }}">
                                </div>
                                <!-- Đơn Vị Tính -->
                                <div class="form-group">
                                    <label for="MaDonViTinh">Đơn Vị Tính</label>
                                    <select class="form-control" id="MaDonViTinh" name="MaDonViTinh">
                                        @foreach ($donViTinhs as $donViTinh)
                                            <option value="{{ $donViTinh->MaDonViTinh }}"
                                                {{ (old('MaDonViTinh', $formData['MaDonViTinh'] ?? $linhKien->MaDonViTinh) == $donViTinh->MaDonViTinh) ? 'selected' : '' }}>
                                                {{ $donViTinh->TenDonViTinh }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>     
                                <!-- Mô Tả -->
                                <div class="form-group">
                                    <label for="MoTa">Mô Tả</label>
                                    <textarea class="form-control" id="MoTa" name="MoTa" rows="3">{{ $linhKien->MoTa }}</textarea>
                                </div>                             
                                <!-- Nhà Cung Cấp -->
                                <div class="form-group">
                                    <div class="d-flex justify-content-between">
                                        <label>Tên Nhà Cung Cấp</label>
                                             <a href="{{ route('linhkien.saveFormData') }}" 
                                            onclick="event.preventDefault(); document.getElementById('saveFormBeforeRedirect').submit();" 
                                            class="btn btn-sm btn-outline-white">
                                                <i class="fa fa-plus"></i> Thêm mới
                                            </a>
                                    
                                            
                                     </div>
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
                                                                {{ in_array($nhaCungCap->MaNhaCungCap, old('MaNhaCungCap', $formData['MaNhaCungCap'] ?? $selectedNhaCungCaps ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">
                                                            {{ $nhaCungCap->TenNhaCungCap }}
                                                        </label>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <form id="saveFormBeforeRedirect" action="{{ route('linhkien.saveFormData') }}" method="POST" style="display: none;">
                                                @csrf
                                                <input type="hidden" name="MaLinhKien" value="{{ old('MaLinhKien', $linhKien->MaLinhKien) }}">
                                                <input type="hidden" name="TenLinhKien" value="{{ old('TenLinhKien', $linhKien->TenLinhKien) }}">
                                                <input type="hidden" name="MaDonViTinh" value="{{ old('MaDonViTinh', $linhKien->MaDonViTinh) }}">
                                                <input type="hidden" name="MoTa" value="{{ old('MoTa', $linhKien->MoTa) }}">
                                                @foreach ($nhaCungCaps as $ncc)
                                                    <input type="hidden" name="MaNhaCungCap[]" value="{{ $ncc->MaNhaCungCap }}">
                                                @endforeach
                            </form>
                        <div class="card-footer">
                            <div class="form-group d-flex justify-content-between">
                                <a href="{{ route('linhkien') }}" class="btn btn-secondary" form="formLinhKien">
                                    <i class="fa fa-arrow-left"></i> Trở lại</a>
                                <button type="submit" class="btn btn-primary" form="formLinhKien">
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
    <script>
        document.getElementById('TenLinhKien').addEventListener('input', function(e) {
            // Chỉ cho phép chữ cái, số, khoảng trắng, gạch ngang, gạch dưới
            this.value = this.value.replace(/[^\p{L}0-9 _-]/gu, '');
        });
        document.getElementById('MoTa').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^\p{L}0-9]/gu, '');
        });
    </script>
@endsection
