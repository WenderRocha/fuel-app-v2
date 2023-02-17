<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\GoalsController;
use App\Http\Controllers\TradeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\ManagementController;



Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('welcome');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', fn () => Inertia::render('Dashboard', ['title' => 'Dashboard']) )->name('dashboard');
    Route::get('/account', fn () => Inertia::render('Account', ['title' => 'My Account']) )->name('account.index');
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');
    Route::post('/wallet', [WalletController::class, 'store'])->name('wallet.store');
    Route::get('/wallet/{id?}', [WalletController::class, 'show'])->name('wallet.show');

    Route::get('/report', [ReportController::class, 'index'])->name('report.index');

    Route::post('/trade', [TradeController::class, 'store'])->name('trade.store');

    Route::get('/book', [ManagementController::class, 'index'])->name('book.index');

    Route::get('/goals/{id?}', [GoalsController::class, 'index'])->name('goals.index');
    Route::post('/goals', [GoalsController::class, 'store'])->name('goals.store');
});

Route::post('/notify/{type}', function ($type) {
    return back()->toast('This notification comes from the server side =)', $type);
});

Route::get('/dialog/{type}/{position?}', function ($type, $position = null) {
    $page = [
        'modal' => 'WelcomeModal',
        'slideover' => 'WelcomeSlideOver'
    ][$type];

    return Inertia::modal($page)
        ->with([
            'title' => 'One modal to rule them all!',
            'message' => 'That\'s right! I\'m a modal coming from the far, far away kingdom of the Server...',
            'position' => $position
        ])
        ->baseRoute('welcome');
});
