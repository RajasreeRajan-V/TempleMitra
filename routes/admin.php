<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TempleRegistrationController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\AdminProfileController;

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

        Route::patch('temples-registration/{id}/change-password', [TempleRegistrationController::class, 'changePassword'])
            ->name('temples-registration.change-password');


        Route::get('/settings/profile', [SettingsController::class, 'editProfile'])
            ->name('settings.profile');

        Route::patch('/settings/profile', [SettingsController::class, 'updateProfile'])
            ->name('settings.profile.update');

        Route::get('/settings/password', [SettingsController::class, 'editPassword'])
            ->name('settings.password');

        Route::patch('/settings/password', [SettingsController::class, 'updatePassword'])
            ->name('settings.password.update');


        Route::get('/list', [DashboardController::class, 'templeList'])->name('temples.list');

        Route::get('/notifications', [SettingsController::class, 'notifications'])
            ->name('notifications');

        Route::post('/notifications/check', [SettingsController::class, 'checkOneMonthNotifications'])
            ->name('notifications.check');

        // routes/web.php
        Route::post('/notifications/{id}/send', [NotificationController::class, 'sendSingle'])
            ->name('notifications.send');

        Route::get('/settings/profile', [AdminProfileController::class, 'edit'])
            ->name('settings.profile');
        Route::put('/settings/profile', [AdminProfileController::class, 'update'])
            ->name('settings.profile.update');

        // Settings — Change Password
        Route::get('/settings/password', [AdminProfileController::class, 'editPassword'])
            ->name('settings.password');
        Route::put('/settings/password', [AdminProfileController::class, 'updatePassword'])
            ->name('settings.password.update');
    });