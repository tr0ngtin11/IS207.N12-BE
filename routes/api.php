<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DatHangController;
use App\Http\Controllers\HoaDonController;
use App\Http\Controllers\NguoiDungController;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\ThanhToanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });




//  Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::apiResource('posts', PostController::class);
 Route::post('/auth/register', [AuthController::class, 'createUser']);
 Route::post('/auth/login', [AuthController::class, 'loginUser']);
Route::get('/auth/forgotpw', [AuthController::class, 'forgotpw']);
Route::post('/auth/resetpw', [AuthController::class, 'resetPassword']);
Route::get('/auth/checkEmail/{email}', [AuthController::class, 'checkEmailExist']);
//  Route::post('/auth/logout',[AuthController::class,'logoutUser']);
Route::apiResource('sanpham', SanPhamController::class);

 Route::group(['middleware'=>['auth:sanctum']],function(){
    Route::resource('/task', TasksController::class);
    Route::post('/auth/logout', [AuthController::class, 'logoutUser']);
    Route::post('/thanhtoan', [ThanhToanController::class, 'thanhToan']);
    Route::apiResource('blog', BlogController::class);
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::get('/donhang/{id}', [DatHangController::class, 'GetDonHang']);
    Route::get('/hoadon/{id}', [HoaDonController::class, 'GetHoaDon']);
    Route::put('/user/{nguoidung}', [AuthController::class, 'updateUser']);
    Route::post('/user/changepassword/{nguoidung}', [AuthController::class, 'changePassword']);
});





 