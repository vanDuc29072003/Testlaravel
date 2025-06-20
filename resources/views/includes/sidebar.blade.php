<div id="sidebar-container" class="sidebar" data-background-color="dark">
  <div class="sidebar-logo">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="dark">
      <a href="{{ route('dashboard.index') }}" class="logo">
        <img src="{{ asset('img/logo.png') }}" alt="navbar brand" class="navbar-brand" height="50" />
      </a>
      <div class="nav-toggle">
        <button class="btn btn-toggle toggle-sidebar">
          <i class="gg-menu-right"></i>
        </button>
        <button class="btn btn-toggle sidenav-toggler">
          <i class="gg-menu-left"></i>
        </button>
      </div>
      <button class="topbar-toggler more">
        <i class="gg-more-vertical-alt"></i>
      </button>
    </div>
    <!-- End Logo Header -->
  </div>
  <div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
      <ul class="nav nav-secondary">
        <li class="nav-item ">
          <a href="{{ route('dashboard.index') }}" class="collapsed" aria-expanded="false">
            <i class="fas fa-home"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section">Chức năng</h4>
        </li>
        <li class="nav-item ">
          <a data-bs-toggle="collapse" href="#phancong">
            <i class="fa-solid fa-calendar-days"></i>
            <p>Phân công</p>
            @if ($count_lichsc + $count_lichbt > 0)
              <span class="badge">{{ $count_lichsc + $count_lichbt }}</span>
            @else
              <span class="caret"></span>
            @endif
          </a>
          <div class="collapse" id="phancong">
            <ul class="nav nav-collapse">
              <li>
                <a href="{{ route('lichvanhanh') }}">
                  <span class="sub-item">Lịch vận hành</span>
                  
                </a>
              </li>
              <li>
                <a href="{{ route('lichbaotri') }}">
                  <span class="sub-item">Lịch bảo trì</span>
                  @if ($count_lichbt > 0)
                    <span class="badge">{{ $count_lichbt }}</span>
                  @endif
                </a>
              </li>
              <li>
                <a href="{{ route('lichsuachua.index') }}">
                  <span class="sub-item">Lịch sửa chữa</span>
                  @if($count_lichsc > 0)
                    <span class="badge">{{ $count_lichsc }}</span>
                  @endif
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item ">
          <a data-bs-toggle="collapse" href="#lichsu">
            <i class="fa-solid fa-clock-rotate-left"></i>
            <p>Lịch sử</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="lichsu">
            <ul class="nav nav-collapse">
              <li>
                <a href="{{ route('nhatki.thongke') }}">
                  <span class="sub-item">Nhật kí vận hành</span>
                </a>
               </li>
              <li>
                <a href="{{ route('lichbaotri.dabangiao') }}">
                  <span class="sub-item">Lịch sử bảo trì</span>
                </a>
              </li>
              <li>
                <a href="{{ route('lichsuachua.dahoanthanh') }}">
                  <span class="sub-item">Lịch sử sửa chữa</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item ">
          <a href="{{ route('yeucausuachua.index') }}" class="collapsed" aria-expanded="false">
            <i class="fa-solid fa-hammer"></i>
            <p>Yêu cầu sửa chữa</p>
            @if ($count_ycsc > 0)
              <span class="badge">{{ $count_ycsc }}</span>
            @endif
          </a>
        </li>
        
        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#submenu">
            <i class="fa-solid fa-clipboard-list"></i>
            <p>Lập phiếu</p>
            @if(($count_phieunhap + $count_phieuthanhly) > 0)
              <span class="badge">{{ $count_phieunhap + $count_phieuthanhly }}</span>
            @else
              <span class="caret"></span>
            @endif
          </a>
          <div class="collapse" id="submenu">
            <ul class="nav nav-collapse">
              <li>
                <a href="{{ route('dsphieunhap') }}">
                  <span class="sub-item">Phiếu nhập kho</span>
                  @if($count_phieunhap > 0)
                    <span class="badge">{{ $count_phieunhap }}</span>
                  @endif
                </a>

              </li>
              <li>
                <a href="{{ route('dsphieuxuat') }}">
                  <span class="sub-item">Phiếu xuất kho</span>
                </a>
              </li>
              <li>
                <a href="{{ route('dsphieutra') }}">
                  <span class="sub-item">Phiếu trả kho</span>
                </a>

              </li>
              <li>
                <a href="{{ route('phieuthanhly.index') }}">
                  <span class="sub-item">Phiếu thanh lý</span>
                  @if($count_phieuthanhly > 0)
                    <span class="badge">{{ $count_phieuthanhly }}</span>
                  @endif
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item ">
          <a data-bs-toggle="collapse" href="#baocao">
            <i class="fa-solid fa-chart-line"></i>
            <p>Báo cáo & Thống kê</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="baocao">
            <ul class="nav nav-collapse">
              
               <li>
                <a href="{{ route('thongkesuachua') }}">
                  <span class="sub-item">Sửa chữa & Bảo Trì</span>
                </a>
              </li>
              <li>
                <a href="{{ route('thongkelinhkienxuat') }}">
                  <span class="sub-item">Thống kê linh kiện xuất kho</span>
                </a>
              </li>
              <li>
                <a href="{{ route('thongkekho') }}">
                  <span class="sub-item">Báo cáo kiểm kho</span>
                </a>
              </li>
            </ul>
              
            
          </div>
        </li>

        <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section">Danh mục</h4>
        </li>
        <li class="nav-item ">
          <a data-bs-toggle="collapse" href="#may">
            <i class="fa-solid fa-sliders"></i>
            <p>Danh mục máy</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="may">
            <ul class="nav nav-collapse">
              <li>
                <a href="{{route('loaimay.index')}}">
                  <span class="sub-item">Danh sách loại máy</span>
                </a>
              </li>
              <li>
                <a href="{{route('may')}}">
                  <span class="sub-item">Danh sách máy</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a href="{{ route('linhkien') }}">
            <i class="fa-solid fa-gears"></i>
            <p>Danh mục linh kiện</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('donvitinh.index') }}">
            <i class="fas fa-superscript"></i>
            <p>Danh mục đơn vị tính</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('nhacungcap') }}">
            <i class="fas fa-shipping-fast"></i>
            <p>Danh mục nhà cung cấp</p>
          </a>
        </li>
        <li class="nav-item ">
          <a data-bs-toggle="collapse" href="#admin">
            <i class="fa-solid fa-users"></i>
            <p>Quản trị viên</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="admin">
            <ul class="nav nav-collapse">
              <li>
                <a href="{{ route('bophan.index') }}">
                  <span class="sub-item">Danh sách bộ phận</span>
                </a>
              </li>
              <li>
                <a href="{{ route('taikhoan.index') }}">
                  <span class="sub-item">Danh sách tài khoản</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section">Đăng xuất</h4>
        </li>
        <li class="nav-item" style="cursor: pointer;">
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
          <a class="collapsed" aria-expanded="false"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fa fa-sign-out-alt"></i>
            <p>Đăng xuất</p>
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>