<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\OTController;
use App\Http\Controllers\API\DashboardController;

// Route::controller(AuthController::class)->group(function () {
//     Route::post('login', 'login');
//     Route::post('register', 'register');
//     Route::post('logout', 'logout');
//     Route::post('refresh', 'refresh');
// });

Route::get('/', function() {
    $data = [
        'message' => "Welcome to our API"
    ];
    return response()->json($data, 200);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/user', [AuthController::class, 'getUser']);

Route::middleware('jwt.verify')->group(function() {
    Route::get('/getOrdenTrabajos', [OTController::class, 'getOrdenTrabajos']);
    Route::get('/getOrderId', [OTController::class, 'getOrderId']);
    Route::post('/createWorkOrder', [OTController::class, 'createWorkOrder']);
    Route::get('/getOrdenTrabajosHoy', [OTController::class, 'getOrdenTrabajosHoy']);

    Route::get('/getDataAdmin/{data}', [DashboardController::class, 'getDataAdmin']);
    Route::get('/getLastTrabajosRealizados', [DashboardController::class, 'getLastTrabajosRealizados']);
});
