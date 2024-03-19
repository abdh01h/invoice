<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;


Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

Auth::routes(['register' => false, 'reset' => false, 'verify' => false,]);

Route::group(['middleware' => ['auth']], function()
{

Route::get('/dashboard', [Controllers\DashboardController::class, 'index'])->name('home');

Route::get('/profile', [Controllers\UserProfileController::class, 'index'])->name('profile.index');
Route::put('/profile', [Controllers\UserProfileController::class, 'update'])->name('profile.update');
Route::patch('/profile', [Controllers\UserProfileController::class, 'delete_avatar']);

Route::resource('/roles', Controllers\RoleController::class);
Route::resource('/users', Controllers\UserController::class);

Route::resource('/invoices', Controllers\InvoicesController::class);

Route::resource('/sections', Controllers\SectionsController::class);

Route::resource('/products', Controllers\ProductsController::class);

Route::get('/section/{id}', [Controllers\InvoicesController::class, 'get_products']); // Ajax

Route::get('/invoice_details/{inv}', [Controllers\InvoiceDetailsController::class, 'index'])->name('invoice_details.index');
Route::post('/invoice_details/{id}', [Controllers\InvoiceDetailsController::class, 'update'])->name('attachment.update');
Route::delete('/invoice_details/{id}', [Controllers\InvoiceDetailsController::class, 'destroy']);

Route::get('/payment_status/{invoice}', [Controllers\PaymentStatusController::class, 'show'])->name('payment_status.show');
Route::patch('/payment_status/{invoice}', [Controllers\PaymentStatusController::class, 'update'])->name('payment_status.update');

Route::get('/print_invoice/{invoice}', [Controllers\InvoicesController::class, 'print'])->name('invoice.print');

Route::get('/invoices_paid', [Controllers\InvoicesController::class, 'paid'])->name('invoices.paid');
Route::get('/invoices_unpaid', [Controllers\InvoicesController::class, 'unpaid'])->name('invoices.unpaid');
Route::get('/invoices_partially', [Controllers\InvoicesController::class, 'partially'])->name('invoices.partially');
Route::get('/invoices_archive', [Controllers\InvoicesController::class, 'archive'])->name('invoices.archive');
Route::post('/invoices_archive', [Controllers\InvoicesController::class, 'restore']);

Route::get('/invoices/excel/all', [Controllers\InvoicesController::class, 'export_all'])->name('invoices.excel.all');
Route::get('/invoices/excel/paid', [Controllers\InvoicesController::class, 'export_paid'])->name('invoices.excel.paid');
Route::get('/invoices/excel/partially', [Controllers\InvoicesController::class, 'export_partially'])->name('invoices.excel.partially');
Route::get('/invoices/excel/unpaid', [Controllers\InvoicesController::class, 'export_unpaid'])->name('invoices.excel.unpaid');
Route::get('/invoices/excel/archived', [Controllers\InvoicesController::class, 'export_archived'])->name('invoices.excel.archived');

Route::get('/auditor', [Controllers\AuditorController::class, 'index'])->name('auditor');

Route::get('/invoices_report', [Controllers\InvoicesReportController::class, 'index'])->name('invoices_report');
Route::get('/clients_report', [Controllers\ClientsReportController::class, 'index'])->name('clients_report');

Route::get('/notifications', [Controllers\NotificationsController::class, 'index'])->name('notifications.index');
Route::get('/notifications/mark-all', [Controllers\NotificationsController::class, 'mark_all']);

});

// Frontend pages
Route::get('/{page}', [Controllers\AdminController::class, 'index']);
