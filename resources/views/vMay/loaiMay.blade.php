@extends('layouts.main')

@section('title', 'Danh Sách Loại Máy')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <!-- Cột trái: Danh sách loại máy -->
                <div class="col-md-9">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h1 class="mb-0">Danh Sách Loại Máy</h1>
                        <a href="{{ route('loaimay.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus"></i> Thêm loại máy
                        </a>
                    </div>

                    <table class="table table-bordered shadow-sm">
                        <thead class="table-light">
                            <tr>
                                <th>STT</th>
                                <th>Mã Loại Máy</th>
                                <th>Tên Loại Máy</th>
                                <th>Mô Tả</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($loaimays as $index => $loai)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $loai->MaLoai }}</td>
                                    <td>{{ $loai->TenLoai }}</td>
                                    <td>{{ $loai->MoTa }}</td>
                                    <td>
                                        <form action="{{ route('loaimay.destroy', ['id' => $loai->MaLoai]) }}" method="POST" style="display:inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')">
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
                <div class="col-md-3">
                    <div class="card shadow-sm" style="margin-top: 60px;">
                        <div class="card-header bg-info text-white fw-bold text-center">
                            Tìm kiếm
                        </div>
                        <div class="card-body">
                            <form action="{{ route('loaimay.index') }}" method="GET">
                                <div class="mb-3">
                                    <label for="search" class="form-label">Tên loại máy</label>
                                    <input type="text" name="search" class="form-control" placeholder="Nhập tên..." value="{{ request('search') }}">
                                </div>
                                <button class="btn btn-primary w-100" type="submit">
                                    <i class="fa fa-search"></i> Tìm
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
