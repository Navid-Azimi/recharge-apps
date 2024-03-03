<?php

use App\Models\Countryrate;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use JWTAuth as JW;
use PragmaRX\Countries\Package\Services\Config;
use PragmaRX\Countries\Package\Services\Countries;
use Stripe\Stripe;
use Stripe\Token;

function getRequestFilters(array $keyArray): array
{
    $filterArray = request()->only($keyArray);
    return array_filter($filterArray, function ($value) {
        return !empty($value) || $value == '0';
    });
}

if (!function_exists('get_tax_rate')) {

    function get_tax_rate($countryCode)
    {
        return Countryrate::where('country_code', $countryCode)->first() ?? array("tax" => 0, "rate" => 1);
    }
}

if (!function_exists('packageAdditionalDetails')) {

    function packageAdditionalDetails($package, $sendAmount, $network, $includeNTW = true)
    {

        $taxAndRate = get_tax_rate(trim($network->ntw_country_iso));

        $package["amount_sent"] =  $sendAmount;
        $package["amount_recieved"] =  $sendAmount - ($sendAmount / 100 * $taxAndRate['tax']);
        $package["tax"] = floatval($package["amount_sent"]) - floatval($package["amount_recieved"]);
        $package["deducted_amount_usd"] = "$" . round($package["amount_recieved"] * $taxAndRate['rate'], 2);
        $package["package_fee_usd"] = "$" . round(($package["tax"]) * $taxAndRate['rate'], 2);
        $package["discount"] = 0.00;  // @TODO, is there any discount
        // $package["package_network_logo"] = $network->ntw_logo;
        if ($includeNTW) {
            $package["package_network_logo_url"] = '/storage/uploads/' . $network->ntw_logo;
            $package["ntw_name"] = $network->ntw_name;
        }
    }
}


if (!function_exists('get_network_from_phone')) {

    function get_network_from_phone($phone)
    {

        $networkMap = [
            "9379" => 'ROSHAN',
            "9372" => 'ROSHAN',
            "9378" => 'ETISALAT',
            "9373" => 'ETISALAT',
            "9377" => 'MTN',
            "9376" => 'MTN',
            "9374" => 'SALAAM',
            "9370" => 'AWCC',
            "9053" => 'Turkcell',
            "9054" => 'Turkcell',
            "9055" => 'Turk Telekom',
            "9050" => 'Turk Telekom',
            "9055" => 'Vodafone',
        ];

        // @TODO, this should be extended to support other countries later.

        return $networkMap[substr($phone, 0, 4)] ?? "%";
    }
}

if (!function_exists('respondWithToken')) {

    function respondWithToken($token = false, $user = false)
    {

        // Set token expiration time to 24 hours from the current time
        $expiresAt = Carbon::now()->addMinutes(1444);

        if ($user) {
            // Generate a new token with the expiration time
            $token = JW::claims(['exp' => $expiresAt->timestamp])->fromUser($user);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $expiresAt,
            'user_info' => Auth::user() ?? $user,
        ]);
    }
}


function getCardBrand($request)
{
    Stripe::setApiKey(env('STRIPE_SECRET'));

    try {
        $tokenData = Token::retrieve($request->stripeToken);
        return ['brand' => $tokenData->card->brand];
    } catch (\Exception $e) {
        return ['errors' => [$e->getMessage()]];
    }
}
function getCountryNameByISO($isoCode)
{
    $countries = new Countries(new Config());

    $countryName = $countries->where('iso_a3', $isoCode)->first()->name;

    return $countryName->common;
}

function getCountryISOByName($countryName)
{
    $countries = new Countries(new Config());
    $countryName = $countries->where('name.common', $countryName)->first();

    return $countryName->iso_a3;
}

function getCountryCodeByName($countryName)
{
    $countries = new Countries(new Config());
    $countryName = $countries->where('name.common', $countryName)->first();

    return $countryName->calling_codes[0];
}

function getCountryFromPhone($phoneNumber)
{
    $countries = new Countries(new Config());
    $foundCountry = null;
    foreach ($countries->all() as $country) {
        if (in_array(substr($phoneNumber, 0, 3), $country['calling_codes'])) {
            $foundCountry = $country;
            break;
        }
    }
    return $foundCountry->name->common;
}

// token generation for authenticated users
function respondWithToken($token = false, $user = false, $message  = null)
{

    $expiresAt = Carbon::now()->addMinutes(1444);

    if ($user) {
        $token = JW::claims(['exp' => $expiresAt->timestamp])->fromUser($user);
    }

    return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => $expiresAt,
        'user_info' => Auth::user() ?? $user,
        'message' => $message
    ]);
}

function shortenUrl($url, $maxLength = 50)
{
    if (strlen($url) > $maxLength) {
        return substr($url, 0, $maxLength) . '...';
    }

    return $url;
}
