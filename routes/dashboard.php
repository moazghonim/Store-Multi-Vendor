<?php

use App\Http\Controllers\Dashboard\AdminsController;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\ImportProductsController;
use App\Http\Controllers\Dashboard\Ordercontroller;
use App\Http\Controllers\Dashboard\Productcontroller;
use App\Http\Controllers\Dashboard\profileController;
use App\Http\Controllers\Dashboard\RolesController;
use App\Http\Controllers\Dashboard\UsersController;
use App\Http\Controllers\DashboardController;
use App\Models\Role;
use Illuminate\Support\Facades\Route;


Route::group([
    'middleware' => ['auth:admin,web'],
    'as' => 'dashboard.',
    'prefix' => 'admin/dashboard'
], function () {

    Route::get('profile', [profileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [profileController::class, 'update'])->name('profile.update');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::put('categories/{category_id}/restore', [CategoriesController::class, 'restore'])->name('categories.restore');

    Route::delete('categories/{category_id}/forcedelete', [CategoriesController::class, 'forcedelete'])->name('categories.forcedelete');

    Route::get('categories/trash', [CategoriesController::class, 'trash'])->name('categories.trash');

    Route::resource('categories', CategoriesController::class);

    Route::get('products/import', [ImportProductsController::class, 'create']);
    Route::post('products/import', [ImportProductsController::class, 'store'])->name('products.import');

    Route::resource('products', Productcontroller::class);

    Route::resource('orders', Ordercontroller::class);

    Route::resource('roles', RolesController::class);

    Route::resource('admins', AdminsController::class);

    Route::resource('users', UsersController::class);


});
