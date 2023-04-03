<?php

use App\Http\Controllers\ActiviteController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ReservationSiteController;
use App\Http\Controllers\SiteDateController;
use App\Http\Controllers\SitesController;
use App\Http\Controllers\UserController;
use App\Models\Media;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    Route::apiResource('media', MediaController::class)->only(["store", "show", "destroy", "index"]);
    Route::apiResource('site', SitesController::class);
    Route::post('site/{site}/activite', [SitesController::class, 'addActivite']);
    Route::patch('site/{site}/activite/{activite}', [SitesController::class, 'updateActivite']);
    Route::delete('site/{site}/activite/{activite}', [SitesController::class, 'removeActivite']);
    Route::apiResource('date-site', SiteDateController::class);
    Route::apiResource('activite', ActiviteController::class)->except(['update']);
    Route::post('activite/{activite}', [ActiviteController::class, 'update']);
    Route::post('activite/{activite}/site', [ActiviteController::class, 'addSite']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::apiResource('user', UserController::class)->except(['index', 'store', 'update']);
        Route::post('user/{user}', [UserController::class, 'update']);

        Route::apiResource('reservation-site', ReservationSiteController::class);
        Route::get('reservation-site/user/{user}', [ReservationSiteController::class, 'getReservationSiteByUser']);


        Route::post('reservation-site/{reservationSite}/activite', [ReservationSiteController::class, 'addActivite']);
        Route::put('reservation-site/{reservationSite}/validate', [ReservationSiteController::class, 'validated']);
        Route::put('reservation-site/{reservationSite}/cancel', [ReservationSiteController::class, 'cancel']);
        Route::put('reservation-site/{reservationSite}/pay', [ReservationSiteController::class, 'pay']);
        Route::put('reservation-site/{reservationSite}/refuse', [ReservationSiteController::class, 'refused']);
    });
});
