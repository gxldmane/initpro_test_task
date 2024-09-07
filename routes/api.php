<?php

use App\Http\Controllers\TenderController;
use Illuminate\Support\Facades\Route;

Route::controller(TenderController::class)->group(function () {
    Route::get('/tenders', 'getTenders');
});
