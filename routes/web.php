<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Pos\SupplierController;
use App\Http\Controllers\Pos\CustomerController;
use App\Http\Controllers\Pos\UnitController;
use App\Http\Controllers\Pos\CategoryController;
use App\Http\Controllers\Pos\ProductController;
use App\Http\Controllers\Pos\PurchaseController;
use App\Http\Controllers\Pos\DefaultController;
use App\Http\Controllers\Pos\InvoiceController;
use App\Http\Controllers\Pos\StockController;











/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {


Route::controller(AdminController::class)->group(function (){
    Route::get('/admin/logout', 'destroy')->name('admin.logout');
    Route::get('/admin/profile', 'Profile')->name('admin.profile');
    Route::get('/edit/profile', 'EditProfile')->name('edit.profile');
    Route::post('/update/profile', 'ProfileUpdate')->name('update.profile');

    Route::get('/change/password', 'ChangePassword')->name('change.password');
    Route::post('/update/password', 'UpdatePassword')->name('update.password');
});

Route::controller(SupplierController::class)->group(function (){
    Route::get('/supplier/all', 'SupplierAll')->name('supplier.all');
    Route::get('/supplier/add', 'SupplierAdd')->name('supplier.add');
    Route::post('/supplier/store', 'SupplierStore')->name('supplier.store');
    Route::get('/supplier/edit/{id}', 'SupplierEdit')->name('supplier.edit');
    Route::post('/supplier/update', 'SupplierUpdate')->name('supplier.update');
    Route::get('/supplier/delete/{id}', 'SupplierDelete')->name('supplier.delete');
});

Route::controller(CustomerController::class)->group(function (){
    Route::get('/customer/all', 'customerAll')->name('customer.all');
    Route::get('/customer/add', 'customerAdd')->name('customer.add');
    Route::post('/customer/store', 'customerStore')->name('customer.store');
    Route::get('/customer/edit/{id}', 'customerEdit')->name('customer.edit');
    Route::post('/customer/update', 'customerUpdate')->name('customer.update');
    Route::get('/customer/delete/{id}', 'CustomerDelete')->name('customer.delete');
    Route::get('/customer/credit', 'CustomerCredit')->name('customer.credit');
    Route::get('/customer/credit/pdf', 'CustomerCreditPdf')->name('customer.credit.pdf');
    Route::get('/edit/customer/invoice/{invoice_id}', 'EditCustomerInvoice')->name('edit.customer.invoice');
    Route::post('/customer/update/invoice/{invoice_id}', 'CustomerUpdateInvoice')->name('customer.update.invoice');
    Route::get('/customer/invoice/details/{invoice_id}', 'CustomerInvoicedetailsPdf')->name('customer.invoice.details.pdf');
    Route::get('/customer/paid', 'CustomerPaid')->name('customer.paid');
    Route::get('/customer/paid/pdf', 'CustomerPaidPdf')->name('customer.paid.pdf');
    Route::get('/customer/wise/report', 'CustomerWiseReport')->name('customer.wise.report');
    Route::get('/customer/wise/credit/pdf', 'CustomerWiseCreditPdf')->name('customer.wise.credit.pdf');
    Route::get('/customer/wise/paid/pdf', 'CustomerWisePaidPdf')->name('customer.wise.paid.pdf');








    



});

Route::controller(UnitController::class)->group(function (){
    Route::get('/unit/all', 'unitAll')->name('unit.all');
    Route::get('/unit/add', 'unitAdd')->name('unit.add');
    Route::post('/unit/store', 'unitStore')->name('unit.store');
    Route::get('/unit/edit/{id}', 'unitEdit')->name('unit.edit');
    Route::post('/unit/update', 'unitUpdate')->name('unit.update');
    Route::get('/unit/delete/{id}', 'unitDelete')->name('unit.delete');

});

Route::controller(CategoryController::class)->group(function (){
    Route::get('/category/all', 'categoryAll')->name('category.all');
    Route::get('/category/add', 'categoryAdd')->name('category.add');
    Route::post('/category/store', 'categoryStore')->name('category.store');
    Route::get('/category/edit/{id}', 'categoryEdit')->name('category.edit');
    Route::post('/category/update', 'categoryUpdate')->name('category.update');
    Route::get('/category/delete/{id}', 'categoryDelete')->name('category.delete');

});

Route::controller(ProductController::class)->group(function (){
    Route::get('/product/all', 'productAll')->name('product.all');
    Route::get('/product/add', 'productAdd')->name('product.add');
    Route::post('/product/store', 'productStore')->name('product.store');
    Route::get('/product/edit/{id}', 'productEdit')->name('product.edit');
    Route::post('/product/update', 'productUpdate')->name('product.update');
    Route::get('/product/delete/{id}', 'productDelete')->name('product.delete');

});

Route::controller(PurchaseController::class)->group(function (){
    Route::get('/purchase/all', 'purchaseAll')->name('purchase.all');
    Route::get('/purchase/add', 'purchaseAdd')->name('purchase.add');
    Route::post('/purchase/store', 'purchaseStore')->name('purchase.store');
    Route::get('/purchase/delete/{id}', 'purchaseDelete')->name('purchase.delete');
    Route::get('/purchase/pending', 'purchasePending')->name('purchase.pending');
    Route::get('/purchase/approve/{id}', 'purchaseApprove')->name('purchase.approve');

    Route::get('/daily/purchase/report', 'DailyPurchaseReport')->name('daily.purchase.report');
    Route::get('/daily/purchase/report/pdf', 'DailyPurchaseReportPdf')->name('daily.purchase.report.pdf');
});



Route::controller(StockController::class)->group(function (){
    Route::get('/stock/report', 'StockReport')->name('stock.report');
    Route::get('/stock/report/pdf', 'StockReportPdf')->name('stock.report.pdf');
    Route::get('/stock/supplier/wise', 'StockSupplierWise')->name('stock.supplier.wise'); 

    Route::get('/supplier/wise/pdf', 'SupplierWisePdf')->name('supplier.wise.pdf');
    Route::get('/product/wise/pdf', 'ProductWisePdf')->name('product.wise.pdf');

});



Route::controller(InvoiceController::class)->group(function (){
    Route::get('/invoice/all', 'invoiceAll')->name('invoice.all');
    Route::get('/invoice/add', 'invoiceAdd')->name('invoice.add');
    Route::post('/invoice/store', 'invoiceStore')->name('invoice.store');
    Route::get('/invoice/pending/list', 'invoicePendingList')->name('invoice.pending.list');
    Route::get('/invoice/delete/{id}', 'invoiceDelete')->name('invoice.delete');
    Route::get('/invoice/approve/{id}', 'invoiceApprove')->name('invoice.approve');
    Route::post('/approval/store/{id}', 'approveStore')->name('approval.store');
    Route::get('/invoice/print/list', 'invoicePrintList')->name('invoice.print.list');
    Route::get('/print/invoice/{id}', 'printInvoice')->name('print.invoice');
    Route::get('/daily/invoice/report', 'dailyInvoiceReport')->name('daily.invoice.report');
    Route::get('/daily/invoice/pdf', 'dailyInvoicePdf')->name('daily.invoice.pdf');
});


});//End Middleware


Route::controller(DefaultController::class)->group(function (){
    Route::get('/get-category', 'GetCategory')->name('get-category');
    Route::get('/get-product', 'GetProduct')->name('get-product');
    Route::get('/get-stock', 'GetStock')->name('get-product-stock');
});



Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
   // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
   // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
   // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
