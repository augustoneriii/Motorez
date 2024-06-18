<?php
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\MockApiController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/js/{filename}', [HomeController::class, 'serveJs'])->name('js');
Route::resource('vehicles', VehicleController::class);
Route::get('/vehicles/check/{idExternal}', [VehicleController::class, 'checkIfExists']);
Route::get('/webmotors', [VehicleController::class, 'getWebMotors'])->name('webmotors');
Route::get('/revendaMais', [VehicleController::class, 'getRevendaMais'])->name('revendaMais');