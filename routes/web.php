<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TestController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/test', [TestController::class, 'index'])->name('test.index');
    Route::get('/cc', [TestController::class, 'clearConfig'])->name('test.clear_config');
    Route::get('/oc', [TestController::class, 'optimizeConfig'])->name('test.optimize_config');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('tickets', TicketController::class)->middleware(['throttle:30,1']);
    Route::post('tickets/{ticket}/messages', [MessageController::class, 'store'])->middleware(['throttle:30,1'])->name('ticket.messages.store');
    Route::delete('tickets/file/{media}', [MediaController::class, 'destroy'])->name('ticket.files.destroy');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('permissions', PermissionController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
});


require __DIR__.'/auth.php';

/** TODO:
 * show user activity on dashboard
 * */
