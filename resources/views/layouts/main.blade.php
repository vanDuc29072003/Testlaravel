{{-- filepath: c:\laragon\www\DoAn\resources\views\layouts\main.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
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
  <!-- Các tệp CSS/JS khác -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/js/bootstrap-notify.min.js"></script>
  <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
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
  <!-- <script src="{{ asset('js/plugin/chart.js/chart.min.js') }}"></script> -->
  <script src="{{ asset('js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>
  <script src="{{ asset('js/plugin/chart-circle/circles.min.js') }}"></script>
  <script src="{{ asset('js/plugin/datatables/datatables.min.js') }}"></script>
  <script src="{{ asset('js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
  <script src="{{ asset('js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
  <script src="{{ asset('js/plugin/jsvectormap/world.js') }}"></script>
  <script src="{{ asset('js/plugin/gmaps/gmaps.js') }}"></script>
  <script src="{{ asset('js/plugin/sweetalert/sweetalert.min.js') }}"></script>
  <script src="{{ asset('js/kaiadmin.min.js') }}"></script>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
    var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
      cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
      authEndpoint: '/broadcasting/auth', // Đường dẫn xác thực của Laravel (mặc định)
      auth: {
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
      }
    });

    pusher.subscribe('private-channel-quanly').bind('eventYeuCauSuaChua', function (data) {
      $.notify({
        icon: 'icon-bell',
        title: 'Thông báo',
        message: data.message,
        url: "{{ route('yeucausuachua.index') }}"
      }, {
        type: 'danger',
        delay: 5000
      });
    });

    pusher.subscribe('private-channel-quanly').bind('eventPhieuNhap', function (data) {
      $.notify({
        icon: 'icon-bell',
        title: 'Thông báo',
        message: data.message,
        url: "{{ route('dsphieunhap') }}"
      }, {
        type: 'danger',
        delay: 5000
      });
    });

    pusher.subscribe('private-channel-quanly').bind('eventPhieuThanhLy', function (data) {
      $.notify({
        icon: 'icon-bell',
        title: 'Thông báo',
        message: data.message,
        url: "{{ route('phieuthanhly.index') }}"
      }, {
        type: 'danger',
        delay: 5000
      });
    });

    pusher.subscribe('private-channel-kythuat').bind('eventDuyetYeuCauSuaChua', function (data) {
      $.notify({
        icon: 'icon-bell',
        title: 'Thông báo',
        message: data.message,
        url: "{{ route('lichsuachua.index') }}"
      }, {
        type: 'danger',
        delay: 5000
      });
    });

    pusher.subscribe('channel-all').bind('eventUpdateUI', function (data) {
      if (data.reload) {
        console.log('Cập nhật giao diện sidebar và main header');
        // Gửi AJAX để load lại sidebar
        $.ajax({
          url: '/sidebar', // Route để lấy nội dung sidebar
          type: 'GET',
          success: function (response) {
            $('#sidebar-container').html(response); // Cập nhật nội dung sidebar
            reloadSidebar();
          },
          error: function () {
            console.error('Lỗi khi load lại sidebar!');
          }
        });

        // Gửi AJAX để load lại main header
        $.ajax({
          url: '/main-header', // Route để lấy nội dung main header
          type: 'GET',
          success: function (response) {
            $('#main-header-container').html(response); // Cập nhật nội dung main header
            reloadMainHeader();
          },
          error: function () {
            console.error('Lỗi khi load lại main header!');
          }
        });

        function reloadSidebar() {
          
        }
        function reloadMainHeader() {
          console.log('Gắn lại sự kiện và khởi tạo plugin Main Header');
          // Khởi tạo lại jQuery Scrollbar (nếu sử dụng)
          if ($.fn.scrollbar) {
            $('.scrollbar-outer').scrollbar(); // Khởi tạo lại thanh cuộn tùy chỉnh
          }
        }
      }
    });
  </script>
  <script>
        @if (session('error'))
            $.notify({
                title: 'Lỗi',
                message: '{{ session('error') }}',
                icon: 'icon-bell'
            }, {
                type: 'danger',
                animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutUp'
                },
            });
        @endif
    </script>
    <script>
        @if (session('success'))
            $.notify({
                title: 'Thành công',
                message: '{{ session('success') }}',
                icon: 'icon-bell'
            }, {
                type: 'success',
                animate: { enter: 'animated fadeInDown', exit: 'animated fadeOutUp' },
            });
        @endif
    </script>
  @yield('scripts')
</body>

</html>