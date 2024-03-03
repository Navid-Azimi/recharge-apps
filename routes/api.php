<?php

use App\Http\Controllers\Auth\FacebookController;
use App\Http\Controllers\Auth\AppleController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\PhoneVerificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TopupsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PackagesController;
use App\Http\Controllers\NetworkController;
use App\Http\Controllers\UserContactController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\CardBrandController;
use App\Http\Controllers\GiftCardsController;
use App\Http\Controllers\GiftCardTypesController;

Route::group([
    'middleware' => ['api'],
    'prefix' => 'auth',
], function () {
    Route::post('login', [RegisteredUserController::class, 'login_api']);
    Route::post('login_with_email', [RegisteredUserController::class, 'login_with_email']);
    Route::get('apple_login', [AppleController::class, 'redirectToApple']);
    Route::get('apple_callback', [AppleController::class, 'handleAppleCallback']);
    Route::get('facebook_login', [FacebookController::class, 'redirectToFacebook']);
    Route::get('facebook_callback', [FacebookController::class, 'handleFacebookCallbafck']);
    Route::post('send_verification_code', [PhoneVerificationController::class, 'sendVerificationCode'])->name('send_verification_code');
    Route::post('verify_code', [PhoneVerificationController::class, 'verifyCode'])->name('verify_code');
    Route::post('logout', [RegisteredUserController::class, 'logout_api']);
    Route::post('refresh', [RegisteredUserController::class, 'refresh_api']);
    Route::post('register_api', [RegisteredUserController::class, 'register_api']);
    Route::get('/email-verify/{id}/{hash}', [RegisteredUserController::class, 'verify_email'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('/email/resend', [RegisteredUserController::class, 'resend']);
    Route::get('google_login', [RegisteredUserController::class, 'redirectToGoogle']);
    Route::get('google_callback', [RegisteredUserController::class, 'googleCallback']);

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('mypassword.forgot');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('mypassword.reset');
});

Route::group(['middleware' => 'jwtMidd'], function ($router) {

    Route::put('user_update/{id}', [RegisteredUserController::class, 'user_update']);
    Route::get('transaction_list', [TopupsController::class, 'transaction_list']);
    Route::get('getUserDetails', [RegisteredUserController::class, 'getUserDetails']);
    Route::get('getUser/{id}', [RegisteredUserController::class, 'getSingleUser']);
    Route::get('package_details', [PackagesController::class, 'package_details']); //this one has error
    Route::post('topup', [PaymentController::class, 'stripePost']);                //this one has error
    Route::post('countries_network_name', [TopupsController::class, 'countries_network_name']);
    Route::post('find_countries', [PackagesController::class, 'find_countries']);
    Route::get('networks_by_phone', [NetworkController::class, 'networks_by_phone']);
    Route::post('create_contacts', [UserContactController::class, 'create_contacts']); //this one has error
    Route::put('update_contact/{id}', [UserContactController::class, 'update_contact']); //this one has error
    Route::delete('delete_contact/{id}', [UserContactController::class, 'delete_contact']); //this one has error
    Route::get('show_contact', [UserContactController::class, 'show_contact']); //this one has error
    Route::get('giftcard_order', [GiftCardTypesController::class, 'giftCardDetails']); // need to review
    Route::get('giftcard_checkout', [GiftCardTypesController::class, 'giftCardDetails']); // need to review
    Route::post('send_giftcard', [GiftCardsController::class, 'sendGiftCard']); // need to review
});

Route::post('/requests_reseller', [CardBrandController::class, 'api_requestsReseller']); // need to review
Route::get('get_countries', [PackagesController::class, 'getSupportedCountries']);
Route::get('networks_by_country', [NetworkController::class, 'networks_by_country']);
Route::get('is_phone_european', [PackagesController::class, 'isEUNumber']);
Route::get('package_list', [PackagesController::class, 'api_packages']);
Route::get('giftcard_brands_list', [CardBrandController::class, 'api_brands']);
Route::get('worldwide_brands_list', [CardBrandController::class, 'worldwideBrands']);
Route::get('giftcard_brands_by_country', [CardBrandController::class, 'cardBrandsByCountry']);
Route::get('gift_types', [GiftCardTypesController::class, 'getGiftCardTypesByBrand']);
Route::get('find_package_from_ntw_name', [PackagesController::class, 'get_pack_base_ope_name']);
Route::post('/mark_favorite/{id}', [UserContactController::class, 'mark_favorite']);
