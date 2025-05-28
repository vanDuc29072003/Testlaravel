<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetailuserController;
use App\Http\Controllers\LichSuaChuaController;
use App\Http\Controllers\dsphieuNhapController;
use App\Http\Controllers\dsphieuXuatController;
use App\Http\Controllers\dsphieuTraController;
use App\Http\Controllers\LichVanHanhController;
use App\Http\Controllers\MayController;
use App\Http\Controllers\NhaCungCapController;
use App\Http\Controllers\LinhKienController;
use App\Http\Controllers\YeuCauSuaChuaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LichBaoTriController;
use App\Http\Controllers\TaiKhoanController;
use App\Http\Controllers\PhieuBanGiaoController;
use App\Http\Controllers\ThongKeController;
use App\Http\Controllers\PhieuThanhLyController;
use App\Http\Controllers\LoaiMayController;
use App\Http\Controllers\BophanController;
use App\Http\Controllers\NhatKiVanHanhController;
use App\Http\Controllers\DonViTinhController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/reset-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.reset');
Route::post('/reset-password/send-otp', [AuthController::class, 'sendOtpForResetPassword'])->name('password.sendOtp');
// Xử lý đổi mật khẩu (bước 3)
Route::post('/reset-password/update', [AuthController::class, 'resetPassword'])->name('password.update');

#otp 
Route::get('/otp', [AuthController::class, 'showOtpForm'])->name('otp.form');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('otp.verify');
Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('otp.resend');

