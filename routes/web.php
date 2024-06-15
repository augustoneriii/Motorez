<?php
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\MockApiController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::resource('vehicles', VehicleController::class);
Route::get('/webmotors', [VehicleController::class, 'getWebMotors'])->name('webmotors');
Route::post('/vehicles/insertWebMotors', [VehicleController::class, 'insertWebMotors'])->name('insertWebMotors');
Route::get('/revendaMais', [VehicleController::class, 'getRevendaMais'])->name('revendaMais');
Route::get('/api/v1/estoque', [MockApiController::class, 'webmotors']);
Route::get('/api/estoque', [MockApiController::class, 'revendaMais']);
