<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\GetCountries;
use Illuminate\Http\JsonResponse;
use App\Models\Package;
use App\Models\Networks;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PackagesController extends Controller
{
    use GetCountries;

    public function index()
    {

        $filterConditions = getRequestFilters(['package_country', 'package_operator', 'pck_type', 'package_user_role', 'package_user']);
        $allCountries = $this->getCountries();
        $operators = Networks::all();
        $users = User::all();

        $packages = Package::getRecords($filterConditions)->paginate(10);

        return view('packages.index', [
            'packages' => $packages,
            'countries' => $allCountries,
            'operators' => $operators,
            'users' => $users,
        ]);
    }

    public function create()
    {
        $allCountries = $this->getCountries();
        $networks = Networks::all();
        $users = User::all();
        return view('packages.create', [
            'allCountries' => $allCountries,
            'networks' => $networks,
            'users' => $users,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'pck_price' => 'required',
            'pck_currency_id' => 'required',
        ]);

        Package::create($request->all());

        return redirect()->route('packages.index')->with('success', 'Package created successfully.');
    }

    public function show(Package $package)
    {
        return view('packages.show', compact('package'));
    }

    public function edit(Package $package)
    {
        $allCountries = $this->getCountries();
        $networks = Networks::all();
        $users = User::all();
        return view('packages.edit', compact('package', 'allCountries', 'networks', 'users'));
    }

    public function update(Request $request, Package $package)
    {
        $request->validate([
            'pck_type' => 'required',
            'pck_price' => 'required',
            'pck_currency_id' => 'required',
            'pck_ntw_id' => 'required',
        ]);

        $package->update($request->all());

        return redirect()->route('packages.index')->with('success', 'Package updated successfully');
    }

    public function destroy(Package $package)
    {
        $package->delete();

        return redirect()->route('packages.index')->with('success', 'Package deleted successfully');
    }

    public function api_packages(Request $request)
    {

        $packages = [];

        if (isset($request->phone)) {
            $ntwName = get_network_from_phone($request->phone);
            $packages = Package::whereHas('network', function ($query) use ($ntwName) {
                $query->where('ntw_name', $ntwName);
            })->get();
        } else {
            $packages = Package::select('id', 'pck_type', 'pck_credit_amount', 'pck_price', 'pck_data_amount', 'created_at')->get();
        }

        foreach ($packages as $package) {
            $packageObject = Package::findOrFail($package->id);
            packageAdditionalDetails($package, $package->pck_price, $packageObject->network);
        }

        $response = [
            'packages' => $packages,
            'details' => $this->getSomeDetails($request->phone),
        ];

        return new JsonResponse($response, 200);
    }

    public function find_countries(Request $request)
    {
        $phoneNumber = $request->input('phone');
        $countryCode = $request->input('country_code');

        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        $swissNumberProto = $phoneUtil->parse($phoneNumber, $countryCode); // Use the dynamic country code
        $carrierMapper = \libphonenumber\PhoneNumberToCarrierMapper::getInstance();
        $timeZoneMapper = \libphonenumber\PhoneNumberToTimeZonesMapper::getInstance();
        $timeZones = $timeZoneMapper->getTimeZonesForNumber($swissNumberProto);

        $network = Networks::where('ntw_country_iso', $countryCode)->get();

        if ($network) {
            return response()->json([
                'network_details' => $network,
            ]);
        } else {
            return 'The network not found';
        }
    }

    public function package_details(Request $request)
    {
        try {
            $package = Package::findOrFail($request->pck_id);
            $package['country_tax'] = (object)get_tax_rate(trim($package->network->ntw_country_iso));

            $exchangeRateApiUrl = 'https://api.exchangerate-api.com/v4/latest/USD';
            $exchangeRateApiResponse = file_get_contents($exchangeRateApiUrl);
            $exchangeRateData = json_decode($exchangeRateApiResponse, true);

            $pck_currency_id = $package->pck_currency_id;
            $exchangeRate = isset($exchangeRateData['rates'][$pck_currency_id]) ? $exchangeRateData['rates'][$package->pck_currency_id] : 0;

            $adjustedRate = $exchangeRate * 0.98;


            $todayDollarCurrent = $exchangeRateData['rates'][$package->pck_currency_id];

            if ($package->country_tax->tax) {
                $taxValue = ($package->pck_price / 100 * $package->country_tax->tax);
            } else {
                $taxValue = 0;
            }
            $amountReceived = $package->pck_price - $taxValue;

            if ($package->pck_country === $request->user_location) {
                $topupSubtotal =  $amountReceived / $todayDollarCurrent;
                $topupFee = $package->interior_charges / $adjustedRate;
            } else {
                $topupSubtotal = $amountReceived / $adjustedRate;
                $topupFee = $package->outdoor_charges / $todayDollarCurrent;
            }

            $finalTotal = $topupSubtotal + $topupFee;

            $currentCountryCredits = json_encode([
                'package_id' => $package->id,
                'amount_send' => round($package->pck_price, 2),
                'amount_recieves' => round($amountReceived, 2),
                'pck_unit' => $package->pck_currency_id,
                'country_tax' => round($taxValue, 2),
                'operator_name' => $package->network->ntw_name,
                'operator_logo' => $package->network->ntw_logo,
            ]);

            $dollarCredits = json_encode([
                'your_total' => round($finalTotal, 2),
                'topup_subtotal' => round($topupSubtotal, 2),
                'topup_fee' => round($topupFee, 2),
                'unit' => 'USD',
            ]);

            return response()->json([
                'package_details' => json_decode($currentCountryCredits),
                'package_dollar_based_details' => json_decode($dollarCredits),
                'details' => $this->getSomeDetails($request->phone),
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Package not found'], 404);
        }
    }

    public function get_carrier_info($phoneNumber, $countryCode)
    {

        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        $swissNumberProto = $phoneUtil->parse($phoneNumber, $countryCode); // Use the dynamic country code
        $carrierMapper = \libphonenumber\PhoneNumberToCarrierMapper::getInstance();
        $timeZoneMapper = \libphonenumber\PhoneNumberToTimeZonesMapper::getInstance();
        $timeZones = $timeZoneMapper->getTimeZonesForNumber($swissNumberProto);

        $carrierName = $carrierMapper->getNameForNumber($swissNumberProto, "en");

        // Salam operatore is Afghan Telecom in default way
        if ($carrierName == 'Afghan Telecom') {
            $carrierName = 'SALAM';
        }

        return array("carrierName" => $carrierName);
    }

    // this function get packages base on nwt_name requests
    public function get_pack_base_ope_name(Request $request)
    {
        $packages = [];

        if (isset($request->operator_name)) {
            $network = Networks::where('ntw_name', $request->operator_name)->first();
            $packages = Package::where('pck_ntw_id', $network->id)->get();
        } else {
            $packages = Package::select('id', 'pck_type', 'pck_credit_amount', 'pck_price', 'pck_data_amount', 'created_at')->get();
        }

        foreach ($packages as $package) {
            $packageObject = Package::findOrFail($package->id);
            packageAdditionalDetails($package, $package->pck_price, $packageObject->network, false);
        }

        $columnsToExclude = [
            'interior_charges','outdoor_charges','pck_user_role','general_comm',
            'pck_pin_number','pck_pin_info','created_at','updated_at',
            'amount_sent','amount_recieved','deducted_amount_usd','package_fee_usd',
        ];

        $packages = $packages->map(function ($package) use ($columnsToExclude) {
            return $package->except($columnsToExclude);
        });

        $operator = Networks::select('ntw_name', 'ntw_logo')->where('ntw_name', $request->operator_name)->first();
        $response = [
            'packages' => $packages,
            'operator' => $operator,
            'details' => $this->getSomeDetails($request->phone),
        ];

        return new JsonResponse($response, 200);
    }

    public function isEUNumber(Request $request)
    {
        $phoneNumber = $request->input('phone');
        $phoneWithPlus = '+' . $request->input('phone');
        $countryISO = $request->input('country_iso');

        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        $swissNumberProto = $phoneUtil->parse($phoneWithPlus, $countryISO);
        $timeZoneMapper = \libphonenumber\PhoneNumberToTimeZonesMapper::getInstance();
        $timeZones = $timeZoneMapper->getTimeZonesForNumber($swissNumberProto);

        $isInEurope = false;

        if (is_array($timeZones)) {
            foreach ($timeZones as $zone) {
                if (strpos($zone, 'Europe') !== false) {
                    $isInEurope = true;
                    break;
                }
            }
        }

        return response()->json([
            'operator' => get_network_from_phone($phoneNumber),
            'is_european' => $isInEurope,
        ]);
    }

    public function getSupportedCountries()
    {
        try {
            $packagesCountries = DB::table('packages')->select('pck_country')->distinct()->get();
            $countries = [];

            foreach ($packagesCountries as $country) {

                $countryData = new \stdClass();
                if ($country->pck_country == 'Afghanistan') {
                    $countryData->image_url = asset('assets/img/countries/AFG.jpg');
                } elseif ($country->pck_country == 'Turkey') {
                    $countryData->image_url = asset('assets/img/countries/Turkish.jpg');
                }
                $countryData->name = $country->pck_country;
                $countryData->iso3 = getCountryISOByName($country->pck_country);
                $countryData->country_code = getCountryCodeByName($country->pck_country);

                $countries[] = $countryData;
            }

            return response()->json([
                'success' => true,
                'countries' => $countries,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong,' . $e->getMessage(),
            ]);
        }
    }

    public function getTax($countryCode)
    {
        $taxRate =  (object)get_tax_rate($countryCode);
        return response()->json($taxRate->tax);
    }

    public function getExchangeRates()
    {
        $exchangeRateApiUrl = 'https://api.exchangerate-api.com/v4/latest/USD';
        $exchangeRateApiResponse = file_get_contents($exchangeRateApiUrl);
        $exchangeRateData = json_decode($exchangeRateApiResponse, true);
        return response()->json($exchangeRateData);
    }

    private function getSomeDetails($phone)
    {
        if (substr($phone, 0, 1) === '+') {
            $phone = $phone;
        } else {
            $phone = '+'. $phone;
        }

        $countryName = getCountryFromPhone($phone);
        $details = [
            'phone' => $phone,
            'country_name' => $countryName,
            'country_iso' => getCountryISOByName($countryName),
        ];
        return $details;
    }
}
