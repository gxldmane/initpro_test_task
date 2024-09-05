<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(\App\Http\Controllers\TenderController::class)->group(function () {
    Route::get('/tenders', 'getTenders');
});
