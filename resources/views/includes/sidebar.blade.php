<div class="sidebar" data-background-color="dark">
  <div class="sidebar-logo">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="dark">
      <a href="index.php" class="logo">
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
          <a href="index.php" class="collapsed" aria-expanded="false">
            <i class="fas fa-home"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-item ">
          <a data-bs-toggle="collapse" href="#phancong">
            <i class="fa-solid fa-calendar-days"></i>
            <p>Phân công</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="phancong">
            <ul class="nav nav-collapse">
              <li>
                <a href="{{ route('lichvanhanh') }}">
                  <span class="sub-item">Lịch vận hành</span>
                </a>
              </li>
              <li>
                <a href="lichbaotri.html">
                  <span class="sub-item">Lịch bảo trì</span>
                </a>
              </li>
              <li>
                <a href="{{ route('lichsuachua') }}">
                  <span class="sub-item">Lịch sửa chữa</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item ">
          <a href="yeucau.html" class="collapsed" aria-expanded="false">
            <i class="fa-solid fa-hammer"></i>
            <p>Yêu cầu sửa chữa</p>
          </a>
        </li>
        <li class="nav-item ">
          <a href="may.php" class="collapsed" aria-expanded="false">
            <i class="fa-solid fa-sliders"></i>
            <p>Danh sách máy</p>
          </a>
        </li>
        <li class="nav-item ">
          <a href="linhkien.php" class="collapsed" aria-expanded="false">
            <i class="fa-solid fa-gears"></i>
            <p>Danh sách linh kiện</p>
          </a>
        </li>
        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#submenu">
            <i class="fa-solid fa-clipboard-list"></i>
            <p>Lập phiếu</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="submenu">
            <ul class="nav nav-collapse">
              <li>
                <a href="phieubangiao.html">
                  <span class="sub-item">Phiếu bàn giao</span>
                </a>

              </li>
              <li>
                <a href="phieunhap.html">
                  <span class="sub-item">Phiếu nhập kho</span>
                </a>

              </li>
              <li>
                <a href="phieuxuat.html">
                  <span class="sub-item">Phiếu xuất kho</span>
                </a>
              </li>
            </ul>
          </div>
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
                <a href="taikhoan.html">
                  <span class="sub-item">Danh sách tài khoản</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item ">
          <a href="logout.php" class="collapsed" aria-expanded="false">
            <i class="fa-solid fa-right-from-bracket"></i>
            <p>Đăng xuất</p>
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>