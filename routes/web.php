<?php

use App\Http\Controllers\RequestController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [RequestController::class, 'index'])->name('request.index');
Route::get('/addRequest', [RequestController::class, 'create'])->name('request.create');
Route::post('/form/submit', [RequestController::class, 'store'])->name('request.store');
Route::get('/cetak/{code}', [RequestController::class, 'show'])->name('request.show');
Route::get('/delete/{id}', [RequestController::class, 'delete'])->name('request.softDelete');
