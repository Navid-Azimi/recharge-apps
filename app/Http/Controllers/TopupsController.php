<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\GetCountries;
use App\Models\Package;
use App\Models\Topups;
use App\Models\GiftCardTransaction;
use App\Models\Networks;
use App\Models\Payment;
use App\Models\User;
use App\Models\GiftType;
use App\Models\GiftCard;
use App\Models\UserContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use PragmaRX\Countries\Package\Services\Countries;

class TopupsController extends Controller
{
    use GetCountries;

    public function transaction_list(Request $request)
    {
        $user_id = $request->input('user_id');
        $topupTransactions = Topups::where('user_id', $user_id)->get();
        $userContacts = UserContact::where('user_id', $user_id)->get();

        foreach ($topupTransactions as &$topup) {
            $topupPhoneNumber = $topup["top_phone_number"];

            foreach ($userContacts as $contact) {
                $contactPhoneNumber = $contact["phone"];

                if ($topupPhoneNumber === $contactPhoneNumber) {
                    $topup["contact_name"] = $contact["name"];
                }
            }

            $taxAndRate = get_tax_rate('AF');
            $sendAmount = $topup->top_amount;
            $topup["amount_sent"] = $sendAmount;
            $topup["amount_received"] = $sendAmount - ($sendAmount / 100 * $taxAndRate['tax']);
            $topup["tax"] = floatval($topup["amount_sent"]) - floatval($topup["amount_received"]);
            $topup["deducted_amount_usd"] = "$" . round($sendAmount - $taxAndRate['rate'], 2);
            $topup["topup_fee_usd"] = "$" . round(($topup["tax"]) * $taxAndRate['rate'], 2);
            $topup["discount"] = 0.00;

            // Retrieve ntw_logo
            $networkName = $topup->top_ntw_name;
            $network = Networks::where('ntw_name', $networkName)->first();
            if ($network) {
                $topup['network_logo'] = '/storage/uploads/' . $network->ntw_logo;
            }

            // Retrieve country name and ISO code
            $allCountries = $this->getCountries();
            $topCurrency = Topups::value('top_currency');
            $countryData = collect($allCountries)
                ->first(function ($country) use ($topCurrency) {
                    return in_array($topCurrency, $country['currencies']);
                }) ?? null;

            if ($countryData) {
                $topup['country_name'] = $countryData['name']['common'] ?? "Null.";
                $topup['country_iso'] = $countryData['iso_a3'] ?? "Null.";
            } else {
                $topup['country_name'] = "Null.";
                $topup['country_iso'] = "Null.";
            }
        }

        unset($topup);

        return response()->json($topupTransactions);
    }

    public function transactions()
    {
        $topups = Topups::orderBy('id', 'desc')->get();
        return view('layouts.dashboards.transactions', ['topups' => $topups]);
    }

    public function processForm(Request $request)
    {
        $phoneNumber = $request->input('phone');
        session(['phoneNumber' => $phoneNumber]);
        return redirect()->route('public_request');
    }

    public function showPackageDetails(Request $request)
    {
        $id = $request->query('id');
        $package = Package::findOrFail($id);
        return view('layouts.summary', compact('package'));
    }


