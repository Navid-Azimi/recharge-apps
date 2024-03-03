<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\GetCountries;
use App\Http\Controllers\Traits\UploadImage;
use App\Models\Networks;
use App\Models\NetworkCommissions;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class NetworkController extends Controller
{
    use UploadImage;
    use GetCountries;
 
    public function index(): View
    {
        $filterConditions = getRequestFilters(['operator_country', 'operator_name']);
        $networks = Networks::getRecords($filterConditions)->paginate(10);
        $allCountries = $this->getCountries();
        return view('networks.index', [
            'networks' => $networks,
            'allCountries' => $allCountries,
        ]);
    }
 
    public function create(): View
    {
        $allCountries = $this->getCountries();
        return view('networks.create', ['countries' => $allCountries]);
    }

    public function store(Request $request)
    {
        $this->validator($request);

        $network = new Networks;
        $network->ntw_min_value = $request->ntw_min_value;
        $network->ntw_max_value = $request->ntw_max_value;
        $network->ntw_name = $request->ntw_name;
        $network->ntw_logo = $request->hasFile('ntw_logo') ? $this->uploadImage('ntw_logo') : null;
        $network->ntw_country_iso = $request->ntw_country_iso;
        $network->ntw_rate = $request->ntw_rate;
        $network->save();

        return redirect()->route('networks.index')->with('success', 'Operator created successfully.');
    }
 
    public function show(Networks $network): View
    {
        return view('networks.show', ['network' => $network]);
    }
 
    public function edit(Networks $network)
    {
        $allCountries = $this->getCountries();
        return view('networks.edit', ['countries' => $allCountries, 'network' => $network]);
    }
 
    public function update(Request $request, Networks $network): RedirectResponse
    {
        $this->validator($request);
        if ($network->ntw_logo and $request->hasFile('ntw_logo')) {
            $this->deleteImage($network->ntw_logo);
            $network->ntw_logo = null;
        }
        $network->ntw_name = $request->ntw_name;
        $network->ntw_country_iso = $request->ntw_country_iso;
        $network->ntw_rate = $request->ntw_rate;
        $network->ntw_logo = $request->hasFile('ntw_logo') ? $this->uploadImage('ntw_logo') : $network->ntw_logo;

        $this->setRateMinMaxByNetworkName($request,$network, $request->ntw_name);
        $network->save();

        return redirect()->route('networks.index')->with('success', 'Operator updated successfully');
    }

    private function setRateMinMaxByNetworkName(Request $request, Networks $network, $ntw_name)
    {
        switch ($ntw_name) {
            case 'roshan':
            case 'Roshan':
            case 'ROSHAN':
                $network->ntw_min_value = 25;
                $network->ntw_max_value = 5000;
                break;
            case 'salaam':
            case 'Salaam':
            case 'SALAAM':
                $network->ntw_min_value = 25;
                $network->ntw_max_value = 5000;
                break;
            case 'awcc':
            case 'Awcc':
            case 'AWCC':
                $network->ntw_min_value = 50;
                $network->ntw_max_value = 1000;
                break;
            case 'mtn':
            case 'Mtn':
            case 'MTN':
                $network->ntw_min_value = 25;
                $network->ntw_max_value = 5000;
                break;
            case 'etisalat':
            case 'ETISALAT':
            case 'Etisalat':
                $network->ntw_min_value = 25;
                $network->ntw_max_value = 5000;
                break;
            default:
                $network->ntw_min_value = $request->ntw_rate_min ?? 0;
                $network->ntw_max_value = $request->ntw_rate_max ?? 0;
        }
    }
 
    public function destroy(Networks $network): RedirectResponse
    {
        if ($network->ntw_logo) {
            $this->deleteImage($network->ntw_logo);
        }
        $network->delete();
        return redirect()->route('networks.index')->with('success', 'Operator deleted successfully');
    }

    protected function validator($request)
    {
        return  $request->validate([
            'ntw_name' => 'required|string',
            'ntw_country_iso' => 'required|string',
            'ntw_rate' => 'required|string',
            'ntw_logo' => 'nullable|image',
            'ntw_min_value' => 'string|nullable',
            'ntw_max_value' => 'string|nullable',
        ]);
    }

    public function networks_by_country(Request $request, $isoCode = null)
    {
        $iso = $request->has('countryCode') ? $request->get('countryCode') : $isoCode;
        $get_network = Networks::where('ntw_country_iso', 'like', '%' . $iso . '%')->get();

        if ($request->route()->getName() === 'network_by_iso') {
            return response()->json([
                'networks' => $get_network
            ]);
        }
        return $get_network;
    }

    public function networks_by_phone(Request $request)
    {

        $selectedNetwork = get_network_from_phone($request->phone);
        $network =  Networks::where('ntw_name', $selectedNetwork)->first();
        $resellerID = Auth::user()->id;

        if (!$network) {
            return response()->json([
                'title' => 'Unsupported Country',
                'content' => 'Sorry, we currently do not support phone numbers from this country in our contact creation process. Please use a supported country\'s phone number.',
            ], 404);
        }

        return response()->json([
            'selectedNetwork' => $selectedNetwork,
            'logo' => $network->ntw_logo,
            // 'user id' => $resellerID,
        ]);
    }

    public function get_phone_network_data(Request $request)
    {
        $selectedNetwork = get_network_from_phone(substr($request->phone, 1));

        // Check if custom comission exist.
        $network =  Networks::where('ntw_name', $selectedNetwork)->first();
        $resellerID = Auth::user()->id;
        $commission =  NetworkCommissions::where('com_ntw_id', $network->id)->where('com_user_id', $resellerID)->first()->com_custom_rate ?? Networks::where('ntw_name', $selectedNetwork)->first()->ntw_rate;

        return response()->json([
            'network' => $network,
            'selectedNetwork' => $selectedNetwork,
            'commission' => $commission,
        ]);
    }

    public function getAllNetworks()
    {
        $networks = Networks::all();
        return response()->json(['networks' => $networks]);
    }
}
