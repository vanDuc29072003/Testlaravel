@extends('layouts.main')

@section('title', 'Danh sách Đơn vị tính')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-9">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h1 class="mb-0">Danh sách Đơn vị tính</h1>
                        <a href="{{ route('donvitinh.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus"></i> Thêm Đơn vị tính
                        </a>
                    </div>

                    <table class="table table-responsive table-bordered table-hover">
                        <thead>
                            <tr class="text-center">
                                <th>Mã đơn vị tính</th>
                                <th>Tên Đơn vị tính</th>
                                <th>Số lượng linh kiện</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dsDonvitinh as $dvt)
                                <tr class="text-center">
                                    <td>{{ $dvt->MaDonViTinh }}</td>
                                    <td>{{ $dvt->TenDonViTinh }}</td>
                                    <td>{{ $dvt->linh_kiens_sum_so_luong ?? 0 }}</td>

                                    <td>
                                        <form action="{{ route('donvitinh.destroy', ['MaDonViTinh' => $dvt->MaDonViTinh]) }}"
                                            method="POST" class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="event.stopPropagation(); confirmDelete(this)">
                                                <i class="fa fa-trash"></i> Xóa
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Không tìm thấy Đơn vị tính nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot aria-label="Page navigation example">
                            <nav>
                                {{ $dsDonvitinh->appends(request()->query())->links('pagination::bootstrap-5') }}
                            </nav>
                        </tfoot>
                    </table>
                </div>

                <!-- Cột phải: Tìm kiếm -->
                <div class="col-md-3">
                    <div class="p-3 border rounded fixed-search-form" style="margin-top: 60px;">
                        <div class="card-body">
                            <h5 class="mb-3">Tìm kiếm</h5>
                            <form action="{{ route('donvitinh.index') }}" method="GET">
                                <div class="mb-3">
                                    <label for="TenDonViTinh" class="form-label">Tên Đơn vị tính</label>
                                    <input type="text" name="TenDonViTinh" class="form-control" placeholder="Vui lòng nhập..."
                                        value="{{ request('TenDonViTinh') }}">
                                </div>
                                <button class="btn btn-primary w-100" type="submit">
                                    <i class="fa fa-search"></i> Tìm kiếm
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function confirmDelete(button) {
            swal({
                title: 'Bạn có chắc chắn?',
                text: "Hành động này không thể hoàn tác!",
                icon: 'warning',
                buttons: {
                    confirm: { text: 'Xóa', className: 'btn btn-danger' },
                    cancel: { text: 'Hủy', visible: true, className: 'btn btn-success' }
                }
            }).then((willDelete) => {
                if (willDelete) {
                    button.closest('form').submit();
                } else {
                    swal.close();
                }
            });
        }
    </script>
  
    
@endsection