
{{-- filepath: c:\laragon\www\DoAn\resources\views\includes\main-header.blade.php --}}
<head>
  <script src="{{ asset('js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
  <!-- Các tệp CSS/JS khác -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/js/bootstrap-notify.min.js"></script>
</head>
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
            <a class="nav-link nav-link-icon" href="#">
              <i class="fa-solid fa-user-gear"></i>
            </a>
          </li>
          <li class="nav-item topbar-icon">
            <b class="ms-2">Xin chào, ABC</b>
          </li>
        </ul>
      </div>
    </nav>
  </div>