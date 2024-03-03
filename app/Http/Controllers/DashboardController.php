<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\GetCountries;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;
use App\Models\Topups;
use App\Models\User;
use App\Models\Networks;
use App\Models\Package;
use App\Models\NetworkCommissions;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    use GetCountries;

    public function index()
    {
        $filterConditions = getRequestFilters(['start_date', 'end_date', 'operator_name', 'currency', 'country_name', 'top_amount', 'top_phone_number', 'top_status', 'trans']);
        $user = Auth::user();
        switch ($user->user_role) {
            case 'admin':
                $data = $this->get_dashboard_data($user->id, $filterConditions);
                $rout = 'layouts.dashboards.admin';
                break;
            case 'reseller':
                $data = $this->get_dashboard_data($user->id, $filterConditions);
                $rout = 'layouts.dashboards.reseller';
                break;
        }

        return view($rout, [
            'announcements' => Announcement::getAnnouncementsByCountry(),
            'countries_visits' => Topups::getCountriesWithVisitsAndPercentages(),
            'dynamicMarkers' => Topups::getDataForVectorMap(),
            'operators' => Networks::getNetworksNamesList(),
            'networks' => Networks::all(),
            'countries' => $this->getCountries(),
            'packages' => $this->pre_package(),
            'balance' => Payment::getBalance(),
        ])->with('topups', $data['topups'])->with('topupCounters', $data['counts']['topupCounters'] ?? null)->with('userCounters', $data['counts']['userCounters'] ?? null);
    }

    public function get_dashboard_data($userId, $filterConditions = null)
    {
        $data['topups'] = Topups::getRecords($userId, $filterConditions);

        $data['counts'] = $this->getCounts();

        return $data;
    }

    public function getCounts()
    {

        $data = array();
        $countData = Topups::select(DB::raw('CASE WHEN top_status = 1 THEN "success" ELSE "failed" END as top_status'), DB::raw('COUNT(*) as count'))->groupBy('top_status')->get();

        foreach ($countData as $count) {
            $data['topupCounters'][$count->top_status] = $count->count;
        }

        $countUsers = User::select('user_role', DB::raw('COUNT(*) as count'))->groupBy('user_role')->get();

        foreach ($countUsers as $count) {
            $data['userCounters'][$count->user_role] = $count->count;
        }

        return $data;
    }

    public function get_network_info()
    {
        $networks =  Networks::where('ntw_country_iso', 'AF')->get();

        foreach ($networks as $network) {
            $network->commission = NetworkCommissions::where('com_ntw_id', $network->id)->where('com_user_id', Auth::user()->id)->first()->com_custom_rate ?? $network->ntw_rate;
        }

        return $networks;
    }

    public function pre_package()
    {
        $packages = Package::all();
        foreach ($packages as $package) {
            $network = Networks::find($package->pck_ntw_id);
            $package->ntw_logo = @$network->ntw_logo;
        }
        return $packages;
    }
}
