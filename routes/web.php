<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DetailuserController;
use App\Http\Controllers\LichSuaChuaController;
use App\Http\Controllers\LichVanHanhController;
use App\Http\Controllers\MayController;
use App\Http\Controllers\NhaCungCapController;
use Illuminate\Support\Facades\Route;

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
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/lichvanhanh', [LichVanHanhController::class, 'lichVanHanh'])->name('lichvanhanh');
    Route::get('/lichsuachua', [LichSuaChuaController::class, 'lichSuaChua'])->name('lichsuachua');

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
});
