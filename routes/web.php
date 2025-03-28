<?php

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
Route::get('/lichvanhanh', [LichVanHanhController::class, 'lichVanHanh'])->name('lichvanhanh');
Route::get('/lichsuachua', [LichSuaChuaController::class, 'lichSuaChua'])->name('lichsuachua');
Route::get('/may', [MayController::class, 'may'])->name('may');
