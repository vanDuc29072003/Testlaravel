{{-- filepath: c:\laragon\www\DoAn\resources\views\includes\main-header.blade.php --}}
<div class="main-header">
  <div class="main-header-logo">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="dark">

      <a href="index.html" class="logo">
        <img src="{{ asset('img/logo.png') }}" alt="navbar brand" class="navbar-brand" height="20">
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
  <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
    <div class="container-fluid">
      <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
        <li class="nav-item topbar-icon">
          <a class="nav-link nav-link-icon" href="#">
            <i class="fa-solid fa-envelope-open">
              <span class="notification">4</span>
            </i>
          </a>
        </li>
        <li class="nav-item topbar-icon">
          <a class="nav-link nav-link-icon" href="{{ route('detailuser') }}">
            <i class="fa-solid fa-user-gear"></i>
          </a>
        </li>
        <li class="nav-item topbar-icon">
          {{-- Hiển thị tên người dùng đã đăng nhập --}}
          <b class="ms-2">Xin chào, {{ Auth::user()->nhanvien->TenNhanVien }}</b>
        </li>
      </ul>
    </div>
  </nav>
</div>