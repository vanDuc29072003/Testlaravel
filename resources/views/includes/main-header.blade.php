
{{-- filepath: c:\laragon\www\DoAn\resources\views\includes\main-header.blade.php --}}
<div class="main-header">
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
            <a class="nav-link nav-link-icon" 
              href="{{ route('detailuser') }}">
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