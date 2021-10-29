<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/grns/create',function(){return view('pages.grn.grn');});
Route::get('/stock-issues/create',function(){return view('pages.stock-issues.issue');});
Route::get('/supplier-vouchers/create',function(){return view('pages.supplier-voucher.supplier-voucher');});
Route::get('/customer-receipts/create',function(){return view('pages.customer-receipt.customer-receipts');});

Route::get('/suppliers/all',function(){return view('pages.supplier.index');});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
