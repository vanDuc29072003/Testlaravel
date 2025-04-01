<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LichSuaChuaController;
use App\Http\Controllers\LichVanHanhController;
use App\Http\Controllers\MayController;
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

Route::get('/', function () {
    return view('welcome');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/lichvanhanh', [LichVanHanhController::class, 'lichVanHanh'])->name('lichvanhanh');
Route::get('/lichsuachua', [LichSuaChuaController::class, 'lichSuaChua'])->name('lichsuachua');
Route::get('/may', [MayController::class, 'may'])->name('may');
Route::get('/may/edit/{MaMay}', [MayController::class, 'form_editmay'])->name('may.edit');
Route::post('/may/edit/{MaMay}', [MayController::class, 'editmay'])->name('may.update');
Route::get('/may/add', [MayController::class, 'addMay'])->name('may.add');
Route::post('/may/store', [MayController::class, 'storeMay'])->name('may.store');
Route::get('/may/detail/{MaMay}', [MayController::class, 'detailMay'])->name('may.detail');
Route::delete('/may/{MaMay}', [MayController::class, 'deleteMay'])->name('may.delete');