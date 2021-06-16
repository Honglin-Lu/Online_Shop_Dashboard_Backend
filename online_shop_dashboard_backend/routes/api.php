<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\ContractController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\ProductCategoryController;



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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::Resource('feedback', FeedbackController::class);
Route::Resource('department', DepartmentController::class);
Route::Resource('employee', EmployeeController::class);
Route::Resource('contract', ContractController::class);
Route::Resource('customer', CustomerController::class);
Route::Resource('supplier', SupplierController::class);
Route::Resource('product-category', ProductCategoryController::class);
