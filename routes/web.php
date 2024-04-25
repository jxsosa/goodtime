<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\MovimientoController;
use Illuminate\Support\Facades\Route;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use App\Http\Controllers\Admin\MovimientoController as AdminMovimientoController;

use function Laravel\Prompts\table;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/* Route::get('/', function () {
    return view('admin.home');
}); */
Route::get('/', [HomeController::class, 'index'])->name('admin.home');



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/admin', function () {
        return view('dashboard');
    })->name('dashboard');
    
});
