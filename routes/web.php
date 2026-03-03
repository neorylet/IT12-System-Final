<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\RenterController;
use App\Http\Controllers\Admin\ShelfController;
use App\Http\Controllers\Admin\ShelfAssignmentController;
use App\Http\Controllers\Admin\ProductController;

use App\Http\Controllers\Admin\Inventory\InventoryController;
use App\Http\Controllers\Admin\Inventory\StockInController;
use App\Http\Controllers\Admin\Inventory\StockOutController;
use App\Http\Controllers\Admin\Inventory\AdjustmentController;

/*
|--------------------------------------------------------------------------
| Root Redirect
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'Admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('staff.dashboard');
    }
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Dashboard Redirect
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return auth()->user()->role === 'Admin'
        ? redirect()->route('admin.dashboard')
        : redirect()->route('staff.dashboard');
})->middleware(['auth'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::view('/dashboard', 'admin.dashboard')->name('dashboard');

        // Core Modules
        Route::resource('renters', RenterController::class);
        Route::resource('shelves', ShelfController::class);

        // Shelf Assignment
        Route::get('shelves/{shelf}/assign', [ShelfAssignmentController::class, 'create'])->name('shelves.assign');
        Route::post('shelves/{shelf}/assign', [ShelfAssignmentController::class, 'store'])->name('shelves.assign.store');
        Route::patch('shelves/{shelf}/unassign', [ShelfAssignmentController::class, 'unassign'])->name('shelves.unassign');

        // Products CRUD
        Route::resource('products', ProductController::class);

        // Inventory Dashboard
        Route::get('inventory', [InventoryController::class, 'index'])->name('inventory.index');

        // Stock In
        Route::get('inventory/stock-in', [StockInController::class, 'create'])->name('inventory.stockin.create');
        Route::post('inventory/stock-in', [StockInController::class, 'store'])->name('inventory.stockin.store');

        // Stock Out ✅ (controller-based so blade gets $shelves, etc.)
        Route::get('inventory/stock-out', [StockOutController::class, 'create'])->name('inventory.stockout.create');
        Route::post('inventory/stock-out', [StockOutController::class, 'store'])->name('inventory.stockout.store');

        // Adjustment ✅ (controller-based)
        Route::get('inventory/adjust', [AdjustmentController::class, 'create'])->name('inventory.adjust.create');
        Route::post('inventory/adjust', [AdjustmentController::class, 'store'])->name('inventory.adjust.store');

        // Sales & Financial (front-end only for now)
Route::view('rental-payments', 'admin.rentalpayment.index')->name('rentalpayment.index');
Route::view('renter-payouts', 'admin.renterpayout.index')->name('renterpayout.index');
    });

/*
|--------------------------------------------------------------------------
| STAFF ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Staff'])
    ->prefix('staff')
    ->name('staff.')
    ->group(function () {

        Route::view('/dashboard', 'staff.dashboard')->name('dashboard');

        Route::view('/inventory', 'staff.inventory.index')->name('inventory.index');
    });



/*
|--------------------------------------------------------------------------
| PROFILE ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';