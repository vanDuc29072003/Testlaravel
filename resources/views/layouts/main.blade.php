{{-- filepath: c:\laragon\www\DoAn\resources\views\layouts\main.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Các tệp CSS/JS khác -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/js/bootstrap-notify.min.js"></script>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
  <title>@yield('title', 'CTY TNHH IN T.KHOA')</title>
  <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/x-icon" />

  <!-- Fonts and icons -->
  <script src="{{ asset('js/plugin/webfont/webfont.min.js') }}"></script>
  <script>
    WebFont.load({
      google: { families: ["Public Sans:300,400,500,600,700"] },
      custom: {
        families: [
          "Font Awesome 5 Solid",
          "Font Awesome 5 Regular",
          "Font Awesome 5 Brands",
          "simple-line-icons",
        ],
        urls: ["{{ asset('css/fonts.min.css') }}"],
      },
      active: function () {
        sessionStorage.fonts = true;
      },
    });
  </script>

  <!-- CSS Files -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/plugins.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/kaiadmin.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/demo.css') }}">
</head>

<body style="zoom: 0.85;">
  <div class="wrapper">
    <!-- Sidebar -->
    @include('includes.sidebar')
    <!-- End Sidebar -->

    <div class="main-panel">
      <!-- Main Header -->
      @include('includes.main-header')
      <!-- End Main Header -->

      <!-- Main Content -->
      @yield('content')
      <!-- End Main Content -->
    </div>
  </div>

  <!-- Core JS Files -->
  <script src="{{ asset('js/core/jquery-3.7.1.min.js') }}"></script>
  <script src="{{ asset('js/core/popper.min.js') }}"></script>
  <script src="{{ asset('js/core/bootstrap.min.js') }}"></script>

  <!-- Plugins -->
  <script src="{{ asset('js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
  <script src="{{ asset('js/plugin/chart.js/chart.min.js') }}"></script>
  <script src="{{ asset('js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>
  <script src="{{ asset('js/plugin/chart-circle/circles.min.js') }}"></script>
  <script src="{{ asset('js/plugin/datatables/datatables.min.js') }}"></script>
  <script src="{{ asset('js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
  <script src="{{ asset('js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
  <script src="{{ asset('js/plugin/jsvectormap/world.js') }}"></script>
  <script src="{{ asset('js/plugin/gmaps/gmaps.js') }}"></script>
  <script src="{{ asset('js/plugin/sweetalert/sweetalert.min.js') }}"></script>
  <script src="{{ asset('js/kaiadmin.min.js') }}"></script>

  @yield('scripts')
</body>

</html>