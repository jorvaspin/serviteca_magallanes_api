<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\OTController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\EventsController;


// RUTAS API
// Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/user', [AuthController::class, 'getUser']);

Route::middleware('jwt.verify')->group(function() {
    Route::get('/getWorkOrders', [OTController::class, 'getWorkOrders']);
    Route::get('/getOrderId', [OTController::class, 'getOrderId']);
    Route::post('/createWorkOrder', [OTController::class, 'createWorkOrder']);
    Route::get('/getWorksToday', [OTController::class, 'getWorksToday']);
    Route::get('/getLastWeekData/{id}', [OTController::class, 'getLastWeekData']);
    // get all events
    Route::get('/getAllEvents', [EventsController::class, 'getAllEvents']);
    // delete event
    Route::post('/deleteEvent', [EventsController::class, 'deleteEvent']);
    // save individual event
    Route::post('/saveEvent', [EventsController::class, 'saveEvent']);

    Route::get('/getDataAdmin/{data}', [DashboardController::class, 'getDataAdmin']);
    Route::get('/getLastWorksCompleted', [DashboardController::class, 'getLastWorksCompleted']);
});
