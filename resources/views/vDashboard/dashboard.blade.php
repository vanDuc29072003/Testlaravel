@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div id="dashboard-count" class="row">
                <div class="col-sm-6 col-md-4 col-xxl-2">
                    <a href="{{ route('lichvanhanh') }}">
                        <div class="card card-stats card-round">
                            <div class="card-body ">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center icon-black bubble-shadow-small">
                                            <i class="fa-solid fa-clipboard-list"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ms-3 ms-sm-0">
                                        <div class="numbers">
                                            <p class="card-category">Lịch vận hành</p>
                                            <h4 class="card-title">{{ $lichvanhanh->count() }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-md-4 col-xxl-2">
                    <a href="{{ route('lichbaotri') }}">
                        <div class="card card-stats card-round">
                            <div class="card-body ">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center icon-black bubble-shadow-small">
                                            <i class="fa-solid fa-calendar-alt"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ms-3 ms-sm-0">
                                        <div class="numbers">
                                            <p class="card-category">Lịch bảo trì</p>
                                            <h4 class="card-title">{{ $lichbaotri->count() }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-md-4 col-xxl-2">
                    <a href="{{ route('lichsuachua.index') }}">
                        <div class="card card-stats card-round">
                            <div class="card-body ">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center icon-black bubble-shadow-small">
                                            <i class="fa-solid fa-wrench"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ms-3 ms-sm-0">
                                        <div class="numbers">
                                            <p class="card-category">Lịch sửa chữa</p>
                                            <h4 class="card-title">{{ $count_lichsc }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-md-4 col-xxl-2">
                    <a href="{{ route('yeucausuachua.index') }}">
                        <div class="card card-stats card-round">
                            <div class="card-body ">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center icon-black bubble-shadow-small">
                                            <i class="fa-solid fa-hammer"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ms-3 ms-sm-0">
                                        <div class="numbers">
                                            <p class="card-category">YC sửa chữa</p>
                                            <h4 class="card-title">{{ $count_ycsc }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-md-4 col-xxl-2">
                    <a href="{{ route('dsphieunhap') }}">
                        <div class="card card-stats card-round">
                            <div class="card-body ">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center icon-black bubble-shadow-small">
                                            <i class="fas fa-cubes"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ms-3 ms-sm-0">
                                        <div class="numbers">
                                            <p class="card-category">Phiếu nhập kho</p>
                                            <h4 class="card-title">{{ $phieunhap->count() }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-md-4 col-xxl-2">
                    <a href="{{ route('phieuthanhly.index') }}">
                        <div class="card card-stats card-round">
                            <div class="card-body ">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center icon-black bubble-shadow-small">
                                            <i class="fas fa-recycle"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ms-3 ms-sm-0">
                                        <div class="numbers">
                                            <p class="card-category">Phiếu thanh lý</p>
                                            <h4 class="card-title">{{ $phieuthanhly->count() }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    @if($lichbaotri->count() > 0)
                        <a href="{{ route('lichbaotri') }}">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-head-row">
                                        <i class="fas fa-exclamation-triangle me-2 text-warning"></i>
                                        <div class="card-title">Máy sắp tới hạn bảo trì</div>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <!-- Projects table -->
                                        <table class="table align-items-center mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">Ngày bảo trì</th>
                                                    <th scope="col">Mã máy</th>
                                                    <th scope="col">Tên máy</th>
                                                    <th scope="col">Nhà cung cấp</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($lichbaotri as $lich)
                                                    <tr class="table-warning" onclick="window.location='{{ route('lichbaotri') }}'"
                                                        style="cursor: pointer;">
                                                        <td>{{ \Carbon\Carbon::parse($lich->NgayBaoTri)->format('d/m/Y') }}</td>
                                                        <td>{{ $lich->may->MaMay2 ?? $lich->may->MaMay }}</td>
                                                        <td>{{ $lich->may->TenMay }}</td>
                                                        <td>{{ $lich->may->nhaCungCap->TenNhaCungCap ?? 'Không xác định' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endif
                    <!-- sơ đồ yêu cầu sửa chữa -->
                    <div class="card">
                        <div class="card-header">
                            <div class="card-head-row">
                                <div class="card-title">Yêu cầu sửa chữa</div>
                                <div class="card-tools">
                                    <ul class="nav nav-pills nav-black nav-pills-no-bd nav-sm" id="pills-tab"
                                        role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="pills-today" data-bs-toggle="pill"
                                                href="#pills-today" role="tab" aria-selected="true">7 ngày</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="pills-week" data-bs-toggle="pill" href="#pills-week"
                                                role="tab" aria-selected="false">30 ngày</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="ChartYCSC" height="100"></canvas>
                            </div>
                        </div>
                    </div>
                    <!-- sơ đồ chi phí -->
                    <div class="card">
                        <div class="card-header">
                            <div class="card-head-row">
                                <div class="card-title">Chi phí</div>
                                <div class="card-tools">
                                    <ul class="nav nav-pills nav-black nav-pills-no-bd nav-sm" id="pills-tab"
                                        role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="chiphi-this-month" data-bs-toggle="pill"
                                                href="#chiphi-this-month" role="tab" aria-selected="true">Tháng này</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="chiphi-last-month" data-bs-toggle="pill"
                                                href="#chiphi-last-month" role="tab" aria-selected="false">Tháng trước</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="chiphi-6months" data-bs-toggle="pill"
                                                href="#chiphi-6months" role="tab" aria-selected="false">6 tháng</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="ChartChiPhi" height="100"></canvas>
                            </div>
                        </div>
                    </div>
                    <!-- Máy sắp hết hạn bảo hành -->
                    @if ($mayHetBaoHanh->count() > 0)
                        <div class="card">
                            <div class="card-header">
                                <div class="card-head-row">
                                    <i class="fas fa-exclamation-triangle me-2 text-warning"></i>
                                    <div class="card-title">Máy sắp hết hạn bảo hành</div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <!-- Projects table -->
                                    <table class="table align-items-center mb-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">Mã máy</th>
                                                <th scope="col">Tên máy</th>
                                                <th scope="col">Ngày đưa vào sử dụng</th>
                                                <th scope="col">Thời gian bảo hành</th>
                                                <th scope="col">Ngày hết bảo hành</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($mayHetBaoHanh as $may)
                                                <tr onclick="window.location='{{ route('may.detail', $may->MaMay) }}'"
                                                    style="cursor: pointer;">
                                                    <td>{{ $may->MaMay2 ?? $may->MaMay }}</td>
                                                    <td>{{ $may->TenMay }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($may->ThoiGianDuaVaoSuDung)->format('d/m/Y') }}</td>
                                                    <td>{{ $may->ThoiGianBaoHanh }} tháng</td>
                                                    <td>{{ \Carbon\Carbon::parse($may->ThoiGianDuaVaoSuDung)->addMonths($may->ThoiGianBaoHanh)->format('d/m/Y') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($maySapHetKhauHao->count() > 0)
                        <div class="card">
                            <div class="card-header">
                                <div class="card-head-row">
                                    <i class="fas fa-exclamation-triangle me-2 text-warning"></i>
                                    <div class="card-title">Máy sắp hết hạn khấu hao</div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <!-- Projects table -->
                                    <table class="table align-items-center mb-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">Mã máy</th>
                                                <th scope="col">Tên máy</th>
                                                <th scope="col">Ngày đưa vào sử dụng</th>
                                                <th scope="col">Thời gian khấu hao</th>
                                                <th scope="col">Ngày hết khấu hao</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($maySapHetKhauHao as $mshkh)
                                                <tr class="table-warning" onclick="window.location='{{ route('may.detail', $mshkh->MaMay) }}'"
                                                    style="cursor: pointer;">
                                                    <td>{{ $mshkh->MaMay2 }}</td>
                                                    <td>{{ $mshkh->TenMay }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($mshkh->ThoiGianDuaVaoSuDung)->format('d/m/Y') }}</td>
                                                    <td>{{ $mshkh->ThoiGianKhauHao }} năm</td>
                                                    <td>{{ \Carbon\Carbon::parse($mshkh->ThoiGianDuaVaoSuDung)->addYears($mshkh->ThoiGianKhauHao)->format('d/m/Y') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($mayDaHetKhauHao->count() > 0)
                        <div class="card">
                            <div class="card-header">
                                <div class="card-head-row">
                                    <i class="fas fa-exclamation-triangle me-2 text-danger"></i>
                                    <div class="card-title">Máy đã hết hạn khấu hao</div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <!-- Projects table -->
                                    <table class="table align-items-center mb-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">Mã máy</th>
                                                <th scope="col">Tên máy</th>
                                                <th scope="col">Ngày đưa vào sử dụng</th>
                                                <th scope="col">Thời gian khấu hao</th>
                                                <th scope="col">Ngày hết khấu hao</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($mayDaHetKhauHao as $mdhkh)
                                                <tr class="table-danger" onclick="window.location='{{ route('may.detail', $mdhkh->MaMay) }}'"
                                                    style="cursor: pointer;">
                                                    <td>{{ $mdhkh->MaMay2 }}</td>
                                                    <td>{{ $mdhkh->TenMay }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($mdhkh->ThoiGianDuaVaoSuDung)->format('d/m/Y') }}</td>
                                                    <td>{{ $mdhkh->ThoiGianKhauHao }} năm</td>
                                                    <td>{{ \Carbon\Carbon::parse($mdhkh->ThoiGianDuaVaoSuDung)->addYears($mdhkh->ThoiGianKhauHao)->format('d/m/Y') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-md-4">
                    <div id="dashboard-thongbao" class="card">
                        <div class="card-header">
                            <div class="card-head-row">
                                <div class="card-title">Thông báo gần đây</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <ol class="activity-feed">
                                @foreach($dsThongBao as $tb)
                                    <li class="feed-item feed-item-{{ $tb->Loai }}">
                                        <time class="date" datetime="{{ $tb->created_at->format('Y-m-d') }}">
                                            {{ $tb->created_at->format('H:i d/m/Y') }}
                                        </time>
                                        <a class="text-black" href="{{ route($tb->Route) }}">
                                            <span class="text">{!! $tb->NoiDung !!}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                    <div class="card">
                        <a href="{{ route('canhbaonhaphang') }}">
                            <div class="card-header">
                                <div class="card-head-row">
                                    <i class="fas fa-exclamation-circle me-2 text-danger"></i>
                                    <div class="card-title">Cảnh báo hạn mức linh kiện</div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <!-- Projects table -->
                                    <table class="table align-items-center mb-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">Tên linh kiện</th>
                                                <th scope="col" class="text-center">Số lượng</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($linhkienCanhBao as $lk)
                                                <tr class="table-danger">
                                                    <td>{{ $lk->TenLinhKien }}</td>
                                                    <td class="text-center"><strong>{{ $lk->SoLuong }}</strong></td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted">Không có linh kiện nào dưới hạn
                                                        mức.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const ycscData = {!! json_encode($ycscData) !!};

        const ctx = document.getElementById('ChartYCSC').getContext('2d');
        const ycscChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ycscData['7ngay'].labels,
                datasets: [{
                    label: 'Yêu cầu sửa chữa',
                    data: ycscData['7ngay'].data,
                    backgroundColor: 'rgb(63, 81, 181)',
                    borderColor: 'rgb(63, 81, 181)',
                    pointBackgroundColor: 'rgb(255, 193, 7)',
                    pointRadius: 5,
                    tension: 0,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    tooltip: { mode: 'index', intersect: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Sự kiện click tab
        document.getElementById('pills-today').addEventListener('click', function (e) {
            e.preventDefault();
            ycscChart.data.labels = ycscData['7ngay'].labels;
            ycscChart.data.datasets[0].data = ycscData['7ngay'].data;
            ycscChart.update();
            this.classList.add('active');
            document.getElementById('pills-week').classList.remove('active');
        });
        document.getElementById('pills-week').addEventListener('click', function (e) {
            e.preventDefault();
            ycscChart.data.labels = ycscData['30ngay'].labels;
            ycscChart.data.datasets[0].data = ycscData['30ngay'].data;
            ycscChart.update();
            this.classList.add('active');
            document.getElementById('pills-today').classList.remove('active');
        });
    </script>
    <script>
        const costData = {!! json_encode($costData) !!};

        const ctxCost = document.getElementById('ChartChiPhi').getContext('2d');
        const costBarChart = new Chart(ctxCost, {
            type: 'bar',
            data: {
                labels: costData.thisMonth.labels,
                datasets: [
                    {
                        label: 'Nhập kho',
                        data: costData.thisMonth.nhapKho,
                        backgroundColor: 'rgb(63, 81, 181)',
                        borderColor: 'rgb(48, 63, 159)',
                        borderWidth: 1
                    },
                    {
                        label: 'Bảo trì',
                        data: costData.thisMonth.baoTri,
                        backgroundColor: 'rgb(255, 193, 7)',
                        borderColor: 'rgb(255, 160, 0)',
                        borderWidth: 1
                    },
                    {
                        label: 'Sửa chữa',
                        data: costData.thisMonth.suaChua,
                        backgroundColor: 'rgb(244, 67, 54)',
                        borderColor: 'rgb(211, 47, 47)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    tooltip: { mode: 'index', intersect: false }
                },
                scales: {
                    x: { stacked: true, },
                    y: { stacked: true, beginAtZero: true, }
                }
            }
        });

        // Tab click event
        document.getElementById('chiphi-this-month').addEventListener('click', function (e) {
            e.preventDefault();
            costBarChart.data.labels = costData.thisMonth.labels;
            costBarChart.data.datasets[0].data = costData.thisMonth.nhapKho;
            costBarChart.data.datasets[1].data = costData.thisMonth.baoTri;
            costBarChart.data.datasets[2].data = costData.thisMonth.suaChua;
            costBarChart.update();
            this.classList.add('active');
            document.getElementById('chiphi-last-month').classList.remove('active');
            document.getElementById('chiphi-6months').classList.remove('active');
        });
        document.getElementById('chiphi-last-month').addEventListener('click', function (e) {
            e.preventDefault();
            costBarChart.data.labels = costData.lastMonth.labels;
            costBarChart.data.datasets[0].data = costData.lastMonth.nhapKho;
            costBarChart.data.datasets[1].data = costData.lastMonth.baoTri;
            costBarChart.data.datasets[2].data = costData.lastMonth.suaChua;
            costBarChart.update();
            this.classList.add('active');
            document.getElementById('chiphi-this-month').classList.remove('active');
            document.getElementById('chiphi-6months').classList.remove('active');
        });
        document.getElementById('chiphi-6months').addEventListener('click', function (e) {
            e.preventDefault();
            costBarChart.data.labels = costData.sixMonths.labels;
            costBarChart.data.datasets[0].data = costData.sixMonths.nhapKho;
            costBarChart.data.datasets[1].data = costData.sixMonths.baoTri;
            costBarChart.data.datasets[2].data = costData.sixMonths.suaChua;
            costBarChart.update();
            this.classList.add('active');
            document.getElementById('chiphi-this-month').classList.remove('active');
            document.getElementById('chiphi-last-month').classList.remove('active');
        });
    </script>
    <script>
        pusher.subscribe('channel-all').bind('eventUpdateUI', function (data) {
            if (data.reload) {
                console.log('Có cập nhật mới');

                $.ajax({
                    url: window.location.href,
                    type: 'GET',

                    success: function (response) {
                        const newCount = $(response).find('#dashboard-count').html();
                        const newThongBao = $(response).find('#dashboard-thongbao').html();

                        $('#dashboard-count').html(newCount);
                        $('#dashboard-thongbao').html(newThongBao);
                    },
                    error: function () {
                        console.error('Lỗi khi load lại bảng!');
                    }
                });
            }
        })
    </script>
    
@endsection