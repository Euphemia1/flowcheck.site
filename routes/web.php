<?php

use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\LoginController;
use App\Http\Controllers\Web\PurchaseRequestController;
use App\Http\Controllers\Web\PurchaseOrderController;
use App\Http\Controllers\Web\RfqController;
use App\Http\Controllers\Web\GrnController;
use App\Http\Controllers\Web\ContractController;
use App\Http\Controllers\Web\BoqController;
use App\Http\Controllers\Web\TenderController;
use App\Http\Controllers\Web\BudgetController;
use App\Http\Controllers\Web\ReportController;
use App\Http\Controllers\Web\VendorController;
use App\Http\Controllers\Web\InvoiceController;
use App\Http\Controllers\Web\NotificationController;
use App\Http\Controllers\Web\MfaController;
use App\Http\Controllers\Web\Settings\OrganisationController;
use App\Http\Controllers\Web\Settings\UserManagementController;
use App\Http\Controllers\Web\Settings\DepartmentController;
use App\Http\Controllers\Web\Settings\WorkflowController;
use App\Http\Controllers\Web\Settings\IntegrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

// Auth routes (guest only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:10,1');
});

Route::post('/logout', [LoginController::class, 'destroy'])->name('logout')->middleware('auth');

// MFA verification (auth but pre-mfa)
Route::middleware('auth')->group(function () {
    Route::get('/mfa/verify', [MfaController::class, 'showVerify'])->name('mfa.verify');
    Route::post('/mfa/verify', [MfaController::class, 'verify'])->name('mfa.verify.post');
    Route::get('/mfa/setup', [MfaController::class, 'showSetup'])->name('mfa.setup');
    Route::post('/mfa/setup', [MfaController::class, 'confirmSetup'])->name('mfa.setup.confirm');
});

// Invitation acceptance (guest)
Route::get('/accept-invitation/{token}', [UserManagementController::class, 'acceptInvitation'])->name('invitation.accept');
Route::post('/accept-invitation/{token}', [UserManagementController::class, 'processInvitation'])->name('invitation.process');

// Protected app routes
Route::middleware(['auth', 'mfa.check', 'org.scoped'])->prefix('app')->name('app.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Purchase Requests
    Route::resource('purchase-requests', PurchaseRequestController::class);
    Route::post('/purchase-requests/{purchaseRequest}/submit', [PurchaseRequestController::class, 'submit'])->name('purchase-requests.submit');
    Route::post('/purchase-requests/{purchaseRequest}/approve', [PurchaseRequestController::class, 'approve'])->name('purchase-requests.approve');
    Route::post('/purchase-requests/{purchaseRequest}/reject', [PurchaseRequestController::class, 'reject'])->name('purchase-requests.reject');

    // Purchase Orders
    Route::resource('purchase-orders', PurchaseOrderController::class);
    Route::post('/purchase-orders/{purchaseOrder}/approve', [PurchaseOrderController::class, 'approve'])->name('purchase-orders.approve');
    Route::post('/purchase-orders/{purchaseOrder}/cancel', [PurchaseOrderController::class, 'cancel'])->name('purchase-orders.cancel');
    Route::get('/purchase-orders/{purchaseOrder}/pdf', [PurchaseOrderController::class, 'pdf'])->name('purchase-orders.pdf');

    // RFQs
    Route::resource('rfqs', RfqController::class);
    Route::post('/rfqs/{rfq}/close', [RfqController::class, 'close'])->name('rfqs.close');
    Route::post('/rfqs/{rfq}/select-quote/{quote}', [RfqController::class, 'selectQuote'])->name('rfqs.select-quote');

    // GRNs
    Route::resource('grns', GrnController::class);
    Route::get('/grns/{grn}/pdf', [GrnController::class, 'pdf'])->name('grns.pdf');

    // Contracts
    Route::resource('contracts', ContractController::class);
    Route::post('/contracts/{contract}/close', [ContractController::class, 'close'])->name('contracts.close');

    // BOQs
    Route::resource('boqs', BoqController::class);
    Route::get('/boqs/{boq}/pdf', [BoqController::class, 'pdf'])->name('boqs.pdf');

    // Tenders
    Route::resource('tenders', TenderController::class);
    Route::post('/tenders/{tender}/publish', [TenderController::class, 'publish'])->name('tenders.publish');
    Route::post('/tenders/{tender}/close', [TenderController::class, 'close'])->name('tenders.close');
    Route::post('/tenders/{tender}/award/{submission}', [TenderController::class, 'award'])->name('tenders.award');

    // Vendors
    Route::resource('vendors', VendorController::class);
    Route::post('/vendors/{vendor}/approve', [VendorController::class, 'approve'])->name('vendors.approve');

    // Invoices
    Route::resource('invoices', InvoiceController::class);
    Route::post('/invoices/{invoice}/approve', [InvoiceController::class, 'approve'])->name('invoices.approve');
    Route::get('/invoices/{invoice}/pdf', [InvoiceController::class, 'pdf'])->name('invoices.pdf');

    // Budgets
    Route::resource('budgets', BudgetController::class);

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/spend-by-department', [ReportController::class, 'spendByDepartment'])->name('reports.spend-by-department');
    Route::get('/reports/pr-status', [ReportController::class, 'prStatus'])->name('reports.pr-status');
    Route::get('/reports/invoice-aging', [ReportController::class, 'invoiceAging'])->name('reports.invoice-aging');
    Route::get('/reports/vendor-performance', [ReportController::class, 'vendorPerformance'])->name('reports.vendor-performance');
    Route::get('/reports/audit-trail', [ReportController::class, 'auditTrail'])->name('reports.audit-trail');
    Route::get('/reports/budget-utilisation', [ReportController::class, 'budgetUtilisation'])->name('reports.budget-utilisation');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.read-all');

    // Settings
    Route::get('/settings', [OrganisationController::class, 'index'])->name('settings.index');
    Route::get('/settings/profile', [OrganisationController::class, 'profile'])->name('settings.profile');
    Route::put('/settings/profile', [OrganisationController::class, 'updateProfile'])->name('settings.profile.update');

    Route::get('/settings/users', [UserManagementController::class, 'index'])->name('settings.users.index');
    Route::get('/settings/users/invite', [UserManagementController::class, 'invite'])->name('settings.users.invite');
    Route::post('/settings/users/invite', [UserManagementController::class, 'sendInvitation'])->name('settings.users.send-invitation');
    Route::post('/settings/users/{user}/deactivate', [UserManagementController::class, 'deactivate'])->name('settings.users.deactivate');
    Route::post('/settings/users/{user}/reactivate', [UserManagementController::class, 'reactivate'])->name('settings.users.reactivate');

    Route::resource('settings/departments', DepartmentController::class)->names('settings.departments');

    Route::resource('settings/workflows', WorkflowController::class)->names('settings.workflows');

    Route::get('/settings/plans', [OrganisationController::class, 'plans'])->name('settings.plans');
    Route::get('/settings/integrations', [IntegrationController::class, 'index'])->name('settings.integrations');
});
