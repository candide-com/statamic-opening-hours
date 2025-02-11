<?php

use Illuminate\Support\Facades\Route;
use Candide\StatamicOpeningHours\Http\Controllers\API\OpeningHoursController;

Route::group(['prefix' => 'api', 'middleware' => ['api']], function () {
    Route::get('opening-hours', [OpeningHoursController::class, 'index'])->name('opening-hours.api');
    Route::get('opening-hours/{slug}', [OpeningHoursController::class, 'show'])->name('opening-hours.show');
});
