<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CommentController;
use App\Http\Controllers\Api\V1\NewsController;
use App\Http\Controllers\Api\V1\NoticeController;
use App\Http\Controllers\Api\V1\ResourceController;
use App\Http\Controllers\Api\V1\UserAuthController;
use App\Http\Controllers\Api\V1\EventController;
use App\Mail\EventBookedMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
    Route::get("getNews", [NewsController::class, 'index']);
    Route::get("getNews/{news}",  [NewsController::class, 'show']);
    Route::get("getResource", [ResourceController::class, 'index']);
    Route::get("getResource/{resource}", [ResourceController::class, 'show']);
    Route::get("getNotices", [NoticeController::class, 'index']);
    Route::get("getNotice/{notice}", [NoticeController::class, 'show']);
    Route::get("getEvents", [EventController::class, 'index']);
    Route::get("getEvent/{event}", [EventController::class, 'show']);

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('events/{event}/book', [EventController::class, 'book']);
        Route::post('events/{event}/unbook', [EventController::class, 'unbook']);
    });
});


/**
 * Route For Admins
 */
Route::group(['prefix' => 'v1/admin', 'namespace' => 'App\Http\Controllers\Api\V1', 'middleware' => 'auth:sanctum'], function () {
    Route::apiResource('news', NewsController::class);
    Route::apiResource("resource", ResourceController::class);
    Route::apiResource("notices", NoticeController::class);
    Route::apiResource("events", EventController::class);
});

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1', 'middleware' => 'auth:sanctum'], function () {
    Route::apiResource("comments", CommentController::class);
});
