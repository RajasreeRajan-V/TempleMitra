<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\VazhipadController;
use App\Http\Controllers\Admin\receiptsController;
use App\Http\Controllers\Temple\ReceiptPrintingController;
use App\Http\Controllers\Temple\ReceiptReportController;


/*
|--------------------------------------------------------------------------
| Temple Website
|--------------------------------------------------------------------------
*/

Route::get('/temple', function () {
    return view('temple.index');
})->name('temple');


/*
|--------------------------------------------------------------------------
| Admin Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/', [DashboardController::class, 'index'])
    ->name('admin.dashboard');


/*
|--------------------------------------------------------------------------
| Temple Vazhipad & Receipts
|--------------------------------------------------------------------------
*/

Route::prefix('temple')
    ->name('temple.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Vazhipad CRUD
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'vazhipad',
            VazhipadController::class
        );


        /*
        |--------------------------------------------------------------------------
        | Receipts CRUD
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'receipts',
            receiptsController::class
        );


        /*
        |--------------------------------------------------------------------------
        | Receipt Confirmation
        |--------------------------------------------------------------------------
        */

        Route::post(
            'receipts/confirm',
            [receiptsController::class, 'confirm']
        )->name('receipts.confirm');


        /*
        |--------------------------------------------------------------------------
        | Vazhipad Details AJAX
        |--------------------------------------------------------------------------
        */

        Route::get(
            'receipts/vazhipad/{vazhipad}/details',
            [receiptsController::class, 'vazhipadDetails']
        )->name('receipts.vazhipad-details');
    });


/*
|--------------------------------------------------------------------------
| Receipt Printing
|--------------------------------------------------------------------------
*/

Route::prefix('temple/receipt-printing')
    ->name('temple.receipt-printing.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Receipt Printing Index
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/',
            [ReceiptPrintingController::class, 'index']
        )->name('index');


        /*
        |--------------------------------------------------------------------------
        | Show Receipt
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/{receipt}',
            [ReceiptPrintingController::class, 'show']
        )->name('show');


        /*
        |--------------------------------------------------------------------------
        | Print Receipt
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/{receipt}/print',
            [ReceiptPrintingController::class, 'print']
        )->name('print');


        /*
        |--------------------------------------------------------------------------
        | Payment Form
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/{receipt}/payment',
            [ReceiptPrintingController::class, 'paymentForm']
        )->name('payment.form');


        /*
        |--------------------------------------------------------------------------
        | Update Payment
        |--------------------------------------------------------------------------
        */

        Route::patch(
            '/{receipt}/payment',
            [ReceiptPrintingController::class, 'markPayment']
        )->name('payment');
    });


/*
|--------------------------------------------------------------------------
| Temple Reports
|--------------------------------------------------------------------------
|
| Reports:
|
| /temple/reports
| /temple/reports/daily
| /temple/reports/receipts
| /temple/reports/vazhipads
| /temple/reports/devotees
| /temple/reports/collections
|
*/

Route::prefix('temple/reports')
    ->name('temple.reports.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Reports Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/',
            [ReceiptReportController::class, 'index']
        )->name('index');


        /*
        |--------------------------------------------------------------------------
        | Daily Report
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/daily',
            [ReceiptReportController::class, 'daily']
        )->name('daily');


        /*
        |--------------------------------------------------------------------------
        | Receipt Report
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/receipts',
            [ReceiptReportController::class, 'receipts']
        )->name('receipts');


        /*
        |--------------------------------------------------------------------------
        | Vazhipad Report
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/vazhipads',
            [ReceiptReportController::class, 'vazhipads']
        )->name('vazhipads');


        /*
        |--------------------------------------------------------------------------
        | Devotee Report
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/devotees',
            [ReceiptReportController::class, 'devotees']
        )->name('devotees');


        /*
        |--------------------------------------------------------------------------
        | Collection Report
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/collections',
            [ReceiptReportController::class, 'collections']
        )->name('collections');
    });


/*
|--------------------------------------------------------------------------
| User Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/

Route::middleware('auth')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Edit Profile
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/profile',
            [ProfileController::class, 'edit']
        )->name('profile.edit');


        /*
        |--------------------------------------------------------------------------
        | Update Profile
        |--------------------------------------------------------------------------
        */

        Route::patch(
            '/profile',
            [ProfileController::class, 'update']
        )->name('profile.update');


        /*
        |--------------------------------------------------------------------------
        | Delete Profile
        |--------------------------------------------------------------------------
        */

        Route::delete(
            '/profile',
            [ProfileController::class, 'destroy']
        )->name('profile.destroy');
    });


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';