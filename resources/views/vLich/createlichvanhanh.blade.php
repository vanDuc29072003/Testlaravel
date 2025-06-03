@extends('layouts.main')

@section('title', 'Thêm Lịch Vận Hành')

@section('content')
  <div class="container">
    <div class="page-inner">
      <div class="row justify-content-center">
        <div class="col-xl-8 col-sm-12">
          <div class="card mx-auto">
            <div class="card-header">
              <h1 class="mt-3">Thêm Lịch Vận Hành</h1>
            </div>
            <div class="card-body">
              
              <form id="formLichVanHanh" action="{{ route('lichvanhanh.store') }}" method="POST">
                @csrf
                {{-- Chọn kiểu lịch --}}
                <div class="form-group">
                  <label for="kieuLich">Kiểu lịch</label>
                  <select name="kieuLich" id="kieuLich" class="form-control" required>
                    <option value="tuan" selected>Lịch theo tuần</option>
                    <option value="ngay">Lịch theo ngày</option>
                  </select>
                </div>

                {{-- Chọn theo tuần --}}
                <div id="chon-tuan" class="form-group">
                  <div class="row">
                    {{-- Tháng --}}
                    <div class="col-md-4">
                      <label for="thang">Tháng</label>
                      <select name="thang" id="thang" class="form-control" required>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ $i == now()->month ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                      </select>
                    </div>

                    {{-- Năm --}}
                    <div class="col-md-4">
                      <label for="nam">Năm</label>
                      <select name="nam" id="nam" class="form-control" required>
                        @for ($i = now()->year; $i >= 2000; $i--)
                          <option value="{{ $i }}" {{ $i == now()->year ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                      </select>
                    </div>

                    {{-- Tuần --}}
                    <div class="col-md-4">
                      <label for="tuan">Tuần</label>
                      <select name="tuan" id="tuan" class="form-control" required>
                        @for ($i = 1; $i <= 5; $i++)
                          <option value="{{ $i }}" {{ now()->weekOfMonth == $i ? 'selected' : '' }}>Tuần {{ $i }}</option>
                        @endfor
                      </select>
                    </div>
                </div>
                </div>
                {{-- Chọn theo ngày (đột xuất) --}}
                <div id="chon-ngay" class="form-group" style="display: none;">
                  <label for="ngayDotXuat">Chọn ngày</label>
                  <input type="date" name="ngayDotXuat" id="ngayDotXuat" class="form-control">
                </div>

                {{-- Các dòng máy --}}
                <div id="entries-container" class="form-group">
                  <div class="entry-row row mb-3">
                    <div class="col-md-3">
                      <label for="MaMay">Tên máy</label>
                      <select name="entries[0][MaMay]" class="form-control" required>
                        <option value="">-- Chọn máy --</option>
                        @foreach ($may as $m)
                          <option value="{{ $m->MaMay }}">{{ $m->TenMay }}</option>
                        @endforeach
                      </select>
                    </div>

                    <div class="col-md-3">
                      <label for="MaNhanVien">Người đảm nhận</label>
                      <select name="entries[0][MaNhanVien]" class="form-control" required>
                        <option value="">-- Chọn nhân viên --</option>
                          @foreach ($nhanvien as $nv)
                            <option value="{{ $nv->MaNhanVien }}">{{ $nv->TenNhanVien }}</option>
                          @endforeach
                      </select>
                    </div>

                    <div class="col-md-2">
                      <label for="CaLamViec">Ca làm việc</label>
                      <select name="entries[0][CaLamViec]" class="form-control" required>
                        <option value="">-- Chọn ca --</option>
                        <option value="Sáng">Ca 1 (Sáng)</option>
                        <option value="Chiều">Ca 2 (Chiều)</option>
                        <option value="Đêm">Ca 3 (Tối)</option>
                      </select>
                    </div>

                    <div class="col-md-3">
                      <label class="form-label" style="font-size: 1.2rem;">Mô tả</label>
                      <input type="text" name="entries[0][MoTa]" class="form-control"
                        placeholder="Mô tả">
                    </div>

                    <div class="col-md-1 d-flex align-items-end">
                      <button type="button" class="btn btn-danger remove-entry">X</button>
                    </div>
                  </div>
                </div>

                {{-- Nút thêm máy --}}
                <div class="text-center form-group">
                  <button type="button" class="btn btn-border btn-secondary" id="add-entry">
                    <i class="fa fa-plus"></i>
                  </button>
                </div>
              </form>
            </div>
            <div class="card-footer">
              <div class="form-group d-flex justify-content-between">
                <a href="{{ route('lichvanhanh') }}" class="btn btn-secondary">
                  <i class="fa fa-arrow-left"></i> Quay lại
                </a>
                <button type="submit" class="btn btn-success" form="formLichVanHanh">
                  <i class="fa fa-save"></i> Lưu
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/remarkable-bootstrap-notify/3.1.3/bootstrap-notify.min.js"></script>


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
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

      // Ẩn/hiện trường chọn kiểu lịch
      document.getElementById('kieuLich').addEventListener('change', function () {
        const kieu = this.value;
        document.getElementById('chon-tuan').style.display = (kieu === 'tuan') ? 'block' : 'none';
        document.getElementById('chon-ngay').style.display = (kieu === 'ngay') ? 'block' : 'none';

        // Khi đổi sang lịch đột xuất thì có thể set required cho input ngày
        document.getElementById('thang').required = (kieu === 'tuan');
        document.getElementById('nam').required = (kieu === 'tuan');
        document.getElementById('tuan').required = (kieu === 'tuan');
        document.getElementById('ngayDotXuat').required = (kieu === 'ngay');
      });
      </script>
      <script>
        @if (session('notify_messages'))
            @foreach (session('notify_messages') as $notify)
                $.notify({
                    title: '@if ($notify["type"] == "success") Thành công @elseif($notify["type"] == "warning") Cảnh báo @else Thông báo @endif',
                    message: {!! json_encode($notify['message']) !!},
                    icon: 'icon-bell'
                }, {
                    type: '{{ $notify["type"] }}',
                    animate: {
                        enter: 'animated fadeInDown',
                        exit: 'animated fadeOutUp'
                    },
                });
            @endforeach
        @endif
    </script>
      
  @endsection
  
