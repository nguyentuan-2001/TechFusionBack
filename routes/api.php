<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomerController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Product
Route::get('/products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store']);
Route::put('/products/{product}', [ProductController::class, 'update']);
Route::delete('/products/{product}', [ProductController::class, 'destroy']);
Route::get('/products/search', [ProductController::class, 'searchByName']);
Route::get('/products/{category_id}', [ProductController::class, 'getProductsByCategory']);
Route::get('/products/detail/{product_id}', [ProductController::class, 'getProductDetail']);


// Danh sách tất cả sliders
Route::get('/sliders', [SliderController::class, 'index']);

// Hiển thị biểu mẫu tạo slider mới
Route::get('/sliders/create', [SliderController::class, 'create']);

// Lưu slider mới
Route::post('/sliders', [SliderController::class, 'store']);

// Hiển thị chi tiết của một slider cụ thể
Route::get('/sliders/{slider}', [SliderController::class, 'show']);

// Hiển thị biểu mẫu chỉnh sửa một slider cụ thể
Route::get('/sliders/{slider}/edit', [SliderController::class, 'edit']);

// Cập nhật thông tin của một slider cụ thể
Route::put('/sliders/{slider}', [SliderController::class, 'update']);

// Xóa một slider cụ thể
Route::delete('/sliders/{slider}', [SliderController::class, 'destroy']);

// Order
Route::post('/order', [OrderController::class, 'store']);

//Cart
// Route::get('/carts/{customer_id}', [CartController::class, 'index']);
Route::post('/carts', [CartController::class, 'store']);
Route::get('/cart/{customer_id}', [CartController::class, 'getCartProducts']);
Route::delete('/cart/customer/{customer_id}/product/{product_id}', [CartController::class, 'deleteProductFromCart']);
Route::delete('/cart/customer/{customer_id}', [CartController::class, 'deleteAllProductsFromCart']);
Route::put('/cart/customer/{customer_id}/product/{product_id}', [CartController::class, 'update']);

// Customer
Route::post('/customer', [CustomerController::class, 'store']);
Route::post('/customer/login', [CustomerController::class, 'login']);
// Route::get('/customer', [CustomerController::class, 'index']);
Route::put('/customer/{customer}', [CustomerController::class, 'update']);
Route::delete('/customer/{customer}', [CustomerController::class, 'destroy']);