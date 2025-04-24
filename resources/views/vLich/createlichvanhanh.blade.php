@extends('layouts.main')

@section('title', 'Thêm Lịch Vận Hành')

@section('content')
  <div class="container mt-5">
    <div class="row justify-content-center">
    <div class="col-lg-10 col-md-12">
      <div class="card shadow-sm p-5">
      <h2 class="mb-4 text-center" style="font-weight: bold;">Thêm Lịch Vận Hành</h2>

      <form action="{{ route('lichvanhanh.store') }}" method="POST">
        @csrf

        {{-- Ngày vận hành --}}
        <div class="mb-4">
        <div class="row g-3">
          {{-- Tháng --}}
          <div class="col-md-4">
          <label for="thang" class="form-label" style="font-size: 1.2rem;">Tháng</label>
          <select name="thang" id="thang" class="form-select form-select-lg" required>
            @for ($i = 1; $i <= 12; $i++)
        <option value="{{ $i }}" {{ $i == now()->month ? 'selected' : '' }}>{{ $i }}</option>
      @endfor
          </select>
          </div>

          {{-- Năm --}}
          <div class="col-md-4">
          <label for="nam" class="form-label" style="font-size: 1.2rem;">Năm</label>
          <select name="nam" id="nam" class="form-select form-select-lg" required>
            @for ($i = now()->year; $i >= 2000; $i--)
        <option value="{{ $i }}" {{ $i == now()->year ? 'selected' : '' }}>{{ $i }}</option>
      @endfor
          </select>
          </div>

          {{-- Tuần --}}
          <div class="col-md-4">
          <label for="tuan" class="form-label" style="font-size: 1.2rem;">Tuần</label>
          <select name="tuan" id="tuan" class="form-select form-select-lg" required>
            <option value="1" {{ now()->weekOfMonth == 1 ? 'selected' : '' }}>Tuần 1</option>
            <option value="2" {{ now()->weekOfMonth == 2 ? 'selected' : '' }}>Tuần 2</option>
            <option value="3" {{ now()->weekOfMonth == 3 ? 'selected' : '' }}>Tuần 3</option>
            <option value="4" {{ now()->weekOfMonth == 4 ? 'selected' : '' }}>Tuần 4</option>
            <option value="5" {{ now()->weekOfMonth == 5 ? 'selected' : '' }}>Tuần 5</option>
          </select>
          </div>
        </div>
        </div>

        {{-- Các dòng máy --}}
        <div id="entries-container" class="mb-4">
        <div class="entry-row row g-4 mb-3">
          <div class="col-md-3">
          <label class="form-label" style="font-size: 1.2rem;">Tên máy</label>
          <select name="entries[0][MaMay]" class="form-select form-select-lg" required>
            <option value="">-- Chọn máy --</option>
            @foreach ($may as $m)
        <option value="{{ $m->MaMay }}">{{ $m->TenMay }}</option>
      @endforeach
          </select>
          </div>

          <div class="col-md-3">
          <label class="form-label" style="font-size: 1.2rem;">Người đảm nhận</label>
          <select name="entries[0][MaNhanVien]" class="form-select form-select-lg" required>
            <option value="">-- Chọn nhân viên --</option>
            @foreach ($nhanvien as $nv)
        <option value="{{ $nv->MaNhanVien }}">{{ $nv->TenNhanVien }}</option>
      @endforeach
          </select>
          </div>

          <div class="col-md-3">
          <label class="form-label" style="font-size: 1.2rem;">Ca làm việc</label>
          <select name="entries[0][CaLamViec]" class="form-select form-select-lg" required>
            <option value="">-- Chọn ca --</option>
            <option value="Sáng">Ca 1 (Sáng)</option>
            <option value="Chiều">Ca 2 (Chiều)</option>
            <option value="Đêm">Ca 3 (Tối)</option>
          </select>
          </div>

          <div class="col-md-2">
          <label class="form-label" style="font-size: 1.2rem;">Mô tả</label>
          <input type="text" name="entries[0][MoTa]" class="form-control form-control-lg" placeholder="Ghi chú">
          </div>

          <div class="col-md-1 d-flex align-items-end">
          <button type="button" class="btn btn-danger btn-lg remove-entry">X</button>
          </div>
        </div>
        </div>

        {{-- Nút thêm máy --}}
        <div class="text-center mb-4">
        <button type="button" class="btn btn-secondary btn-lg" id="add-entry">
          <i class="fa fa-plus"></i> Thêm máy
        </button>
        </div>

        {{-- Nút lưu --}}
        <div class="d-flex justify-content-between">
        <a href="{{ route('lichvanhanh') }}" class="btn btn-secondary btn-lg">
          <i class="fa fa-arrow-left"></i> Quay lại
        </a>
        <button type="submit" class="btn btn-success btn-lg">
          <i class="fa fa-save"></i> Lưu
        </button>
        </div>

      </form>
      </div>
    </div>
    </div>
  </div>

  {{-- Script nhân bản dòng máy --}}
  <script>
    let index = 1;

    document.getElementById('add-entry').addEventListener('click', function () {
    const container = document.getElementById('entries-container');
    const entry = container.querySelector('.entry-row');
    const clone = entry.cloneNode(true);

    // Cập nhật tên theo index mới
    clone.querySelectorAll('select, input').forEach(el => {
      const name = el.getAttribute('name');
      if (name) {
      const newName = name.replace(/\[\d+\]/, `[${index}]`);
      el.setAttribute('name', newName);
      if (el.tagName === 'SELECT') el.selectedIndex = 0;
      else el.value = '';
      }
    });

    container.appendChild(clone);
    index++;
    });

    document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-entry')) {
      const entry = e.target.closest('.entry-row');
      const allEntries = document.querySelectorAll('.entry-row');
      if (allEntries.length > 1) entry.remove();
    }
    });
  </script>
@endsection