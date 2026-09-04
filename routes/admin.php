<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TempleRegistrationController;
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth:admin'])
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('temples-registration', TempleRegistrationController::class);
        Route::patch('temples-registration/{id}/activate', [TempleRegistrationController::class, 'activate'])
        ->name('temples-registration.activate');
    
        Route::patch('temples-registration/{id}/deactivate', [TempleRegistrationController::class, 'deactivate'])
            ->name('temples-registration.deactivate');
        
        Route::post('temples-registration/{id}/generate-password', [TempleRegistrationController::class, 'generatePassword'])
            ->name('temples-registration.generate-password');
    });