<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\StockIssueController;
use App\Http\Controllers\GrnController;

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
Route::get('/sales/create',[SalesController::class,'create']);
Route::post('/sales/store',[SalesController::class,'store']);
Route::get('/sales/invoice/{id}',[SalesController::class,'invoice']);

Route::get('preview-bill',function(){return view('pages.sales.print');});

Route::get('/suppliers/all',[ SupplierController::class, 'supplier_index' ]);
Route::get('/suppliers/get-all',[ SupplierController::class, 'supplier_get_all' ]);
Route::get('/suppliers/create',[ SupplierController::class, 'supplier_create' ]);
Route::post('/suppliers/store',[ SupplierController::class, 'supplier_store' ]);
Route::get('/suppliers/view/{id}',[ SupplierController::class, 'supplier_view' ]);
Route::get('/suppliers/edit/{id}',[ SupplierController::class, 'supplier_edit' ]);
Route::post('/suppliers/update/{id}',[ SupplierController::class, 'supplier_update' ]);

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
Route::get('/customers/get-all',[ CustomerController::class, 'customers_get_all' ]);
Route::get('/customers/create',[ CustomerController::class, 'customers_create' ]);
Route::post('/customers/store',[ CustomerController::class, 'customers_store' ]);
Route::get('/customers/view/{id}',[ CustomerController::class, 'customers_view' ]);
Route::get('/customers/edit/{id}',[ CustomerController::class, 'customers_edit' ]);
Route::post('/customers/update/{id}',[ CustomerController::class, 'customers_update' ]);

Route::get('/items/all',[ ItemController::class, 'item_index' ]);
Route::get('/items/get-all',[ ItemController::class, 'item_get_all' ]);
Route::get('/items/create',[ ItemController::class, 'item_create' ]);
Route::post('/items/store',[ ItemController::class, 'item_store' ]);
Route::get('/items/view/{id}',[ ItemController::class, 'item_view' ]);
Route::get('/items/edit/{id}',[ ItemController::class, 'item_edit' ]);
Route::post('/items/update/{id}',[ ItemController::class, 'item_update' ]);

Route::get('/item-category/all',[ ItemCategoryController::class, 'item_category_index' ]);
Route::get('/item-category/get-all',[ ItemCategoryController::class, 'item_category_get_all' ]);
Route::get('/item-category/create',[ ItemCategoryController::class, 'item_category_create' ]);
Route::post('/item-category/store',[ ItemCategoryController::class, 'item_category_store' ]);
Route::get('/item-category/view/{id}',[ ItemCategoryController::class, 'item_category_view' ]);
Route::get('/item-category/edit/{id}',[ ItemCategoryController::class, 'item_category_edit' ]);
Route::post('/item-category/update/{id}',[ ItemCategoryController::class, 'item_category_update' ]);

Route::get('/sevices/all',[ ServiceController::class, 'service_index' ]);
Route::get('/sevices/get-all',[ ServiceController::class, 'service_get_all' ]);
Route::get('/sevices/create',[ ServiceController::class, 'service_crete' ]);
Route::post('/sevices/store',[ ServiceController::class, 'service_store' ]);
Route::get('/sevices/view/{id}',[ ServiceController::class, 'service_view' ]);
Route::get('/sevices/edit/{id}',[ ServiceController::class, 'service_edit' ]);
Route::post('/sevices/update/{id}',[ ServiceController::class, 'service_update' ]);

Route::get('/grns/create',[GrnController::class,'create']);
Route::get('/stock-issues/create',[StockIssueController::class,'createIssues']);
Route::post('/stock-issues/store',[StockIssueController::class,'store']);
Route::get('/supplier-vouchers/create',function(){return view('pages.supplier-voucher.supplier-voucher');});
Route::get('/customer-receipts/create',function(){return view('pages.customer-receipt.customer-receipts');});

Route::get('/open-stock/all',[ StockController::class, 'open_stock_index' ]);
Route::get('/open-stock/get-all',[ StockController::class, 'open_stock_get_all' ]);
Route::get('/open-stock/create',[ StockController::class, 'open_stock_create' ]);
Route::post('/open-stock/store',[ StockController::class, 'open_stock_store' ]);

Route::group(['prefix'=>'ajax'],function(){
    Route::get('/stock-issues-by-vehicle/{vehicle}',[SalesController::class,'getStockIssuesForVehicle']);
    Route::get('/items-n-services',[SalesController::class,'getItemsAndServices']);
    Route::get('/items',[SalesController::class,'getItems']);
    Route::get('/services',[SalesController::class,'getServices']);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
