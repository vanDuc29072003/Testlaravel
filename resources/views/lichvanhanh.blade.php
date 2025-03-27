<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta charset="UTF-8"/>
    <title>CTY TNHH IN T.KHOA</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="assets/img/logo.png" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
		WebFont.load({
			google: {"families":["Public Sans:300,400,500,600,700"]},
			custom: {"families":["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['assets/css/fonts.min.css']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

    <!-- CSS Files -->
  

    <!-- CSS Files -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kaiadmin.min.css') }}">

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="assets/css/demo.css" />
  </head>
  <body>
    <div class="wrapper">
      <!-- Sidebar -->
      <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="index.php" class="logo">
              <img src="assets/img/logo.png" alt="navbar brand" class="navbar-brand" height="50" />
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
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
              <li class="nav-item ">
                <a href="index.php" class="collapsed" aria-expanded="false">
                  <i class="fas fa-home"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              <li class="nav-item ">
                <a data-bs-toggle="collapse" href="#phancong"   >
                  <i class="fa-solid fa-calendar-days"></i>
                  <p>Phân công</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="phancong">
                  <ul class="nav nav-collapse">
                    <li>
                        <a href="lichvanhanh.html">
                        <span class="sub-item">Lịch vận hành</span>
                      </a>
                    </li>
                    <li>
                      <a href="lichbaotri.html">
                      <span class="sub-item">Lịch bảo trì</span>
                    </a>
                    </li>
                    <li>
                      <a href="lichsuachua.html">
                      <span class="sub-item">Lịch sửa chữa</span>
                    </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item ">
                <a href="yeucau.html" class="collapsed" aria-expanded="false">
                  <i class="fa-solid fa-hammer"></i>
                  <p>Yêu cầu sửa chữa</p>
                </a>
              </li>
              <li class="nav-item ">
                <a href="may.php" class="collapsed" aria-expanded="false">
                  <i class="fa-solid fa-sliders"></i>
                  <p>Danh sách máy</p>
                </a>
              </li>
              <li class="nav-item ">
                <a href="linhkien.php" class="collapsed" aria-expanded="false">
                  <i class="fa-solid fa-gears"></i>
                  <p>Danh sách linh kiện</p>
                </a>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#submenu">
                  <i class="fa-solid fa-clipboard-list"></i>
                  <p>Lập phiếu</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="submenu">
                  <ul class="nav nav-collapse">
                    <li>
                        <a href="phieubangiao.html">
                        <span class="sub-item">Phiếu bàn giao</span>
                      </a>
                      
                    </li>
                    <li>
                        <a href="phieunhap.html">
                        <span class="sub-item">Phiếu nhập kho</span>
                        </a>
                      
                    </li>
                    <li>
                      <a href="phieuxuat.html">
                        <span class="sub-item">Phiếu xuất kho</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item ">
                <a data-bs-toggle="collapse" href="#admin"   >
                  <i class="fa-solid fa-users"></i>
                  <p>Quản trị viên</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="admin">
                  <ul class="nav nav-collapse">
                    <li>
                        <a href="taikhoan.html">
                        <span class="sub-item">Danh sách tài khoản</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item ">
                <a href="logout.php" class="collapsed" aria-expanded="false">
                  <i class="fa-solid fa-right-from-bracket"></i>
                  <p>Đăng xuất</p>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!-- End Sidebar -->

      <div class="main-panel">
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
        <div class="container">
          <div class="page-inner">
            <div class="table-responsive">
            <table class="table table-bordered">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="mb-0">Lịch vận hành</h1>
                <button class="btn btn-primary">
                  <i class="fa fa-plus"></i> Thêm mới
                </button>
              </div>              
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead style="background-color: pink; color: black;">
                    <tr>
                      <th>#</th>
                      <th>Ngày</th>
                      <th>Mã Máy</th>
                      <th>Tên Máy</th>
                      <th>Người Đảm Nhận</th>
                      <th>Ghi Chú</th>
                      <th>Cập Nhật</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th scope="row">1</th>
                      <td>15/3/2025</td>
                      <td>17</td>
                      <td>Máy ép UV</td>
                      <td>Lò Văn Hóa</td>
                      <td></td>
                      <td>
                        
                          <div class="d-flex gap-2">
                            <button class="btn btn-warning btn-sm">
                              <i class="fa fa-edit"></i> Sửa
                            </button>
                            <button class="btn btn-danger btn-sm">
                              <i class="fa fa-trash"></i> Xóa
                            </button>
                          </div>
                        
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">2</th>
                      <td>15/3/2025</td>
                      <td>10</td>
                      <td>Máy bế</td>
                      <td>Vũ Văn Dương</td>
                      <td>Hiệu suất giảm nhẹ, kiểm tra hệ thống làm mát.</td>
                      <td>
                        
                          <div class="d-flex gap-2">
                            <button class="btn btn-warning btn-sm">
                              <i class="fa fa-edit"></i> Sửa
                            </button>
                            <button class="btn btn-danger btn-sm">
                              <i class="fa fa-trash"></i> Xóa
                            </button>
                          </div>
                        
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">3</th>
                      <td>15/3/2025</td>
                      <td>42</td>
                      <td>Máy in</td>
                      <td>Nguyễn Văn Chiến</td>
                      <td></td>
                      <td>
                        
                          <div class="d-flex gap-2">
                            <button class="btn btn-warning btn-sm">
                              <i class="fa fa-edit"></i> Sửa
                            </button>
                            <button class="btn btn-danger btn-sm">
                              <i class="fa fa-trash"></i> Xóa
                            </button>
                          </div>
                        
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">4</th>
                      <td>15/3/2025</td>
                      <td>43</td>
                      <td>Máy ép sóng</td>
                      <td>Vũ Văn Hai</td>
                      <td>Có tiếng ồn bất thường, cần theo dõi.</td>
                      <td>
                        
                          <div class="d-flex gap-2">
                            <button class="btn btn-warning btn-sm">
                              <i class="fa fa-edit"></i> Sửa
                            </button>
                            <button class="btn btn-danger btn-sm">
                              <i class="fa fa-trash"></i> Xóa
                            </button>
                          </div>
                        
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            </table>
          </div>
          </div>
        </div>
      </div> 
    </div>
    <!--   Core JS Files   -->
    <script src="assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>



    <!-- jQuery Scrollbar -->
    <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Chart JS -->
    <script src="assets/js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Chart Circle -->
    <script src="assets/js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="assets/js/plugin/datatables/datatables.min.js"></script>

    <!-- Bootstrap Notify -->
    <script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

    <!-- jQuery Vector Maps -->
    <script src="assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="assets/js/plugin/jsvectormap/world.js"></script>

    <!-- Google Maps Plugin -->
    <script src="assets/js/plugin/gmaps/gmaps.js"></script>

    <!-- Sweet Alert -->
    <script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>

    <!-- Kaiadmin JS -->
    <script src="assets/js/kaiadmin.min.js"></script>
  </body>
</html>