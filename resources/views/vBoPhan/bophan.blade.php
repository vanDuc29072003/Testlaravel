@extends('layouts.main')

@section('title', 'Danh Sách Bộ Phận')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <!-- Cột trái: Danh sách bộ phận -->
                <div class="col-md-9">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h1 class="mb-0">Danh Sách Bộ Phận</h1>
                        <a href="{{ route('bophan.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus"></i> Thêm bộ phận
                        </a>
                    </div>

                    <table class="table table-responsive table-bordered table-hover">
                        <thead>
                            <tr class="text-center">
                                <th>Mã Bộ Phận</th>
                                <th>Tên Bộ Phận</th>
                                <th>Số lượng nhân viên</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($bophans as $index => $bophan)
                                <tr class="text-center">
                                    <td>{{ $bophan->MaBoPhan }}</td>
                                    <td class="text-start">{{ $bophan->TenBoPhan }}</td>
                                    <td>{{ $bophan->active_nhanvien_count  }}</td>
                                    <td>
                                        <form action="{{ route('bophan.destroy', ['id' => $bophan->MaBoPhan]) }}" method="POST"
                                              class="d-inline-block">
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
                                    <td colspan="5" class="text-center text-muted">Không tìm thấy bộ phận nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Cột phải: Tìm kiếm -->
                <div class="col-md-3">
                    <div class="p-3 border rounded fixed-search-form" style="margin-top: 60px;">
                        <div class="card-body">
                            <h5 class="mb-3">Tìm kiếm</h5>
                            <form action="{{ route('bophan.index') }}" method="GET">
                                <div class="mb-3">
                                    <label for="search" class="form-label">Tên bộ phận</label>
                                    <input type="text" name="search" class="form-control" placeholder="Nhập tên..." value="{{ request('search') }}">
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
    <script>
        @if (session('error'))
            $.notify({
                title: 'Lỗi',
                message: '{{ session('error') }}',
                icon: 'icon-bell'
            }, {
                type: 'danger',
                animate: { enter: 'animated fadeInDown', exit: 'animated fadeOutUp' },
            });
        @endif
    </script>
@endsection
