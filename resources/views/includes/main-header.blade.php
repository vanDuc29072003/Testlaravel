{{-- filepath: c:\laragon\www\DoAn\resources\views\includes\main-header.blade.php --}}
<div id="main-header-container" class="main-header">
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
        <li class="nav-item topbar-icon dropdown hidden-caret">
          <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-bell"></i>
            @if ($chuadocCount >0)
              <span class="notification">{{ $chuadocCount }}</span>
            @endif
          </a>
          <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
            <li>
              <div class="dropdown-title">Thông báo</div>
            </li>
            <li>
              <div class="notif-scroll scrollbar-outer">
                <div class="notif-center">
                    @foreach ($dsThongBao as $tb)
                      <a href="{{ route($tb->Route) }}">
                          @if ($tb->TrangThai == 0)
                            <div class="notif-icon notif-{{ $tb->Loai }} avatar avatar-away flex-shrink-0"> 
                                <i class="{{ $tb->Icon }}"></i> 
                            </div>
                          @else
                            <div class="notif-icon notif-{{ $tb->Loai }} flex-shrink-0"> 
                                <i class="{{ $tb->Icon }}"></i> 
                            </div>
                          @endif
                            <div class="notif-content">
                                <span class="block">{{ $tb->NoiDung }}</span>
                                <span class="time">{{ $tb->created_at->diffForHumans() }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
              </div>
            </li>
          </ul>
        </li>
        <li class="nav-item topbar-icon">
          <a class="nav-link nav-link-icon" href="{{ route('detailuser') }}">
            <i class="fa-solid fa-user-gear"></i>
          </a>
        </li>
        <li class="nav-item topbar-icon">
          <div class="d-flex flex-column align-items-center">
            <b class="ms-2 mt-2">Xin chào, {{ $header_TenNhanVien }}</b>
            <p class="m-0 fst-italic fs-6">{{ $header_TenBoPhan }}</p>
          </div>
        </li>
      </ul>
    </div>
  </nav>
</div>