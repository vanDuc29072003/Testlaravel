<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Nhập OTP - Xác thực</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/x-icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS -->
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
                            <button type="submit" class="btn btn-success mt-3">Xác minh</button>
                        </div>
                    </form>
                    <div class="text-center mt-3">
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

    <!-- JS -->
    <script src="{{ asset('js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

    <script>
        @if (session('error'))
            $.notify({
                title: 'Lỗi',
                message: '{{ session('error') }}',
                icon: 'icon-bell'
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
                icon: 'icon-bell'
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
