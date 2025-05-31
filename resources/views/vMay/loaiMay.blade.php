@extends('layouts.main')

@section('title', 'Danh Sách Loại Máy')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <!-- Cột trái: Danh sách loại máy -->
                <div class="col-md-9 col-sm-12">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h1 class="mb-0">Danh sách Loại máy</h1>
                        <a href="{{ route('loaimay.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus"></i> Thêm loại máy
                        </a>
                    </div>

                    <table class="table table-responsive table-bordered table-hover text-center">
                        <thead>
                            <tr>
                                <th>Mã Loại Máy</th>
                                <th>Tên Loại Máy</th>
                                <th>Viết tắt</th>
                                <th>Tổng số lượng máy</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($loaimays as $index => $loai)
                                <tr>
                                    <td>{{ $loai->MaLoai }}</td>
                                    <td class="text-start">{{ $loai->TenLoai }}</td>
                                    <td>{{ $loai->MoTa }}</td>
                                    <td>{{ $loai->mays_count }}</td>
                                    <td>
                                        <form action="{{ route('loaimay.destroy', ['id' => $loai->MaLoai]) }}" method="POST"
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
                                    <td colspan="5" class="text-center text-muted">Không tìm thấy loại máy nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Cột phải: Tìm kiếm -->
                <div class="col-md-3 col-sm-12">
                    <div>
                        <form action="{{ route('loaimay.index') }}" method="GET"
                            class="p-3 border rounded fixed-search-form" style="margin-top: 60px;">
                            <h5 class="mb-3">Tìm kiếm</h5>
                            <div class="mb-3">
                                <label for="search" class="form-label">Tên loại máy</label>
                                <input type="text" name="search" class="form-control" placeholder="Nhập tên..."
                                    value="{{ request('search') }}">
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