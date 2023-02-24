<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContractsController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

Route::get('/',
    function () {
        return Redirect::route('home');
    });

Auth::routes();
Broadcast::routes();

Route::get('key-auth/{key}', [LoginController::class, 'loginByTaskKey'])->name('auth-by-key');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('tasks', TaskController::class);
    Route::resource('task/{task}/contracts', ContractsController::class)->only(['create', 'show', 'update']);
    Route::post('/contracts/{contract}/start', [App\Http\Controllers\ContractsController::class, 'start'])
        ->name('contracts.start');
    Route::post('/contracts/{contract}/pay', [App\Http\Controllers\ContractsController::class, 'pay'])
        ->name('contracts.pay');

    Route::get('/attachments/{id}', [App\Http\Controllers\ChatAttachmentsController::class, 'show'])
        ->name('attachments.show');

    Route::middleware(['is_admin'])->prefix('admin')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\HomeController::class, 'index'])->name('dashboard');
        Route::resource('users', \App\Http\Controllers\Admin\UsersController::class);
        Route::resource('tasks',
            \App\Http\Controllers\Admin\TaskController::class,
            [
                'names' => [
                    'index'   => 'admin.tasks.index',
                    'create'  => 'admin.tasks.create',
                    'store'   => 'admin.tasks.store',
                    'show'    => 'admin.tasks.show',
                    'edit'    => 'admin.tasks.edit',
                    'update'  => 'admin.tasks.update',
                    'destroy' => 'admin.tasks.destroy',
                ]
            ]);
    });
});
