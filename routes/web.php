<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\StockIssueController;

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

Route::get('/suppliers/all',[ SupplierController::class, 'supplier_index' ]);
Route::get('/suppliers/create',[ SupplierController::class, 'supplier_create' ]);
Route::post('/suppliers/store',[ SupplierController::class, 'supplier_store' ]);

Route::get('/users/all',[ UserController::class, 'users_index' ]);
Route::get('/user/create',[ UserController::class, 'user_create' ]);
Route::post('/user/store',[ UserController::class, 'user_store' ]);

Route::get('/user-role/all',[ UserRoleController::class, 'user_role_index' ]);
Route::get('/user-role/get-all',[ UserRoleController::class, 'user_role_getAll' ]);
Route::get('/user-role/create',[ UserRoleController::class, 'user_role_create' ]);
Route::post('/user-role/store',[ UserRoleController::class, 'user_role_store' ]);

Route::get('/customers/all',[ CustomerController::class, 'customers_index' ]);
Route::get('/customers/create',[ CustomerController::class, 'customers_create' ]);
Route::post('/customers/store',[ CustomerController::class, 'customers_store' ]);

Route::get('/grns/create',function(){return view('pages.grn.grn');});
Route::get('/stock-issues/create',[StockIssueController::class,'createIssues']);
Route::post('/stock-issues/store',[StockIssueController::class,'store']);
Route::get('/supplier-vouchers/create',function(){return view('pages.supplier-voucher.supplier-voucher');});
Route::get('/customer-receipts/create',function(){return view('pages.customer-receipt.customer-receipts');});

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
