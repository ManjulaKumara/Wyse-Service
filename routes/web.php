<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/sales/create',function(){return view('pages.sales.sales');});

Route::get('/suppliers/all',[ SupplierController::class, 'supplier_index' ]);
Route::get('/suppliers/create',[ SupplierController::class, 'supplier_create' ]);
Route::post('/suppliers/store',[ SupplierController::class, 'supplier_store' ]);

Route::get('/users/all',[ UserController::class, 'users_index' ]);
Route::get('/users/get-all',[ UserController::class, 'users_get_all' ]);
Route::get('/user/create',[ UserController::class, 'user_create' ]);
Route::post('/user/store',[ UserController::class, 'user_store' ]);
Route::get('/user/view/{id}',[ UserController::class, 'user_view' ]);
Route::get('/user/edit/{id}',[ UserController::class, 'user_edit' ]);
Route::post('/user/update/{id}',[ UserController::class, 'user_update' ]);

Route::get('/user-role/all',[ UserRoleController::class, 'user_role_index' ]);
Route::get('/user-role/get-all',[ UserRoleController::class, 'user_role_getAll' ]);
Route::get('/user-role/create',[ UserRoleController::class, 'user_role_create' ]);
Route::post('/user-role/store',[ UserRoleController::class, 'user_role_store' ]);
Route::get('/user-role/view/{id}',[ UserRoleController::class, 'user_role_view' ]);
Route::get('/user-role/edit/{id}',[ UserRoleController::class, 'user_role_edit' ]);
Route::post('/user-role/update/{id}',[ UserRoleController::class, 'user_role_update' ]);

Route::get('/customers/all',[ CustomerController::class, 'customers_index' ]);
Route::get('/customers/create',[ CustomerController::class, 'customers_create' ]);
Route::post('/customers/store',[ CustomerController::class, 'customers_store' ]);

Route::get('/items/all',[ ItemController::class, 'item_index' ]);
Route::get('/items/create',[ ItemController::class, 'item_create' ]);
Route::post('/items/store',[ ItemController::class, 'item_store' ]);

Route::get('/item-category/all',[ ItemCategoryController::class, 'item_category_index' ]);
Route::get('/item-category/create',[ ItemCategoryController::class, 'item_category_create' ]);
Route::post('/item-category/store',[ ItemCategoryController::class, 'item_category_store' ]);

Route::get('/grns/create',function(){return view('pages.grn.grn');});
Route::get('/stock-issues/create',function(){return view('pages.stock-issues.issue');});
Route::get('/supplier-vouchers/create',function(){return view('pages.supplier-voucher.supplier-voucher');});
Route::get('/customer-receipts/create',function(){return view('pages.customer-receipt.customer-receipts');});

Route::get('/suppliers/all',function(){return view('pages.supplier.index');});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
