<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\TypeController;
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


Route::get('/folders', [FolderController::class, 'index']);
Route::get('/folders/{id}', [FolderController::class, 'show']);

Route::get('/files', [FileController::class, 'index']);
Route::get('/files/pg', [FileController::class, 'indexPaginate']);
Route::get('/files/{id}', [FileController::class, 'show']);

Route::get('/types', [TypeController::class, 'index']);
Route::get('/types/{id}', [TypeController::class, 'show']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function (Request $request) {
        return auth()->user();
    });

    Route::resource('/folders', FolderController::class)
        ->only(['store', 'update', 'destroy']);

    Route::resource('/files', FileController::class)
        ->only(['store', 'update', 'destroy']);

    Route::resource('/types', TypeController::class)
        ->only(['store', 'update', 'destroy']);

    Route::post('/logout', [AuthController::class, 'logout']);
});
