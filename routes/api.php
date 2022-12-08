<?php

use App\Http\Controllers\UserController;
use App\Models\User;
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

Route::group(['middleware' => ['web']], function () {

    require __DIR__ . '/auth.php';

    Route::get('users', [UserController::class, 'index']);


    Route::middleware(['auth:sanctum'])->group(function () {

        Route::resource('users', UserController::class)->only(['update', 'show']);
    });
});
