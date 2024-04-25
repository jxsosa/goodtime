<?php

use App\Http\Controllers\Admin\CambioController;
use App\Http\Controllers\Admin\ClienteController;
use App\Http\Controllers\Admin\CuentaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\MovimientoController as AdminMovimientoController;


Route::get('', [HomeController::class, 'index'])->name('admin.home');
Route::get('movimiento/efectivo', [AdminMovimientoController::class, 'efectivo'])->name('admin.movimientos.efectivo');
Route::get('movimiento/usdt', [AdminMovimientoController::class, 'usdt'])->name('admin.movimientos.usdt');
Route::resource('cliente', ClienteController::class)->names('admin.cliente');

Route::resource('cambio', CambioController::class)->names('admin.cambios');
Route::resource('cuenta', CuentaController::class)->names('admin.cuentas');
Route::resource('movimiento', AdminMovimientoController::class)->names('admin.movimientos');