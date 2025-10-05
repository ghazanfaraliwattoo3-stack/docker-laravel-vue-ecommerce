<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\SizeController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\OrderController as AdminOrderController;
use App\Http\Controllers\Front\ProductController as FrontendProductController;
use App\Http\Controllers\Front\AuthController as FrontendAuthController;
use App\Http\Controllers\Front\AccountController;
use App\Http\Controllers\TempImageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PasswrodController;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use SebastianBergmann\CodeCoverage\Report\Xml\Totals;
use App\Http\Controllers\ShippingController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware(['auth:sanctum', 'customer'])->group(function () {
    Route::post('save-order', [OrderController::class, 'saveOrder']);
    Route::get('detail-order/{id}', [OrderController::class, 'orderDetail']);
    Route::get('customer-orders', [OrderController::class, 'customerOrders']);
    Route::get('proudct-image/{id}', [FrontendProductController::class, 'getProductImage']);
    Route::get('customer-detail', [FrontendAuthController::class, 'getCustomerDetail']);
    Route::post('edit-user', [AccountController::class, 'editUserDetail']);
    Route::post('edit-password', [PasswrodController::class, 'editCustomerPassword']);
});

Route::post('admin/login', [AuthController::class, 'authentication']);
Route::post('user/register', [FrontendAuthController::class, 'register']);
Route::post('user/login', [FrontendAuthController::class, 'authentication']);
Route::get('latest-product', [FrontendProductController::class, 'latestProduct']);
Route::get('featured-product', [FrontendProductController::class, 'featuredProduct']);
Route::get('get-products', [FrontendProductController::class, 'getProducts']);
Route::get('get-product/{id}', [FrontendProductController::class, 'getProduct']);
Route::get('get-brands', [FrontendProductController::class, 'getBrands']);
Route::get('get-categories', [FrontendProductController::class, 'getCategories']);
Route::post('filter-products', [FrontendProductController::class, 'filterProducts']);

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    // Route::get('categories',[CategoryController::class,'index']);
    // Route::post('categories',[CategoryController::class,'store']);
    // Route::get('categories/{id}',[CategoryController::class,'show']);
    // Route::put('categories/{id}',[CategoryController::class,'update']);
    // Route::delete('categories/{id}',[CategoryController::class,'destroy']);
    Route::resource('categories', CategoryController::class);
    Route::resource('brands', BrandController::class);
    Route::get('sizes', [SizeController::class, 'index']);
    Route::post('images', [TempImageController::class, 'store']);
    Route::get('tempimages', [TempImageController::class, 'index']);
    Route::get('all-orders', [AdminOrderController::class, 'fetchOrder']);
    Route::get('single-order/{id}', [AdminOrderController::class, 'singleOrderDetail']);
    Route::post('update-order/{id}', [AdminOrderController::class, 'updateOrder']);
    Route::resource('products', ProductController::class);
    Route::get('all-customers', function () {
        $customers = User::where('role', 'customer')->get();
        return response()->json([
            'status' => 200,
            'data' => $customers
        ], 200);
    });
    Route::get('dashboard-statics', function () {
        $totalUsers = User::where('is_block', 1)
            ->where('role', 'customer')
            ->count();

        $totalOrders = Order::count();
        $totalProducts = Product::where('status', 1)->count();
        return response()->json([
            'status' => 200,
            'data' => [
                'users' => $totalUsers,
                'orders' => $totalOrders,
                'products' => $totalProducts,
            ]
        ], 200);
    });
    Route::post('/shipping', [ShippingController::class, 'storeOrCreate']);
});

    Route::get('/shipping', [ShippingController::class, 'index']);
