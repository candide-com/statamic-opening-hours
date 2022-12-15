<?php

use InsightMedia\StatamicOpeningHours\Controllers\OpeningHoursController;

Route::get('opening-hours', '\\'. OpeningHoursController::class)->name('opening-hours.index');
Route::post('opening-hours', ['\\'. OpeningHoursController::class, 'store'])->name('opening-hours.store');
