<?php

use App\Http\Controllers\Api\V1\NewsController;
use App\Http\Controllers\Api\V1\ResourceController;
use App\Http\Controllers\Api\V1\UserAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/', function (Request $request) {
    return response()->json([
        'message' => "Welcome to CMS API. Enjoy fetching data."
    ], 200);
});

Route::post('register', [UserAuthController::class, 'register']);

Route::post('logout', [UserAuthController::class, 'logout'])
    ->middleware('auth:sanctum');
Route::post('login', [UserAuthController::class, 'login']);
Route::post('admin/login', [UserAuthController::class, 'adminLogin']);



/**
 * Route For Guest Users
 */

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function () {
    Route::get("/getNews", [NewsController::class, 'index']);
    Route::get("/getNews/{news}",  [NewsController::class, 'show']);
    Route::apiResource('resources', ResourceController::class)->only(['index', 'show']);
});

/**
 * Route For Admins
 */
Route::group(['prefix' => 'v1/admin', 'namespace' => 'App\Http\Controllers\Api\V1', 'middleware' => 'can:isAdmin'], function () {
    Route::apiResource('news', NewsController::class);
});
