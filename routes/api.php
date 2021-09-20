<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmploymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use Illuminate\Http\Request;
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
        //TODO orders - warehouse - inventory
        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
        Route::resource('customers', CustomerController::class);
        Route::resource('suppliers', SupplierController::class);
        Route::resource('employments', EmploymentController::class);
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