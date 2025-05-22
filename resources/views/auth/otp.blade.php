<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Xác thực OTP</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/x-icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Các tệp CSS/JS khác -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/js/bootstrap-notify.min.js"></script>

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

<body>
    <div class="wrapper">
        <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
            <div class="card w-auto">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="{{ asset('img/logo.png') }}" alt="logo" height="60">
                        <h3 class="mt-2">Xác minh OTP</h3>
                        <p class="text-muted">Vui lòng nhập mã OTP đã gửi đến email của bạn.</p>
                    </div>

                    <form method="POST" action="{{ route('otp.verify') }}">
                        @csrf
                        <div class="form-group">
                            <label for="otp_code">Mã OTP</label>
                            <input type="text" class="form-control" name="otp_code" id="otp_code" placeholder="Nhập mã OTP" required maxlength="6" minlength="6">
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary mt-3">Xác minh</button>
                        </div>
                    </form>
                    <div class="text-center mt-0">
                        <form method="POST" action="{{ route('otp.resend') }}">
                            @csrf
                            <input type="hidden" name="TenTaiKhoan" value="{{ old('TenTaiKhoan', session('TenTaiKhoan')) }}">
                            <button type="submit" class="btn btn-link">Gửi lại mã OTP</button>
                        </form>
                    </div>
                </div>
            </div>
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

        @if (session('success'))
            $.notify({
                title: 'Thành công',
                message: '{{ session('success') }}',
                icon: 'icon-bell'
            }, {
                type: 'success',
                animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutUp'
                },
            });
        @endif
    </script>
</body>

</html>
