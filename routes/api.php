<?php

use App\Http\Controllers\DepartementController;
use App\Http\Controllers\SitesController;
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

Route::prefix('v1')->middleware(['web'])->group(function () {
    Route::get('/', function () {
        return [
            'Laravel' => app()->version(),
            'PHP' => phpversion(),
            'OS' => php_uname('s'),
            'OS Version' => php_uname('r'),
            'OS Architecture' => php_uname('m'),
            'OS Release' => php_uname('v'),
            'OS Hostname' => php_uname('n'),
            'OS Domain' => php_uname('d'),
            'OS Kernel' => php_uname('a'),
        ];
    });
    require __DIR__ . '/auth.php';
    Route::get('user', [UserController::class, 'index']);
    Route::apiResource('departement', DepartementController::class);
    Route::apiResource('site', SitesController::class);
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::apiResource('user', UserController::class)->only(['update', 'show']);
    });
});
