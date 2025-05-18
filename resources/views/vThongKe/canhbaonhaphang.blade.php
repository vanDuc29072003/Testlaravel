@extends('layouts.main')

@section('title', 'Cảnh báo nhập hàng')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-9">
                    <div class="d-flex justify-content-between align-items-center mb-0">
                        <h3 class="mb-0">Cảnh Báo Nhập Hàng</h3>
                        <a href="{{ route('canhbaonhaphang.pdf', request()->all()) }}" class="btn btn-black btn-border"
                        style="color: black;">
                        <i class="fas fa-file-download"></i> Xuất FILE PDF
                         </a>
                    </div>
                    <p class="fst-italic">Màu Đỏ : Cần bổ sung gấp</br> Màu Vàng : Cần có kế hoạch bổ sung </p>
                </div>
                <div class="col-3">
                   
                     <a href="{{ route('thongkekho') }}" class="btn btn-black btn-border">
                            <i class="fas fa-arrow-left"></i> Quay lại thống kê
                        </a>
                </div>
                <div class="col-9">
                    <table class="table table-responsive table-bordered table-striped">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>Mã Linh Kiện</th>
                                <th>Tên Linh Kiện</th>
                                <th>Đơn Vị Tính</th>
                                <th>Số Lượng Tồn</th>
                                <th>Trạng Thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($canhBaoList as $item)
                                @php
                                    $color = 'white';
                                 
                                    if ($item['MucDo'] === 'danger') {
                                        $color = 'red';
                                      
                                    } elseif ($item['MucDo'] === 'warning') {
                                        $color = 'yellow';
                                       
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $item['MaLinhKien'] }}</td>
                                    <td>{{ $item['TenLinhKien'] }}</td>
                                    <td>{{ $item['DVT'] }}</td>
                                    <td class="text-end">{{ $item['SoLuong'] }}</td>
                                    <td class="text-center">
                                        <span class="status-indicator" style="display: inline-block; width: 20px; height: 20px; background-color: {{ $color }}; border: 1px solid #ccc; border-radius: 50%;">
                                          
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Form lọc -->
                <div class="col-3">
                    <form method="GET" class="p-3 border rounded">
                        <h5 class="mb-3">Bộ lọc</h5>
                        <div class="mb-3">
                            <label class="form-label">Sắp xếp</label>
                            <select name="sort" class="form-select">
                                <option value="asc" {{ $sortOrder == 'asc' ? 'selected' : '' }}>Tăng dần</option>
                                <option value="desc" {{ $sortOrder == 'desc' ? 'selected' : '' }}>Giảm dần</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Đơn vị tính</label>
                            <select name="donvi" class="form-select">
                                <option value="">Tất cả ĐVT</option>
                                @foreach($dsDonViTinh as $dvt)
                                    <option value="{{ $dvt }}" {{ $donViFilter == $dvt ? 'selected' : '' }}>{{ $dvt }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Màu cảnh báo</label>
                            <select name="color" class="form-select">
                                <option value="">Tất cả</option>
                                <option value="red" {{ $colorFilter == 'red' ? 'selected' : '' }}>Chỉ đỏ</option>
                                <option value="yellow" {{ $colorFilter == 'yellow' ? 'selected' : '' }}>Chỉ vàng</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tên linh kiện</label>
                            <input type="text" name="name" class="form-control" placeholder="Tìm theo tên" value="{{ $searchName }}">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fa fa-filter"></i> Lọc
                        </button>
                    </form>
                </div>

                
                

            </div>
        </div>
    </div>
@endsection
