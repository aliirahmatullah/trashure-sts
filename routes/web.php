<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WasteTypeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\RewardRedemptionController;

Route::get('/', [RewardController::class, 'home'])->name('home');
Route::get('/reward/active', [RewardController::class, 'homeReward'])->name('home.reward.active');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/signup', function () {
    return view('auth.signup');
})->name('signup');

Route::post('/signup', [UserController::class, 'register'])->name('signup.register');
Route::post('/login', [UserController::class, 'loginAuth'])->name('login.auth');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

// User area
Route::middleware(['auth', 'isUser'])->prefix('my')->name('user.')->group(function () {
    Route::get('/points', [TransactionController::class, 'myPoint'])->name('points.index');
    Route::get('/redeem/form/{id_hadiah}', [RewardRedemptionController::class, 'form'])->name('redeem.form');
    Route::post('/redeem/{id_hadiah}', [RewardRedemptionController::class, 'store'])->name('redeem.process');
});

// Admin area
Route::middleware('isAdmin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Users
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/edit/{id_user}', [UserController::class, 'edit'])->name('edit');
        Route::put('/update/{id_user}', [UserController::class, 'update'])->name('update');
        Route::delete('/delete/{id_user}', [UserController::class, 'destroy'])->name('delete');
        Route::get('/export', [UserController::class, 'exportExcel'])->name('export');
        Route::get('/trash', [UserController::class, 'trash'])->name('trash');
        Route::patch('/restore/{id_user}', [UserController::class, 'restore'])->name('restore');
        Route::delete('/delete-permanent/{id_user}', [UserController::class, 'deletePermanent'])->name('delete_permanent');
    });

    // Waste Types
    Route::prefix('waste-types')->name('waste-types.')->group(function () {
        Route::get('/', [WasteTypeController::class, 'index'])->name('index');
        Route::get('/create', [WasteTypeController::class, 'create'])->name('create');
        Route::post('/store', [WasteTypeController::class, 'store'])->name('store');
        Route::get('/edit/{id_jenis}', [WasteTypeController::class, 'edit'])->name('edit');
        Route::put('/update/{id_jenis}', [WasteTypeController::class, 'update'])->name('update');
        Route::delete('/delete/{id_jenis}', [WasteTypeController::class, 'destroy'])->name('delete');
        Route::get('/export', [WasteTypeController::class, 'exportExcel'])->name('export');
        Route::get('/trash', [WasteTypeController::class, 'trash'])->name('trash');
        Route::patch('/restore/{id_jenis}', [WasteTypeController::class, 'restore'])->name('restore');
        Route::delete('/delete-permanent/{id_jenis}', [WasteTypeController::class, 'deletePermanent'])->name('delete_permanent');
    });

    // Locations (fixed)
    Route::prefix('locations')->name('locations.')->group(function () {
        // AJAX dropdown kota
        Route::get('api/cities/{province}', [LocationController::class, 'cities'])
            ->name('api.cities');

        // CRUD manual
        Route::get('/', [LocationController::class, 'index'])->name('index');
        Route::get('/create', [LocationController::class, 'create'])->name('create');
        Route::post('/store', [LocationController::class, 'store'])->name('store');
        Route::get('/edit/{id_lokasi}', [LocationController::class, 'edit'])->name('edit');
        Route::put('/update/{id_lokasi}', [LocationController::class, 'update'])->name('update');
        Route::delete('/delete/{id_lokasi}', [LocationController::class, 'destroy'])->name('delete');
        Route::get('/export', [LocationController::class, 'exportExcel'])->name('export');
        Route::get('/trash', [LocationController::class, 'trash'])->name('trash');
        Route::patch('/restore/{id_lokasi}', [LocationController::class, 'restore'])->name('restore');
        Route::delete('/delete-permanent/{id_lokasi}', [LocationController::class, 'deletePermanent'])->name('delete_permanent');
    });

    //Data Reward
    Route::prefix('rewards')->name('rewards.')->group(function () {
        Route::get('/', [RewardController::class, 'index'])->name('index');
        Route::get('/create', [RewardController::class, 'create'])->name('create');
        Route::post('/store', [RewardController::class, 'store'])->name('store');
        Route::get('/edit/{id_reward}', [RewardController::class, 'edit'])->name('edit');
        Route::put('/update/{id_reward}', [RewardController::class, 'update'])->name('update');
        Route::delete('/delete/{id_reward}', [RewardController::class, 'destroy'])->name('delete');
        Route::get('/export', [RewardController::class, 'exportExcel'])->name('export');
        Route::get('/trash', [RewardController::class, 'trash'])->name('trash');
        Route::patch('/restore/{id_hadiah}', [RewardController::class, 'restore'])->name('restore');
        Route::delete('/delete-permanent/{id_hadiah}', [RewardController::class, 'deletePermanent'])->name('delete_permanent');
    });

    //Data Transaksi
    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('index');
        Route::get('/create', [TransactionController::class, 'create'])->name('create');
        Route::post('/store', [TransactionController::class, 'store'])->name('store');
        Route::get('/edit/{id_transaksi}', [TransactionController::class, 'edit'])->name('edit');
        Route::put('/update/{id_transaksi}', [TransactionController::class, 'update'])->name('update');
        Route::delete('/delete/{id_transaksi}', [TransactionController::class, 'destroy'])->name('delete');
        Route::patch('/{transaction}/status', [TransactionController::class, 'updateStatus'])->name('updateStatus');
        Route::get('/export', [TransactionController::class, 'exportExcel'])->name('export');
        Route::get('/trash', [TransactionController::class, 'trash'])->name('trash');
        Route::patch('/restore/{id_transaksi}', [TransactionController::class, 'restore'])->name('restore');
        Route::delete('/delete-permanent/{id_transaksi}', [TransactionController::class, 'deletePermanent'])->name('delete_permanent');
    });

    // Data Redeem Reward
    Route::prefix('redeems')->name('redeems.')->group(function () {
        Route::get('/', [RewardRedemptionController::class, 'index'])->name('index');
        Route::get('/create', [RewardRedemptionController::class, 'create'])->name('create');
        Route::post('/store', [RewardRedemptionController::class, 'store'])->name('store');
        Route::get('/edit/{id_tukar}', [RewardRedemptionController::class, 'edit'])->name('edit');
        Route::put('/update/{id_tukar}', [RewardRedemptionController::class, 'update'])->name('update');
        Route::delete('/delete/{id_tukar}', [RewardRedemptionController::class, 'destroy'])->name('delete');
        Route::patch('/{redeem}/status', [RewardRedemptionController::class, 'updateStatus'])->name('updateStatus');
        Route::get('/export', [RewardRedemptionController::class, 'exportExcel'])->name('export');
        Route::get('/trash', [RewardRedemptionController::class, 'trash'])->name('trash');
        Route::patch('/restore/{id_tukar}', [RewardRedemptionController::class, 'restore'])->name('restore');
        Route::delete('/delete-permanent/{id_tukar}', [RewardRedemptionController::class, 'deletePermanent'])->name('delete_permanent');
    });
});

// Staff area
Route::middleware('isStaff')->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', function () {
        return view('staff.dashboard');
    })->name('dashboard');

    // Transactions
    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('index');
        Route::get('/create', [TransactionController::class, 'create'])->name('create');
        Route::post('/store', [TransactionController::class, 'store'])->name('store');
        Route::get('/edit/{id_transaksi}', [TransactionController::class, 'edit'])->name('edit');
        Route::put('/update/{id_transaksi}', [TransactionController::class, 'update'])->name('update');
        Route::delete('/delete/{id_transaksi}', [TransactionController::class, 'destroy'])->name('delete');
        Route::patch('/{transaction}/status', [TransactionController::class, 'updateStatus'])->name('updateStatus');
        Route::get('/export', [TransactionController::class, 'exportExcel'])->name('export');
        Route::get('/trash', [TransactionController::class, 'trash'])->name('trash');
        Route::patch('/restore/{id_transaksi}', [TransactionController::class, 'restore'])->name('restore');
        Route::delete('/delete-permanent/{id_transaksi}', [TransactionController::class, 'deletePermanent'])->name('delete_permanent');
    });
});
