<?php

use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\Ordercontroller;
use App\Http\Controllers\Dashboard\Productcontroller;
use App\Http\Controllers\Dashboard\profileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['auth', 'auth.user:admin,super-admin']], function () {


    Route::get('/profile/edit', [profileController::class, 'edit'])->name('profiles.edit');
    Route::patch('profile/update', [profileController::class, 'update'])->name('profiles.update');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::put('categories/{category_id}/restore', [CategoriesController::class, 'restore'])->name('categories.restore');

    Route::delete('categories/{category_id}/forcedelete', [CategoriesController::class, 'forcedelete'])->name('categories.forcedelete');
    
    Route::get('categories/trash', [CategoriesController::class, 'trash'])->name('categories.trash');

    Route::resource('categories', CategoriesController::class)->names([
        'index'   => 'categories',
        'create'  => 'categories.create',
        'store'   => 'categories.store',
        'show'    => 'categories.show',
        'edit'    => 'categories.edit',
        'update'  => 'categories.update',
        'destroy' => 'categories.destroy'
    ]);

    Route::resource('products', Productcontroller::class)->names([
        'index'   => 'products',
        'create'  => 'products.create',
        'store'   => 'products.store',
        'show'    => 'products.show',
        'edit'    => 'products.edit',
        'update'  => 'products.update',
        'destroy' => 'products.destroy'
    ]);

    Route::resource('orders', Ordercontroller::class)->names([
        'index'   => 'orders',
        'create'  => 'orders.create',
        'store'   => 'orders.store',
        'show'    => 'orders.show',
        'edit'    => 'orders.edit',
        'update'  => 'orders.update',
        'destroy' => 'orders.destroy'
    ]);
});
