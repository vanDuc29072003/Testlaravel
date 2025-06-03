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
    <title>CTY TNHH IN T.KHOA</title>
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

<body>
    <div class="wrapper">
        <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
            <div class="card w-auto">
                <div class="row">
                    <div class="col-6">
                        <img src="{{ asset('img/login-img.jpg') }}" alt="anh" class="img-fluid"
                            style="border-radius: 1rem;height: 65vh;" />
                    </div>
                    <div class="col-6 d-flex justify-content-center align-items-center">
                        <div>
                            <div class="card-header d-flex justify-content-center align-items-center">
                                <img src="{{ asset('img/logo.png') }}" alt="navbar brand" class="navbar-brand m-3"
                                    height="40" />
                                <h1 class="card-title">Đăng Nhập</h1>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf <!-- Thêm CSRF token -->
                                    <div class="form-group">
                                        <label for="MaNhanVien">Nhập tên tài khoản</label>
                                        <input type="text" name="TenTaiKhoan" id="TenTaiKhoan" class="form-control"
                                            placeholder="Nhập tên tài khoản" required>
                                    </div>
                                    <div class="form-group position-relative">
                                        <label for="MatKhau">Mật khẩu</label>
                                        <div class="position-relative">
                                            <input type="password" name="MatKhau" id="MatKhau" class="form-control pr-5"
                                                placeholder="Nhập mật khẩu" ' required>
                                            <span class="position-absolute"
                                                style="top: 50%; right: 15px; transform: translateY(-50%); cursor: pointer;"
                                                onclick="togglePassword()">
                                                <i class="fa fa-eye" id="togglePasswordIcon"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="btn btn-primary mt-3">Đăng nhập</button>
                                    </div>
                                    <div class="d-flex justify-content-center mt-2">
                                        <a href="{{ route('password.reset') }}">Quên mật khẩu?</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Core JS Files -->

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
    </script>
    <script>
        function togglePassword() {
            const input = document.getElementById('MatKhau');
            const icon = document.getElementById('togglePasswordIcon');
            if (input.type === "password") {
                input.type = "text";
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = "password";
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>