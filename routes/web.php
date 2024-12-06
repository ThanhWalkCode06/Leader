<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admins\UserController;
use App\Http\Middleware\CheckRoleAdminMiddleware;
use App\Http\Controllers\Admins\AccountController;
use App\Http\Controllers\Admins\NhanVienController;


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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/home', function () {
//     return 'Trang chủ>';
// });

// - Routing trong Laravel là chức năng khai báo các đường dẫn
// để đưa người dùng đến các chức năng có trong hệ thống
// - Mỗi một route chỉ sử dụng để trỏ đến 1 chức năng cụ thể

// - Loại 1: Route nạp trực tiếp view




Route::get('/',[AuthController::class, 'showLogin'])->name('login');
Route::post('/login/restore',[AuthController::class, 'login'])->name('restore.login');

Route::get('/register',[AuthController::class, 'showRegister'])->name('register');
Route::post('/register/restore',[AuthController::class, 'register'])->name('restore.register');

Route::get('/reset',[AuthController::class, 'showReset'])->name('reset');
Route::post('/reset/restore',[AuthController::class, 'storeReset'])->name('restore.reset');

Route::get('/getTokenOfPass/{token}',[AuthController::class, 'showResetPass'])->name('getTokenOfPass');
Route::post('/getTokenOfPass/{token}/restore',[AuthController::class, 'storeResetPass'])->name('restore.getTokenOfPass');

Route::get('/pass/edit',[AuthController::class, 'editPass'])->name('edit.pass');
Route::put('/pass/update',[AuthController::class, 'updatePass'])->name('update.pass');

Route::get('/logout',[AuthController::class, 'logout'])->name('logout');

// Route::get('/admin',[AdminSanPhamController::class, 'index'])->middleware(CheckRoleAdminMiddleware::class)->name('admin');

Route::middleware('auth')->group(function(){
    Route::middleware('auth.admin')->group(function(){
        Route::get('/nhanviens/search',[NhanVienController::class, 'search'])->name('nhanviens.search');
        Route::resource('nhanviens',NhanVienController::class);

        Route::get('/users/search',[UserController::class, 'search'])->name('users.search');
        Route::resource('users',UserController::class);
    });
});

