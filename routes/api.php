<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmploymentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegularUserController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\WarehouseController;
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

function common(string $scope){
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware(['auth:sanctum', $scope])->group(function(){
        Route::get('user', [AuthController::class, 'user']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::put('users/profile', [AuthController::class, 'updateProfile']);
        Route::put('users/password', [AuthController::class, 'updatePassword']);
    });
}
//Admin
Route::prefix('admin')->group(function(){
    common('scope.admin');

    Route::middleware(['auth:sanctum', 'scope.admin'])->group(function(){
        //TODO inventory
        Route::get('regular-users', [RegularUserController::class, 'index']);
        Route::apiResource('categories', CategoryController::class);
        Route::apiResource('products', ProductController::class);
        Route::post('products-import', [ProductController::class, 'importCsv']);
        Route::get('products-batch', [ProductController::class, 'productImportProgress']);
        Route::apiResource('customers', CustomerController::class);
        Route::apiResource('suppliers', SupplierController::class);
        Route::apiResource('employments', EmploymentController::class);
        Route::apiResource('warehouses', WarehouseController::class);
        Route::get('orders', [OrderController::class, 'index']);
    });
});

//Regular User
Route::prefix('regularUser')->group(function(){
    common('scope.regularUser');
    Route::middleware(['auth:sanctum', 'scope.regularUser'])->group(function(){
        //TODO stats or rankings
        Route::get('categories', [CategoryController::class, 'index']); 
        Route::get('products', [ProductController::class, 'index']);
        Route::get('products/filter', [ProductController::class, 'filters']);
    }); 
});

Route::prefix('checkout')->group(function(){
    Route::post('orders', [OrderController::class, 'store']);
});