<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\GetCountries;
use App\Models\Networks;
use App\Models\Topups;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RequestsReseller;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    use GetCountries;

    public function reports()
    {
        $filterConditions = getRequestFilters(['start_date', 'end_date', 'top_amount', 'operator_name', 'currency', 'country_name', 'top_phone_number', 'top_status', 'trans']);

        $dashaboardController = new DashboardController();
        $data = $dashaboardController->getCounts();

        $customers['customer'] = Topups::where('user_id', Auth::user()->id)->groupBy('top_phone_number')->count();
        $user = Auth::user();

        switch ($user->user_role) {
            case 'admin':
                $topups = Topups::getRecords($user->id, $filterConditions);
                break;
            case 'reseller':
                $topups = Topups::getRecords($user->id, $filterConditions);
                break;
        }
        return view('reports.reports', [
            'operators' => Networks::getNetworksNamesList(),
            'countries' => $this->getCountries(),
        ])
            ->with('topupCounters', $data['topupCounters'] ?? [])
            ->with('userCounters', $customers)
            ->with('topups', $topups);
    }

    public function resellerReports()
    {
        $filterConditions = getRequestFilters(['start_date', 'reseller_id', 'end_date', 'top_amount', 'operator_name', 'currency', 'country_name', 'top_phone_number', 'top_status', 'trans']);

        $topups = Topups::getRecordsByRole('reseller', $filterConditions);
        $resellers = User::where('user_role', 'reseller')->get();
        // return $customers;
        return view('reports.reseller', [
            'operators' => Networks::getNetworksNamesList(),
            'resellers' => $resellers,
            'countries' => $this->getCountries(),
            'topups' => $topups,
        ]);
    }

    public function cusotmerReports()
    {
        $filterConditions = getRequestFilters(['start_date', 'end_date', 'top_amount', 'operator_name', 'currency', 'country_name', 'top_phone_number', 'top_status', 'trans']);

        $topups = Topups::getRecordsByRole('customer', $filterConditions);
        return view('reports.customer', [
            'operators' => Networks::getNetworksNamesList(),
            'countries' => $this->getCountries(),
            'topups' => $topups,
        ]);
    }

    public function resellersList()
    {
        $filterConditions = getRequestFilters(['name', 'mobile', 'user_country', 'city', 'email']);
        $resellers = User::getRecordsByRole('reseller', $filterConditions); 

        return view('reports.reseller-manage', [
            'resellers' => $resellers,
        ]);
    }

    public function requestsreseller()
    {
        $requestResel = RequestsReseller::latest()->paginate(10);
        return view('reports.reseller-manage-req', compact('requestResel'));
    }

    public function createBalance($id)
    {
        $reseller = User::findOrFail($id);
        return view('reseller_balance.create', [
            'reseller' => $reseller,
        ]);
    }

    public function storeBalance(Request $request)
    {
        $request->validate([
            'balance_amount' => 'required|min:0'
        ]);


        $reseller = User::findOrFail($request->id);
        $reseller->old_balance = $reseller->balance;
        $reseller->balance = $request->balance_amount;
        $reseller->save();

        return redirect()->route('manage_resellers')->with('success', 'Balance to ' . $reseller->name . ' added successfully');
    }

    public function editBalance($id)
    {
        $reseller = User::findOrFail($id);
        return view('reseller_balance.edit', [
            'reseller' => $reseller,
        ]);
    }

    public function updateBalance(Request $request, $id)
    {
        $request->validate([
            'balance_amount' => 'required|min:0'
        ]);

        $reseller = User::findOrfail($id);
        $reseller->old_balance = $reseller->balance;
        $reseller->balance = $request->balance_amount;
        $reseller->save();

        return redirect()->route('manage_resellers')->with('success', $reseller->name . ' Balance Reverted successfully');
    }
}
