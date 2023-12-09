<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\RegisteredUserController;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /* Queue Operations */
    Route::post('/jobs/send-mail', [DashboardController::class, 'registerJob'])->name('jobs.send');
    Route::post('/jobs/cancel/{id}', [DashboardController::class, 'cancelJob'])->name('jobs.cancel');
    Route::post('/jobs/retry/{id}', [DashboardController::class, 'retryFailedJob'])->name('jobs.retry');
    Route::post('/jobs/restart/{id}', [DashboardController::class, 'restartSuccessfulJob'])->name('jobs.restart');
    Route::post('/jobs/delete/{id}', [DashboardController::class, 'deleteFailedJob'])->name('jobs.delete');
});

require __DIR__.'/auth.php';