    // this function is only for top-up
    public function doTopup(Request $request)
    {
        $exchangeRateApiUrl = 'https://api.exchangerate-api.com/v4/latest/USD';
        $exchangeRateApiResponse = file_get_contents($exchangeRateApiUrl);
        $exchangeRateData = json_decode($exchangeRateApiResponse, true);
        $todayDollarCurrent = $exchangeRateData['rates'][$this->getCurrencyByISO($request->country_iso)];
        $amount = number_format($request->top_amount / $todayDollarCurrent, 2);
        try {
            // getting exchange rate API
            $exchangeRateApiUrl = 'https://api.exchangerate-api.com/v4/latest/USD';
            $exchangeRateApiResponse = file_get_contents($exchangeRateApiUrl);
            $exchangeRateData = json_decode($exchangeRateApiResponse, true);


            $balance = Payment::getBalance(auth()->user()->id);
            if ($request->has('top_pac_id')) {
                $package = Package::find($request->top_pac_id);
                $todayDollarCurrent = $exchangeRateData['rates'][$package->pck_currency_id];
                if ($package->pck_currency_id != 'USD') {
                    $amount = number_format($request->top_amount / $todayDollarCurrent, 2);
                } else {
                    $amount = $request->top_amount;
                }

                $errorMessage = 'Insufficient balance to complete the top-up.';

                if ($balance < $amount) {
                    return response()->json([
                        'success' => false,
                        'errors' => [$errorMessage],
                    ], 400);
                }
            } else {
                $amount = $request->top_amount;
                if ($balance < $amount) {
                    $errorMessage = 'Insufficient balance to complete the top-up.';
                    return redirect()->back()->withFail($errorMessage);
                }
            }

            if ($request->has('top_pac_id')) {
                $package = Package::findOrFail($request->top_pac_id);
            }
            // Get the ip from settings
            $ussdOutput = null;
            $status = false;

            try {

                $queueData['passKey'] = env('Topup_API_Pass_Key');
                $Topup_API = env('Topup_API');
                if ($request->has('topup_fee')) {
                    $amount = $request->top_amount - $request->topup_fee;
                } else {
                    $amount = $request->top_amount;
                }
                $queueData['ussd'] = "*440*1*0" . substr($request->phone, -9) . "*" . $amount . "#";

                $queueData['subscriptionId'] = "3";
                // $ussdOutput = 'test';
                $ussdOutput =  Http::withHeaders(['Content-Type' => 'application/json'])->post($Topup_API, ["jsonData" => $queueData]);
                if (str_starts_with(json_decode($ussdOutput)->response, 'TopUp for')) {
                    $status = true;
                }
            } catch (\Exception $e) {
                $ussdOutput = ($e->getMessage() === 'cURL error 28: Connection timed out') ? 'Topup server is down' : $e->getmessage();
                $status = false;
            }

            $ntw_name = get_network_from_phone(substr($request->phone, 1));
            $afnExchangeRate = $exchangeRateData['rates']['AFN'] ?? 0.01176;

            $topupData = [
                'top_phone_number' => $request->phone,
                'user_id' => Auth::user()->id,
                'top_pac_id' => $request->top_pac_id,
                'top_ntw_name' => strlen($ntw_name) > 2 ? $ntw_name : 'Unknown',
                'top_country' => getCountryNameByISO($request->country_iso),
                'top_rate' => $afnExchangeRate, // base on today exchange rate
                'top_status' => $status,
                'top_ussd_output' => json_decode($ussdOutput)->response ?? $ussdOutput,
                'payment_status' => $request->payment_status ?? true
            ];

            $base_To_API_Currency = $exchangeRateData['base'];
            if ($request->has('top_pac_id')) {
                $package = Package::find($request->top_pac_id);
                $todayDollarCurrent = $exchangeRateData['rates'][$package->pck_currency_id];
                if ($package->pck_currency_id != 'USD') {
                    $amount = number_format($request->top_amount / $todayDollarCurrent, 2);
                    $topupData['top_amount'] = $amount;
                    $topupData['top_currency'] = $package->pck_currency_id;
                    $topupData['top_profit'] = $request->topup_fee_in_dollar;
                } else {
                    $topupData['top_amount'] = $request->top_amount;
                }
            } else {
                $todayDollarCurrent = $exchangeRateData['rates'][$this->getCurrencyByISO($request->country_iso)];
                $amount = number_format($request->top_amount / $todayDollarCurrent, 2);
                $topupData['top_amount'] = $amount;
                $topupData['top_currency'] = $base_To_API_Currency; // for saving USD currency to top_currency
                // $topupData['top_currency'] = $this->getCurrencyByISO($request->country_iso); 
            }
           
            if ($request->is('reseller-topup')) {
                $topupData['user_role'] = 'reseller';
            } else {
                $topupData['user_role'] = 'customer';
            }

            $topupData['top_amount2'] = $topupData['top_currency'] === 'USD' ? $topupData['top_amount'] * $afnExchangeRate : ($topupData['top_amount2'] ?? null);
            $topupResult = Topups::create($topupData);

            if ($request->is_api) {
                $USD_rate = $afnExchangeRate;
                $country_tax = 10; // @TODO, this should be updated to dynamic value.
                $sendAmount = $topupResult['top_amount'];

                $topupResult["amount_sent"] =  $sendAmount;
                $topupResult["amount_recieved"] =  $sendAmount - ($sendAmount / 100 * $country_tax);
                $topupResult["tax"] = $topupResult["amount_sent"] - $topupResult["total_recieved"];
                $topupResult["deducted_amount"] = "$" . round($sendAmount * $USD_rate, 2);
                $topupResult["topup_fee"] = "$" . round(($topupResult["tax"]) * $USD_rate, 2);
                $topupResult["discount"] = 0.00;  // @TODO, is there any discount

                return $topupResult;
            }

            if ($request->has('top_pac_id')) {
                Session::flash('success', 'Topup Done Successfully!');
                return response()->json([
                    'success' => true,
                    'redirectURL' => route('reseller_dashboard'),
                ]);
            } else {
                return  redirect()->route('reseller_dashboard')->withSuccess('Topup Done Successfully!');
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'errors' => [$e->getMessage()],
            ], 500);
        }
    }

    // git country's Network -----------------------------------

    public function countries_network_name(Request $request)
    {
        $phoneNumber = $request->input('phone_number');
        $countryCode = $request->input('country_code');

        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        $swissNumberProto = $phoneUtil->parse($phoneNumber, $countryCode); // Use the dynamic country code
        $carrierMapper = \libphonenumber\PhoneNumberToCarrierMapper::getInstance();
        $timeZoneMapper = \libphonenumber\PhoneNumberToTimeZonesMapper::getInstance();
        $timeZones = $timeZoneMapper->getTimeZonesForNumber($swissNumberProto);

        return response()->json([
            'Country Network' => $carrierMapper->getNameForNumber($swissNumberProto, "en"),
            'time_zones' => $timeZones,
            'phone_number' => $phoneNumber,
        ]);
    }

    public function buyGift(Request $request)
    {
        $id = $request->giftType_id;
        $giftType = GiftType::find($id);
        $giftCard = GiftCard::where('id', $id)->where('status', 'active')->first();
        $user = auth()->user();

        $transaction = new GiftCardTransaction();
        $transaction->product = $giftCard->giftType->title;
        $transaction->currency = $giftCard->currency;
        $transaction->country = $giftCard->giftType->cardBrand->brand_country;
        $transaction->price = $giftCard->price;
        $transaction->discount = $giftCard->discount;
        $transaction->total = $giftCard->price - $giftCard->discount;
        $transaction->status = 'successfull';
        $transaction->recipient_name = $user->name;
        $transaction->recipient_email = $user->email;
        $transaction->recipient_phone = $user->mobile_no ? $user->mobile_no : '34334';
        $transaction->image =  $giftCard->giftType->image;
        $transaction->value = $giftCard->value;
        $transaction->bar_code = $giftCard->bar_code;
        $transaction->save();

        $giftCard->status = 'used';
        $giftCard->save();

        return response()->json(['success' => true]);
    }

    private function getCurrencyByISO($iso)
    {
        $countries = new Countries();

        $country = $countries->where('iso_a3', $iso)->first();

        return $country->currencies[0];
    }
}
