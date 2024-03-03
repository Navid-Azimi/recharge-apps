<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\CardBrandController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\NetworkCommissionsController;
use App\Http\Controllers\PackagesComissionRatesController;
use App\Http\Controllers\PackagesController;
use App\Http\Controllers\NetworkController;
use App\Http\Controllers\GiftCardController;
use App\Http\Controllers\TopupsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CountryRateController;
use App\Http\Controllers\GiftCardsController;
use App\Http\Controllers\GiftCardTypesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OperatorContactController;
use App\Http\Controllers\PromoCodesController;

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

Route::middleware(['auth', 'reseller'])->group(function () {
    Route::get('/reseller-payments', [PaymentController::class, 'index'])->name('reseller_list');
    Route::get('/reseller-buy_gifts', [CardBrandController::class, 'buyGifts']);
    Route::get('/reseller-my_gifts', [CardBrandController::class, 'myGifts']);
    Route::get('/export-payments', [PaymentController::class, 'excelExport'])->name('payments_export');
    Route::post('reseller-topup', [TopupsController::class, 'doTopup'])->name('topup');
    Route::post('reseller-send-gift-card', [GiftCardsController::class, 'resellerSendGiftCardToCustomer'])->name('resellers.gitcard.send');
    Route::get('reseller-wallet', [PaymentController::class, 'createPayment'])->name('create.payment');
    Route::post('reseller-payment', [PaymentController::class, 'resellerPayment'])->name('reseller_payment');
    Route::post('reseller-card', [PaymentController::class, 'storeCard'])->name('reseller_card');
    Route::post('auto-recharge-status/{userId}', [PaymentController::class, 'setAutoRechargeStatus'])->name('auto_recharge_status');
    Route::post('auto-recharge-amount/{userId}', [PaymentController::class, 'setAutoRechargeAmount'])->name('auto_recharge_amount');
    Route::post('auto-recharge-balance/{userId}', [PaymentController::class, 'setAutoRechargeBalance'])->name('auto_recharge_balance');
    Route::get('reseller-dashboard', [DashboardController::class, 'index'])->name('reseller_dashboard');
    Route::get('get_network_packages', [PackagesComissionRatesController::class, 'getNetworkPackages'])->name('get_network_packages');
    Route::get('reports', [ReportController::class, 'reports'])->name('reports');
    Route::get('manage-resellers', [ReportController::class, 'resellersList'])->name('manage_resellers');
    Route::get('create-balance/{id}', [ReportController::class, 'createBalance'])->name('resellers_create_balance');
    Route::get('edit-balance/{id}', [ReportController::class, 'editBalance'])->name('resellers_edit_balance');
    Route::post('store-balance', [ReportController::class, 'storeBalance'])->name('resellers_store_balance');
    Route::post('update-balance/{id}', [ReportController::class, 'updateBalance'])->name('resellers_update_balance');
    Route::get('get_phone_network_data', [NetworkController::class, 'get_phone_network_data']);
    Route::get('/get-tax/{countryCode}', [PackagesController::class, 'getTax']);
    Route::get('/get-exchange-rates', [PackagesController::class, 'getExchangeRates']);
    Route::get('/gift_type_list', [CardBrandController::class, 'giftTypeList'])->name('giftTypeList');
    Route::post('/buy-gift', [TopupsController::class, 'buyGift'])->name('buy-gift');
    Route::get('manage-reseller-req', [ReportController::class, 'requestsReseller'])->name('requests_reseller');
});


Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('admin-dashboard', [DashboardController::class, 'index'])->name('admin_dashboard');
    Route::resource('users', 'App\Http\Controllers\UserController');

    Route::resource('networks', NetworkController::class);
    Route::resource('giftcard', GiftCardController::class);
    Route::resource('giftcards', GiftCardsController::class);
    Route::resource('giftcardbrands', CardBrandController::class);
    Route::resource('giftcardtypes', GiftCardTypesController::class);
    Route::resource('packages', PackagesController::class);
    Route::get('payment-history', [PaymentController::class, 'index'])->name('payment_history');
    Route::resource('commissions', NetworkCommissionsController::class);  # This is the network commission.
    Route::resource('pac_com_rates', PackagesComissionRatesController::class);
    Route::resource('configurations', ConfigurationController::class);
    Route::resource('announcements', AnnouncementController::class);
    Route::resource('promocodes', PromoCodesController::class);
    Route::get('transactions', [TopupsController::class, 'transactions'])->name('transactions');
    Route::resource('country_rate_and_tax', CountryRateController::class);
    Route::get('/topup/{id}', [TopupsController::class, 'show_topups_detailse'])->name('topup.details');
    Route::get('/all-users', [UserController::class, 'getAllUsers']);
    Route::get('/users-by-role/{role}', [UserController::class, 'getUsersByRole']);
    Route::get('/all-networks', [NetworkController::class, 'getAllNetworks']);
    Route::get('/networks-by-iso/{isoCode}', [NetworkController::class, 'networks_by_country'])->name('network_by_iso');
    Route::get('reseller-reports', [ReportController::class, 'resellerReports'])->name('reseller_reports');
    Route::get('customer-reports', [ReportController::class, 'cusotmerReports'])->name('customer_reports');
    Route::get('customer-giftcards-reports', [GiftCardsController::class, 'giftCardsReports'])->name('giftcards_reports');
    Route::view('backup-panel', 'laravel_backup_panel::layout')->name('backup-panel.index');

    Route::get('taking_backup', function () {
        Artisan::call('backup:run --only-db --disable-notifications');
        Artisan::output();
        return redirect()->back()->with('success', 'Success Operation.');
    })->name('backup');

    Route::resource('networks_contact', OperatorContactController::class);

    Route::get('pre_package', 'DashboardController@pre_package')->name('pre_package');
});

Route::get('/', function () {

    switch (auth()->user()?->user_role) {
        case 'admin':
            return redirect()->route('admin_dashboard');
            break;
        case 'reseller':
            return redirect()->route('reseller_dashboard');
            break;
        default:
            return redirect()->route('login');
    }
});
Route::view('/services', 'services')->name('services');

Route::view('/summary', 'layouts.summary')->name('summary');
Route::view('/public_request', 'layouts.public_request')->name('public_request');

Route::post('/process-form', [TopupsController::class, 'processForm'])->name('process_form');

Route::get('/summary', [TopupsController::class, 'showPackageDetails'])->name('summary');

Route::controller(PaymentController::class)->group(function () {
    // Route::view('payment', 'paypal.index')->name('create.payment');
    Route::get('handle-payment', 'handlePayment')->name('make.payment');
    Route::get('cancel-payment', 'paymentCancel')->name('cancel.payment');
    Route::get('payment-success', 'paymentSuccess')->name('success.payment');
});

require __DIR__ . '/auth.php';
