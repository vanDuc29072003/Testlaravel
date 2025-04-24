<?php
use App\Http\Controllers\AuthController;
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

// Route yêu cầu đăng nhập
Route::middleware('auth')->group(function () {
    Route::get('/sidebar', function () {
        return view('includes.sidebar'); // Trả về nội dung sidebar
    })->name('sidebar');
    
    Route::get('/main-header', function () {
        return view('includes.main-header'); // Trả về nội dung main header
    })->name('main-header');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    

    Route::get('/dsphieunhap', [dsphieuNhapController::class, 'index'])->name('dsphieunhap');
    Route::get('/dsphieunhap/add', [dsphieuNhapController::class, 'create'])->name('dsphieunhap.add');
    Route::post('/dsphieunhap/store', [dsphieuNhapController::class, 'store'])->name('dsphieunhap.store');
    Route::get('/phieunhap/{MaPhieuNhap}', [dsphieuNhapController::class, 'show'])->name('phieunhap.show');
    Route::get('/dsphieunhap/{MaPhieuNhap}/edit', [dsphieuNhapController::class, 'edit'])->name('dsphieunhap.edit');
    Route::put('/dsphieunhap/{MaPhieuNhap}', [dsphieuNhapController::class, 'update'])->name('dsphieunhap.update');
    Route::delete('/dsphieunhap/{MaPhieuNhap}', [dsphieuNhapController::class, 'destroy'])->name('dsphieunhap.delete');
    Route::patch('/phieunhap/{MaPhieuNhap}/approve', [dsphieuNhapController::class, 'approve'])->name('phieunhap.approve');
    Route::get('/phieunhap/{MaPhieuNhap}/export-pdf', action: [dsphieuNhapController::class, 'exportPDF'])->name('phieunhap.exportPDF');


    Route::get('/dsphieuxuat', [dsphieuXuatController::class, 'index'])->name('dsphieuxuat');
    Route::get('/dsphieuxuat/add', [dsphieuXuatController::class, 'create'])->name('dsphieuxuat.add');
    Route::post('/dsphieuxuat/store', [dsphieuXuatController::class, 'store'])->name('dsphieuxuat.store');
    Route::get('/phieuxuat/{MaPhieuXuat}', [dsphieuXuatController::class, 'show'])->name('phieuxuat.show');
    Route::get('/phieuxuat/{MaPhieuXuat}/export-pdf', action: [dsphieuXuatController::class, 'exportPDF'])->name('phieuxuat.exportPDF');



    Route::get('/dsphieutra', [dsphieuTraController::class, 'index'])->name('dsphieutra');
    Route::get('/dsphieutra/add', [dsphieuTraController::class, 'create'])->name('dsphieutra.add');
    Route::post('/dsphieutra/store', [dsphieuTraController::class, 'store'])->name('dsphieutra.store');
    Route::get('/phieutra/{MaPhieuTra}', [dsphieuTraController::class, 'show'])->name('phieutra.show');
    Route::get('/phieutra/{MaPhieuTra}/export-pdf', action: [dsphieuTraController::class, 'exportPDF'])->name('phieutra.exportPDF');


    Route::get('/linhkien/search1', [LinhKienController::class, 'search1'])->name('linhkien.search1');
    Route::get('/linhkien/search', [LinhKienController::class, 'search'])->name('linhkien.search');
    Route::get('/linhkien', [LinhKienController::class, 'index'])->name('linhkien');
    Route::get('/linhkien/add', [LinhKienController::class, 'create'])->name('linhkien.add');
    Route::post('/linhkien', [LinhKienController::class, 'store'])->name('linhkien.store');
    Route::get('/linhkien/{MaLinhKien}', [LinhKienController::class, 'detail'])->name('linhkien.detail');
    Route::get('/linhkien/{MaLinhKien}/edit', [LinhKienController::class, 'editForm'])->name('linhkien.edit');
    Route::patch('/linhkien/{MaLinhKien}', [LinhKienController::class, 'update'])->name('linhkien.update');
    Route::delete('/linhkien/{MaLinhKien}', [LinhKienController::class, 'delete'])->name('linhkien.delete');

    Route::get('/may', [MayController::class, 'may'])->name('may');
    Route::get('/may/add', [MayController::class, 'addMay'])->name('may.add');
    Route::post('/may', [MayController::class, 'storeMay'])->name('may.store');
    Route::get('/may/{MaMay}', [MayController::class, 'detailMay'])->name('may.detail');
    Route::get('/may/{MaMay}/edit', [MayController::class, 'form_editmay'])->name('may.edit');
    Route::patch('/may/{MaMay}', [MayController::class, 'editmay'])->name('may.update');
    Route::delete('/may/{MaMay}', [MayController::class, 'deleteMay'])->name('may.delete');

    Route::get('/nhacungcap', [NhaCungCapController::class, 'nhacungcap'])->name('nhacungcap');
    Route::get('/nhacungcap/detail/{MaNhaCungCap}', [NhaCungCapController::class, 'detailNhaCungCap'])->name('nhacungcap.detail');
    Route::get('/nhacungcap/edit/{MaNhaCungCap}', [NhaCungCapController::class, 'form_editNhaCungCap'])->name('nhacungcap.edit');
    Route::post('/nhacungcap/edit/{MaNhaCungCap}', [NhaCungCapController::class, 'editNhaCungCap'])->name('nhacungcap.update');
    Route::get('/nhacungcap/add', [NhaCungCapController::class, 'addNhaCungCap'])->name('nhacungcap.add');
    Route::post('/nhacungcap/store', [NhaCungCapController::class, 'storeNhaCungCap'])->name('nhacungcap.store');
    Route::delete('/nhacungcap/{MaNhaCungCap}', [NhaCungCapController::class, 'deleteNhaCungCap'])->name('nhacungcap.delete');

    Route::get('/detailuser', [DetailuserController::class, 'detailuser'])->name('detailuser');

    Route::get('/yeucausuachua',[YeuCauSuaChuaController::class, 'index'])->name('yeucausuachua.index');
    Route::get('/yeucausuachua/create', [YeuCauSuaChuaController::class, 'create'])->name('yeucausuachua.create');
    Route::post('/yeucausuachua', [YeuCauSuaChuaController::class, 'store'])->name('yeucausuachua.store');
    Route::get('/yeucausuachua/{MaYeuCauSuaChua}/duyet', [YeuCauSuaChuaController::class, 'formduyet'])->name('yeucausuachua.formduyet');
    Route::post('/yeucausuachua/{MaYeuCauSuaChua}/duyet', [YeuCauSuaChuaController::class, 'duyet'])->name('yeucausuachua.duyet');
    Route::post('/yeucausuachua/{MaYeuCauSuaChua}/tuchoi', [YeuCauSuaChuaController::class, 'tuchoi'])->name('yeucausuachua.tuchoi');

    Route::get('/lichsuachua', [LichSuaChuaController::class, 'index'])->name('lichsuachua.index');
    Route::post('/lichsuachua/{MaLichSuaChua}/lienhencc', [LichSuaChuaController::class, 'lienhencc'])->name('lichsuachua.lienhencc');
    Route::get('/lichbaotri', [LichBaoTriController::class, 'index'])->name('lichbaotri');
    Route::get('/lichbaotri/create', [LichBaoTriController::class, 'create'])->name('lichbaotri.create');
    Route::post('/lichbaotri', [LichBaoTriController::class, 'store'])->name('lichbaotri.store');
    Route::delete('/lichbaotri/{id}', [LichBaoTriController::class, 'destroy'])->name('lichbaotri.destroy');
    //Lịch vận hành
    Route::get('/lichvanhanh', [LichVanHanhController::class, 'index'])->name('lichvanhanh');
    Route::get('/lichvanhanh/create', [LichVanHanhController::class, 'create'])->name('lichvanhanh.create');
    Route::post('/lichvanhanh', [LichVanHanhController::class, 'store'])->name('lichvanhanh.store');
    Route::get('/lichvanhanh/{id}/edit', [LichVanHanhController::class, 'edit'])->name('lichvanhanh.edit');
    Route::delete('lichvanhanh/{id}', [LichVanHanhController::class, 'destroy'])->name('lichvanhanh.destroy');
    Route::match(['put', 'patch'], '/lichvanhanh/{id}', [LichVanHanhController::class, 'update'])->name('lichvanhanh.update');

   

});
