<?php
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\StockIssueController;
use App\Http\Controllers\GrnController;
use App\Http\Controllers\SupplierVoucherController;
use App\Http\Controllers\CustomerReceiptController;
use App\Http\Controllers\StockReturnController;
use App\Http\Controllers\ItemRelationshipController;
use App\Http\Controllers\ItemConversionController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\DamageController;
use App\Http\Controllers\ReportController;

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
Route::get('/sales/all',[SalesController::class,'sales_index']);
Route::get('/sales/get-all',[SalesController::class,'sales_get_all']);
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

Route::get('/user/all',[ UserController::class, 'users_index' ]);
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
Route::post('/items/update-price',[ ItemController::class, 'update_price' ]);

Route::get('/item-category/all',[ ItemCategoryController::class, 'item_category_index' ]);
Route::get('/item-category/get-all',[ ItemCategoryController::class, 'item_category_get_all' ]);
Route::get('/item-category/create',[ ItemCategoryController::class, 'item_category_create' ]);
Route::post('/item-category/store',[ ItemCategoryController::class, 'item_category_store' ]);
Route::get('/item-category/view/{id}',[ ItemCategoryController::class, 'item_category_view' ]);
Route::get('/item-category/edit/{id}',[ ItemCategoryController::class, 'item_category_edit' ]);
Route::post('/item-category/update/{id}',[ ItemCategoryController::class, 'item_category_update' ]);

Route::get('/services/all',[ ServiceController::class, 'service_index' ]);
Route::get('/services/get-all',[ ServiceController::class, 'service_get_all' ]);
Route::get('/services/create',[ ServiceController::class, 'service_crete' ]);
Route::post('/services/store',[ ServiceController::class, 'service_store' ]);
Route::get('/services/view/{id}',[ ServiceController::class, 'service_view' ]);
Route::get('/services/edit/{id}',[ ServiceController::class, 'service_edit' ]);
Route::post('/services/update/{id}',[ ServiceController::class, 'service_update' ]);

Route::get('/grns/all',[GrnController::class,'grn_index']);
Route::get('/grns/get_all',[GrnController::class,'grn_get_all']);
Route::get('/grns/create',[GrnController::class,'create']);
Route::post('/grns/store',[GrnController::class,'store']);

Route::get('/stock-issues/all',[StockIssueController::class,'stock_issue_index']);
Route::get('/stock-issues/get-all',[StockIssueController::class,'stock_issue_get_all']);
Route::get('/stock-issues/create',[StockIssueController::class,'createIssues']);
Route::post('/stock-issues/store',[StockIssueController::class,'store']);

Route::get('/stock-returns/create',[StockReturnController::class,'create']);
Route::post('/stock-returns/store',[StockReturnController::class,'store']);

Route::get('/supplier-vouchers/create',[SupplierVoucherController::class,'create']);
Route::post('/supplier-vouchers/store',[SupplierVoucherController::class,'store']);

Route::get('/customer-receipts/all',[CustomerReceiptController::class,'customer_receipt_index']);
Route::get('/customer-receipts/get-all',[CustomerReceiptController::class,'customer_receipt_get_all']);
Route::get('/customer-receipts/create',[CustomerReceiptController::class,'create']);
Route::post('/customer-receipts/store',[CustomerReceiptController::class,'store']);

Route::get('/item-relationship/create',[ItemRelationshipController::class,'create']);
Route::post('/item-relationship/store',[ItemRelationshipController::class,'store']);

Route::get('/item-conversion/create',[ItemConversionController::class,'create']);
Route::post('/item-conversion/store',[ItemConversionController::class,'store']);

Route::get('/item-damages/all',[DamageController::class,'damage_index']);
Route::get('/item-damages/get-all',[DamageController::class,'damage_get_all']);
Route::get('/item-damages/create',[DamageController::class,'create']);
Route::post('/item-damages/store',[DamageController::class,'store']);

Route::get('/expense/create',[ExpenseController::class,'create']);
Route::post('/expense/store',[ExpenseController::class,'store']);

Route::get('/open-stock/all',[ StockController::class, 'open_stock_index' ]);
Route::get('/open-stock/get-all',[ StockController::class, 'open_stock_get_all' ]);
Route::get('/open-stock/create',[ StockController::class, 'open_stock_create' ]);
Route::post('/open-stock/store',[ StockController::class, 'open_stock_store' ]);

Route::get('/module/all',[ ModuleController::class, 'module_index' ]);
Route::get('/module/get-all',[ ModuleController::class, 'module_get_all' ]);
Route::get('/module/create',[ ModuleController::class, 'module_create' ]);
Route::post('/module/store',[ ModuleController::class, 'module_store' ]);
Route::get('/module/view/{id}',[ ModuleController::class, 'module_view' ]);
Route::get('/module/edit/{id}',[ ModuleController::class, 'module_edit' ]);
Route::post('/module/update/{id}',[ ModuleController::class, 'module_update' ]);

Route::group(['prefix'=>'ajax'],function(){
    Route::get('/stock-issues-by-vehicle/{vehicle}',[SalesController::class,'getStockIssuesForVehicle']);
    Route::get('/items-n-services',[SalesController::class,'getItemsAndServices']);
    Route::get('/items',[SalesController::class,'getItems']);
    Route::get('/services',[SalesController::class,'getServices']);
    Route::get('/unpaid-grns/{supplier}',[SupplierVoucherController::class,'get_pending_grns']);
    Route::get('/unpaid-invoices/{customer}',[CustomerReceiptController::class,'get_pending_invoices']);
    Route::get('/child-items/{parent}',[ItemConversionController::class,'get_child_items']);
});

Route::group(['prefix'=>'reports'],function(){
    Route::get('/price-list',[ReportController::class,'price_list']);
    Route::get('/sales-report',[ReportController::class,'sales_reports']);
    Route::post('/sales-report',[ReportController::class,'fill_sales_reports']);

});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
