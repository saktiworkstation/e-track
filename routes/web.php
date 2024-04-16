<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandPageController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [LandPageController::class, 'index']);

Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/register', [AuthController::class, 'register'])->middleware('guest');
Route::post('/register', [AuthController::class, 'store']);

Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware('auth');

//* user tiket
// user tickets & tickets page for user
Route::get('/dashboard/tickets', [TicketController::class, 'index'])->middleware('auth');
// create ticket
Route::get('/dashboard/tickets/create', [TicketController::class, 'create'])->middleware('auth')->middleware('admin');
Route::post('/dashboard/tickets', [TicketController::class, 'store'])->middleware('auth')->middleware('admin');
// user tickets & tickets page for admin
Route::get('/dashboard/tickets/manage', [TicketController::class, 'manage'])->middleware('auth')->middleware('admin');
// edit ticket
Route::get('/dashboard/tickets/{id}/edit', [TicketController::class, 'edit'])->middleware('auth')->middleware('admin');
Route::put('/dashboard/tickets/{id}/edit', [TicketController::class, 'update'])->middleware('auth')->middleware('admin');
// delete ticket
Route::delete('/dashboard/tickets/{id}/delete', [TicketController::class, 'destroy'])->middleware('auth')->middleware('admin');
// use user ticket
Route::get('/dashboard/tickets/submit', [TicketController::class, 'useTicket'])->middleware('auth');
