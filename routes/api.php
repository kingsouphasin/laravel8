<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Models\product;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); 

Route::resource('product', ProductController::class);



// register
Route::post('/products/register',[AuthController::class, 'register']);

// login
Route::post('/login',[AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function (){
    // products
    Route::get('/products',[ProductController::class, 'index']);
    // insert products
    Route::post('/products/insert',[ProductController::class, 'store']);
    // update
    Route::post('/products/update/{id}',[ProductController::class, 'update']);
    // delete
    Route::post('/products/delete/{id}',[ProductController::class, 'destroy']);
    // show id
    Route::get('/products/show/{id}',[ProductController::class, 'show']);
    /// logout
    Route::post('/logout',[AuthController::class, 'logout']);
}); 