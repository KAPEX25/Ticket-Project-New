<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware(['auth:sanctum', 'api.role'])->group(function () {
    Route::get('/tickets', [TicketController::class, 'index']);
    Route::post('/tickets', [TicketController::class, 'store']);
    Route::get('/tickets/{ticket}', [TicketController::class, 'show']);
    Route::put('/tickets/{ticket}', [TicketController::class, 'update']);
    Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy']);
    Route::post('/tickets/{ticket}/assign', [TicketController::class, 'assign']);
    Route::post('/tickets/{ticket}/resolve', [TicketController::class, 'resolve']);
});