// Route yêu cầu đăng nhập
Route::middleware('auth')->group(function () {
  Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

  Route::get('/sidebar', function () {
    return view('includes.sidebar'); // Trả về nội dung sidebar
  })->name('sidebar');

  Route::get('/main-header', function () {
    return view('includes.main-header'); // Trả về nội dung main header
  })->name('main-header');

  Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
  


  Route::get('/dsphieunhap', [dsphieuNhapController::class, 'index'])->name('dsphieunhap');
  Route::get('/dsphieunhap/add', [dsphieuNhapController::class, 'create'])
    ->middleware('kiemtraquyen:21')
    ->name('dsphieunhap.add');
    Route::post('/phieunhap/saveSession', [dsphieuNhapController::class, 'saveSession'])->name('phieunhap.saveSession');

  Route::post('/dsphieunhap/store', [dsphieuNhapController::class, 'store'])->name('dsphieunhap.store');
  Route::get('/phieunhap/{MaPhieuNhap}', [dsphieuNhapController::class, 'show'])->name('phieunhap.show');
  Route::get('/dsphieunhap/{MaPhieuNhap}/edit', [dsphieuNhapController::class, 'edit'])
    ->middleware('kiemtraquyen:22')
    ->name('dsphieunhap.edit');
  Route::post('/phieunhap/saveSession1', [dsphieuNhapController::class, 'saveSession1'])->name('phieunhap.saveSession1');

  Route::put('/dsphieunhap/{MaPhieuNhap}', [dsphieuNhapController::class, 'update'])->name('dsphieunhap.update');
  Route::delete('/dsphieunhap/{MaPhieuNhap}', [dsphieuNhapController::class, 'destroy'])
    ->middleware('kiemtraquyen:24')
    ->name('dsphieunhap.delete');
  Route::patch('/phieunhap/{MaPhieuNhap}/approve', [dsphieuNhapController::class, 'approve'])
    ->middleware('kiemtraquyen:23')
    ->name('phieunhap.approve');
  Route::get('/phieunhap/{MaPhieuNhap}/export-pdf', action: [dsphieuNhapController::class, 'exportPDF'])->name('phieunhap.exportPDF');


  Route::get('/dsphieuxuat', [dsphieuXuatController::class, 'index'])->name('dsphieuxuat');
  Route::get('/dsphieuxuat/add', [dsphieuXuatController::class, 'create'])
    ->middleware('kiemtraquyen:25')
    ->name('dsphieuxuat.add');
    
  Route::post('/dsphieuxuat/store', [dsphieuXuatController::class, 'store'])->name('dsphieuxuat.store');
  Route::get('/phieuxuat/{MaPhieuXuat}', [dsphieuXuatController::class, 'show'])->name('phieuxuat.show');
  Route::get('/phieuxuat/{MaPhieuXuat}/export-pdf', action: [dsphieuXuatController::class, 'exportPDF'])->name('phieuxuat.exportPDF');



  Route::get('/dsphieutra', [dsphieuTraController::class, 'index'])->name('dsphieutra');
  Route::get('/dsphieutra/add', [dsphieuTraController::class, 'create'])
    ->middleware('kiemtraquyen:26')
    ->name('dsphieutra.add');
  Route::post('/dsphieutra/store', [dsphieuTraController::class, 'store'])->name('dsphieutra.store');
  Route::get('/phieutra/{MaPhieuTra}', [dsphieuTraController::class, 'show'])->name('phieutra.show');
  Route::get('/phieutra/{MaPhieuTra}/export-pdf', action: [dsphieuTraController::class, 'exportPDF'])->name('phieutra.exportPDF');


  Route::get('/linhkien/search1', [LinhKienController::class, 'search1'])->name('linhkien.search1');
  Route::get('/linhkien/search', [LinhKienController::class, 'search'])->name('linhkien.search');
  Route::get('/linhkien', [LinhKienController::class, 'index'])->name('linhkien');
  Route::get('/linhkien/add', [LinhKienController::class, 'create'])
    ->middleware('kiemtraquyen:15')
    ->name('linhkien.add');
    Route::get('/linhkien/add2', [LinhKienController::class, 'create2'])
    ->name('linhkien.add2');
     Route::get('/linhkien/add3', [LinhKienController::class, 'create3'])
    ->name('linhkien.add3');
  Route::post('/linhkien', [LinhKienController::class, 'store'])->name('linhkien.store');
  Route::post('/linhkien/store2', [LinhKienController::class, 'store2'])->name('linhkien.store2');
  Route::post('/linhkien/store3', [LinhKienController::class, 'store3'])->name('linhkien.store3');
  Route::get('/linhkien/{MaLinhKien}', [LinhKienController::class, 'detail'])->name('linhkien.detail');
  Route::get('/linhkien/{MaLinhKien}/edit', [LinhKienController::class, 'editForm'])
    ->middleware('kiemtraquyen:16')
    ->name('linhkien.edit');
  // routes/web.php
  Route::post('/linhkien/save-form-data', [LinhKienController::class, 'saveFormData'])->name('linhkien.saveFormData');

  Route::patch('/linhkien/{MaLinhKien}', [LinhKienController::class, 'update'])->name('linhkien.update');
  Route::delete('/linhkien/{MaLinhKien}', [LinhKienController::class, 'delete'])
    ->middleware('kiemtraquyen:17')
    ->name('linhkien.delete');

  Route::get('/may', [MayController::class, 'may'])->name('may');
  Route::get('/may/add', [MayController::class, 'addMay'])
    ->middleware('kiemtraquyen:10')
    ->name('may.add');
  Route::post('/may', [MayController::class, 'storeMay'])->name('may.store');
  Route::get('/may/{MaMay}', [MayController::class, 'detailMay'])->name('may.detail');
  Route::get('/may/{MaMay}/edit', [MayController::class, 'form_editmay'])
    ->middleware('kiemtraquyen:11')
    ->name('may.edit');
  Route::patch('/may/{MaMay}', [MayController::class, 'editmay'])->name('may.update');
  Route::delete('/may/{MaMay}', [MayController::class, 'deleteMay'])->name('may.delete');
  Route::post('may/save-form-session', [MayController::class, 'saveFormSession'])->name('may.saveFormSession');

  Route::get('/nhacungcap', [NhaCungCapController::class, 'nhacungcap'])->name('nhacungcap');
  Route::get('/nhacungcap/detail/{MaNhaCungCap}', [NhaCungCapController::class, 'detailNhaCungCap'])->name('nhacungcap.detail');
  Route::get('/nhacungcap/edit/{MaNhaCungCap}', [NhaCungCapController::class, 'form_editNhaCungCap'])
    ->middleware('kiemtraquyen:19')
    ->name('nhacungcap.edit');
  Route::post('/nhacungcap/edit/{MaNhaCungCap}', [NhaCungCapController::class, 'editNhaCungCap'])->name('nhacungcap.update');
  Route::get('/nhacungcap/add', [NhaCungCapController::class, 'addNhaCungCap'])
    ->middleware('kiemtraquyen:18')
    ->name('nhacungcap.add');
  Route::get('/nhacungcap/add2', [NhaCungCapController::class, 'addNhaCungCap2'])
    
    ->name('nhacungcap.add2');
  Route::post('/nhacungcap/store', [NhaCungCapController::class, 'storeNhaCungCap'])->name('nhacungcap.store');
    Route::post('/nhacungcap/store2', [NhaCungCapController::class, 'storeNhaCungCap2'])->name('nhacungcap.store2');

  Route::delete('/nhacungcap/{MaNhaCungCap}', [NhaCungCapController::class, 'deleteNhaCungCap'])
    ->middleware('kiemtraquyen:20')
    ->name('nhacungcap.delete');
  Route::get('nhacungcap/create-from-may', [NhaCungCapController::class, 'createNCCfromMay'])->name('nhacungcap.createNCCfromMay');
  Route::post('/nhacungcap/store-from-may', [NhaCungCapController::class, 'storeNCCfromMay'])->name('nhacungcap.storeNCCfromMay');

  Route::get('/detailuser', [DetailuserController::class, 'detailuser'])->name('detailuser');

  Route::get('/yeucausuachua', [YeuCauSuaChuaController::class, 'index'])->name('yeucausuachua.index');
  Route::get('/yeucausuachua/create', [YeuCauSuaChuaController::class, 'create'])
      ->middleware(['kiemtraquyen:5', 'vietnhatki'])
      ->name('yeucausuachua.create');


  Route::post('/yeucausuachua', [YeuCauSuaChuaController::class, 'store'])->name('yeucausuachua.store');
  Route::get('/yeucausuachua/{MaYeuCauSuaChua}/duyet', [YeuCauSuaChuaController::class, 'formduyet'])
    ->middleware('kiemtraquyen:6')
    ->name('yeucausuachua.formduyet');
  Route::post('/yeucausuachua/{MaYeuCauSuaChua}/duyet', [YeuCauSuaChuaController::class, 'duyet'])->name('yeucausuachua.duyet');
  Route::post('/yeucausuachua/{MaYeuCauSuaChua}/tuchoi', [YeuCauSuaChuaController::class, 'tuchoi'])
    ->middleware('kiemtraquyen:7')
    ->name('yeucausuachua.tuchoi');

  Route::get('/lichsuachua', [LichSuaChuaController::class, 'index'])->name('lichsuachua.index');
  Route::post('/lichsuachua/{MaLichSuaChua}/lienhencc', [LichSuaChuaController::class, 'lienhencc'])->name('lichsuachua.lienhencc');
  Route::get('/lichsuachua/dahoanthanh', [LichSuaChuaController::class, 'lichSuDaHoanThanh'])->name('lichsuachua.dahoanthanh');
  Route::get('/lichsuachua/{MaLichSuaChua}/taophieubangiaonoibo', [LichSuaChuaController::class, 'taoPhieuBanGiaoNoiBo'])
    ->middleware('chinguoidamnhan')
    ->name('lichsuachua.taophieubangiaonoibo');
  Route::get('/lichsuachua/{MaLichSuaChua}/bangiaonhacungcap', [LichSuaChuaController::class, 'bangiaoNhaCungCap'])->name('lichsuachua.bangiaonhacungcap');
  Route::get('/lichsuachua/{MaLichSuaChua}/xem-ncc', [LichSuaChuaController::class, 'xemNCC'])
    ->middleware('kiemtraquyen:9')
    ->name('lichsuachua.xemncc');
  Route::get('/lichsuachua/{MaLichSuaChua}/xem-ncc/export', [LichSuaChuaController::class, 'exporttscSC'])->name('lichsuachua.xemncc.export');

  Route::post('/phieubangiao/store', [PhieuBanGiaoController::class, 'store'])->name('phieubangiao.store');
  Route::get('/phieubangiao/{MaPhieuBanGiaoNoiBo}/export-pdf', [PhieuBanGiaoController::class, 'exportPDF'])->name('phieubangiao.exportPDF');


  Route::get('/phieubangiao/{MaPhieuBanGiaoSuaChua}/export-pdf1', [PhieuBanGiaoController::class, 'exportPDF1'])->name('phieubangiao.exportPDF1');
  Route::post('/phieubangiao/store1', [PhieuBanGiaoController::class, 'store1'])->name('phieubangiao.store1');
  Route::get('/lichsuachua/{MaLichSuaChua}', [LichSuaChuaController::class, 'show'])->name('lichsuachua.showpbg');  
  Route::get('/lichsuachua-bg/{MaLichSuaChua}', [LichSuaChuaController::class, 'show1'])->name('lichsuachua.showpbg1');
  Route::post('/phieubangiao/storeBT', [PhieuBanGiaoController::class, 'storeBT'])->name('phieubangiao.storeBT');




  // Lịch bảo trì
  Route::get('/lichbaotri', [LichBaoTriController::class, 'index'])->name('lichbaotri');
  Route::get('/lichbaotri/create', [LichBaoTriController::class, 'create'])
    ->middleware('kiemtraquyen:2')
    ->name('lichbaotri.create');
  Route::post('/lichbaotri', [LichBaoTriController::class, 'store'])->name('lichbaotri.store');
  Route::delete('/lichbaotri/{id}', [LichBaoTriController::class, 'destroy'])
    ->middleware('kiemtraquyen:4')
    ->name('lichbaotri.destroy');
  
  Route::get('/lichbaotri/{MaLichBaoTri}/taophieubangiao', [LichBaoTriController::class, 'taophieubangiao'])
    ->middleware('kiemtraquyen:3')
    ->name('lichbaotri.taophieubangiao');
  Route::get('/lichbaotri/dabangiao', [LichBaoTriController::class, 'lichSuBaoTri'])->name('lichbaotri.dabangiao');
  Route::get('/lichbaotri/{MaLichBaoTri}', [LichBaoTriController::class, 'show'])->name('lichbaotri.showpbg');
  Route::get('/phieubangiao/{MaPhieuBanGiaoBaoTri}/export-pdf2', [PhieuBanGiaoController::class, 'exportPDF2'])->name('phieubangiaobaotri.exportPDF');

  //Lịch vận hành
  Route::get('/lichvanhanh', [LichVanHanhController::class, 'index'])->name('lichvanhanh');
  Route::get('/lichvanhanh/create', [LichVanHanhController::class, 'create'])
    ->middleware('kiemtraquyen:1')
    ->name('lichvanhanh.create');
  Route::post('/lichvanhanh', [LichVanHanhController::class, 'store'])->name('lichvanhanh.store');
  Route::get('/lichvanhanh/{id}/edit', [LichVanHanhController::class, 'edit'])->name('lichvanhanh.edit');
  Route::delete('lichvanhanh/{id}', [LichVanHanhController::class, 'destroy'])->name('lichvanhanh.destroy');
  Route::match(['put', 'patch'], '/lichvanhanh/{id}', [LichVanHanhController::class, 'update'])->name('lichvanhanh.update');
  
  Route::get('/lichvanhanh/{id}/nhatki', [LichVanHanhController::class, 'showNhatKi'])
  -> middleware('vietnhatki')
  ->name('lichvanhanh.showNhatKi');

  Route::put('/lichvanhanh/{id}/nhatki', [LichVanHanhController::class, 'updateNhatKi'])->name('lichvanhanh.updateNhatKi');
  //Thống kê vận hành
  Route::get('/thongke-nhatki', [NhatKiVanHanhController::class, 'index'])->name('nhatki.thongke');
  Route::get('/thongke-nhatki/{id}', [NhatKiVanHanhController::class, 'show'])->name('nhatki.show');




  //Tài khoản
  Route::get('/taikhoan', [TaiKhoanController::class, 'index'])->name('taikhoan.index');
  Route::get('/taikhoan/create', [TaiKhoanController::class, 'create'])
    ->middleware('kiemtraquyen:27')
    ->name('taikhoan.create');
  Route::post('/taikhoan/store', [TaiKhoanController::class, 'store'])->name('taikhoan.store');

  Route::get('/taikhoan/{MaNhanVien}/edit', [TaiKhoanController::class, 'edit'])
    ->middleware('kiemtraquyen:28')
    ->name('taikhoan.edit');

  Route::match(['put', 'patch'], '/taikhoan/{id}', [TaiKhoanController::class, 'update'])->name('taikhoan.update');
  Route::delete('/taikhoan/{id}', [TaiKhoanController::class, 'destroy'])
    ->middleware('kiemtraquyen:29')
    ->name('taikhoan.destroy');
  Route::get('/taikhoan/{TenTaiKhoan}', [TaiKhoanController::class, 'show'])->name('taikhoan.show');
  Route::get('/{TenTaiKhoan}/editThongTin', [TaiKhoanController::class, 'editThongTin'])->name('taikhoan.editThongTin');
  Route::match(['put', 'patch'], '/{TenTaiKhoan}/updateThongTin', [TaiKhoanController::class, 'updateThongTin'])->name('taikhoan.updateThongTin');

  //Loại máy
  Route::get('/loaimay', [LoaiMayController::class, 'index'])->name('loaimay.index');
  Route::get('/loaimay/create', [LoaiMayController::class, 'create'])
    ->middleware('kiemtraquyen:13')
    ->name('loaimay.create');
  Route::post('/loaimay/store', [LoaiMayController::class, 'store'])->name('loaimay.store');
  Route::delete('/loaimay/{id}', [LoaiMayController::class, 'destroy'])
    ->middleware('kiemtraquyen:14')
    ->name('loaimay.destroy');
  Route::get('/loaimay/create-from-may', [LoaiMayController::class, 'createLoaiMayfromMay'])->name('loaimay.createLoaiMayfromMay');
  Route::post('/loaimay/store-from-may', [LoaiMayController::class, 'storeLoaiMayfromMay'])->name('loaimay.storeLoaiMayfromMay');


  Route::get('/bophan', [BophanController::class, 'index'])->name('bophan.index');
  Route::get('/bophan/create', [BophanController::class, 'create'])
    ->middleware('kiemtraquyen:32')
    ->name('bophan.create');
  Route::post('/bophan/store', [BophanController::class, 'store'])->name('bophan.store');
  Route::delete('/bophan/{id}', [BophanController::class, 'destroy'])
    ->middleware('kiemtraquyen:33')
    ->name('bophan.destroy');

    //Thống kê
    Route::get('/thongke', [ThongKeController::class, 'thongkekho'])->name('thongkekho');
    // Đảm bảo rằng route xuất PDF không bị middleware CSRF chặn
    Route::get('/thongke/pdf', [ThongKeController::class, 'exportPDF'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])->name('thongkekho.pdf');
    Route::get('/thongke/pdf', [ThongKeController::class, 'exportPDF'])->name('thongkekho.pdf');
    Route::get('/thongkesuachua', [ThongKeController::class, 'thongkesuachua'])->name('thongkesuachua');
    Route::get('/thongkesuachua/pdf', [ThongKeController::class, 'exportPDF1'])->name('thongkesuachua.pdf');
    Route::get('/thongkesuachua/detailSC/{maMay}', [ThongKeController::class, 'detailSC'])->name('thongkesuachua.detailSC');
    Route::get('/thongkesuachua/detailBT/{maMay}', [ThongKeController::class, 'detailBT'])->name('thongkesuachua.detailBT');

    Route::get('/thongkelinhkienxuat', [ThongKeController::class, 'thongkelinhkienxuat'])->name('thongkelinhkienxuat');
    Route::get('/thongkelinhkienxuat/pdf', [ThongKeController::class, 'exportPDF2'])->name('thongkelinhkienxuat.pdf');
    Route::get('/canhbaonhaphang', [ThongKeController::class, 'canhbaonhaphang'])->name('canhbaonhaphang');
    Route::get('/canhbaonhaphang/pdf', [ThongKeController::class, 'exportPDF3'])->name('canhbaonhaphang.pdf');




    //Phiếu thanh lý
    Route::get('/phieuthanhly', [PhieuThanhLyController::class, 'index'])->name('phieuthanhly.index');
    Route::get('/phieuthanhly/create', [PhieuThanhLyController::class, 'create'])->name('phieuthanhly.create');
    Route::post('/phieuthanhly/store', [PhieuThanhLyController::class, 'store'])->name('phieuthanhly.store');
    Route::get(('phieuthanhly/{MaPhieuThanhLy}'), [PhieuThanhLyController::class, 'detail'])->name('phieuthanhly.detail');
    Route::get('/phieuthanhly/{MaPhieuThanhLy}/edit', [PhieuThanhLyController::class, 'edit'])->name('phieuthanhly.edit');
    Route::match(['put', 'patch'], '/phieuthanhly/{MaPhieuThanhLy}', [PhieuThanhLyController::class, 'update'])->name('phieuthanhly.update');
    Route::patch('/phieuthanhly/{MaPhieuThanhLy}/duyet', [PhieuThanhLyController::class, 'duyet'])->name('phieuthanhly.duyet');
    Route::patch('/phieuthanhly/{MaPhieuThanhLy}/tuchoi', [PhieuThanhLyController::class, 'tuchoi'])->name('phieuthanhly.tuchoi');
    Route::get('/phieuthanhly/{MaPhieuThanhLy}/pdf', [PhieuThanhLyController::class, 'exportPDF'])->name('phieuthanhly.exportPDF');
    Route::get('/may/{MaMay}/thongtin', [PhieuThanhLyController::class, 'getThongTinMay'])->name('may.thongtin');


    //Dơn vị tính
    Route::get('/donvitinh', [DonViTinhController::class, 'index'])->name('donvitinh.index');
    Route::get('/donvitinh/create', [DonViTinhController::class, 'create'])->name('donvitinh.create');
    Route::post('/donvitinh/store', [DonViTinhController::class, 'store'])->name('donvitinh.store');
    Route::delete('/donvitinh/{MaDonViTinh}', [DonViTinhController::class, 'destroy'])->name('donvitinh.destroy');
});
