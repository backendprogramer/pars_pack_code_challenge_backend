<?php

use App\Http\Controllers\SubscriptionServiceController;
use Illuminate\Support\Facades\Route;

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
//middleware('auth:sanctum')

Route::get('/store/{platform}/{app}/{user?}', [SubscriptionServiceController::class, 'checkSubscription']);
Route::get('/report/week/{numberWeeks?}', [SubscriptionServiceController::class, 'showLastRecordOfScheduleWeekend']);
