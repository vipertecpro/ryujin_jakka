<?php

use App\Actions\InternalApi;
use App\Http\Controllers\Apps\PublicApiController;
use App\Http\Controllers\DashboardController;
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
Route::prefix('v1')->group(function () {
    Route::post('login',[PublicApiController::class, 'login'])->name('api.login');
    Route::post('register',[PublicApiController::class, 'register'])->name('api.register');
    Route::group(['middleware' => 'auth:sanctum'], function() {
        Route::post('fetchUser', [PublicApiController::class, 'fetchUser'])->name('api.user');
    });
});
