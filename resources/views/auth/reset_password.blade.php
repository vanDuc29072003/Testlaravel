<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Đổi mật khẩu - CTY TNHH IN T.KHOA</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/x-icon" />

    <!-- CSS & Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kaiadmin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/demo.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <!-- JS Fonts -->
    <script src="{{ asset('js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: { families: ["Public Sans:300,400,500,600,700"] },
            custom: {
                families: ["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
                urls: ["{{ asset('css/fonts.min.css') }}"],
            },
            active: () => sessionStorage.fonts = true,
        });
    </script>
</head>

<body>
    <div class="wrapper">
        <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
            <div class="card p-4 shadow" style="min-width: 400px;">
                <div class="text-center mb-4">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo" height="40">
                    <h3 class="mt-2">Đổi mật khẩu</h3>
                </div>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="MatKhau">Mật khẩu mới</label>
                        <input type="password" name="MatKhau" id="MatKhau" class="form-control" required placeholder="Nhập mật khẩu mới">
                    </div>

                    <div class="form-group mb-3">
                        <label for="MatKhau_confirmation">Xác nhận mật khẩu mới</label>
                        <input type="password" name="MatKhau_confirmation" id="MatKhau_confirmation" class="form-control" required placeholder="Nhập lại mật khẩu mới">
                    </div>

                    <div class="form-group mb-3">
                        <label for="otp">Mã OTP xác nhận</label>
                        <input type="text" name="otp" id="otp" class="form-control" required placeholder="Nhập mã OTP">
                    </div>

                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="showPassword" onclick="togglePassword()">
                        <label class="form-check-label" for="showPassword">Hiển thị mật khẩu</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Xác nhận đổi mật khẩu</button>
                </form>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="{{ asset('js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/core/bootstrap.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/js/bootstrap-notify.min.js"></script>

    <!-- Toggle Password JS -->
    <script>
        function togglePassword() {
            const pwFields = [document.getElementById('MatKhau'), document.getElementById('MatKhau_confirmation')];
            pwFields.forEach(field => {
                field.type = field.type === "password" ? "text" : "password";
            });
        }

        @if (session('error'))
            $.notify({
                title: 'Lỗi',
                message: '{{ session('error') }}',
                icon: 'fa fa-exclamation-triangle'
            }, {
                type: 'danger',
                animate: {
                    enter: 'animated shake',
                    exit: 'animated fadeOutUp'
                },
            });
        @endif

        @if (session('success'))
            $.notify({
                title: 'Thành công',
                message: '{{ session('success') }}',
                icon: 'fa fa-check-circle'
            }, {
                type: 'success',
                animate: {
                    enter: 'animated bounceIn',
                    exit: 'animated fadeOutUp'
                },
            });
        @endif
    </script>
</body>
</html>
