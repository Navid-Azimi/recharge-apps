<?php

namespace App\Http\Controllers;

use App\Models\PackagesComissionRate;
use App\Models\Package;
use App\Models\User;
use App\Models\Networks;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PackagesComissionRatesController extends Controller
{
    public function index()
    {
        $pac_com_rates = PackagesComissionRate::latest()->paginate(10);
        return view('pac_com_rates.index', compact('pac_com_rates'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function getNetworkPackages(Request $request)
    {
        $network = Networks::findOrFail($request->ntw_id);
        $packages = Package::where('pck_ntw_id', $request->ntw_id)->get(['id', 'pck_country', 'pck_credit_amount', 'interior_charges', 'outdoor_charges', 'pck_data_amount',  'pck_minutes_amount', 'pck_sms_amount', 'pck_currency_id', 'pck_type', 'general_comm', 'pck_price'])->toArray();
        return response()->json([
            'packages' => $packages,
            'relatedNetwork' => $network,
        ]);
    }

    public function create(): View
    {
        $networks = Networks::all();
        $users = User::where('user_role', 'reseller')->get();
        return view('pac_com_rates.create', ['users' => $users, 'networks' => $networks]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'pck_com_list_id' => 'required',
            'user_com_list_id' => 'required',
            'com_input_type' => 'required',
            'calendar_date' => 'required',
            'ntw_id' => 'required',
        ]);

        PackagesComissionRate::create($request->all());

        return redirect()->route('pac_com_rates.index')->with('success', 'Packages created successfully.');
    }

    public function show(PackagesComissionRate $pac_com_rate)
    {
        return view('pac_com_rates.show', compact('pac_com_rate'));
    }

    public function edit(PackagesComissionRate $pac_com_rate): View
    {
        $networks = Networks::all();
        $packages = Package::all();
        $users = User::where('user_role', 'reseller')->get();
        return view('pac_com_rates.edit', ['pac_com_rate' => $pac_com_rate, 'packages' => $packages, 'users' => $users, 'networks' => $networks]);
    }

    public function update(Request $request, PackagesComissionRate $pac_com_rate)
    {
        $request->validate([
            'pck_com_list_id' => 'required',
            'user_com_list_id' => 'required',
            'com_input_type' => 'required',
            'calendar_date' => 'required',
            'ntw_id' => 'required',
        ]);

        $pac_com_rate->update($request->all());

        return redirect()->route('pac_com_rates.index')->with('success', 'Packages updated successfully');
    }

    public function destroy(PackagesComissionRate $pac_com_rate)
    {
        $pac_com_rate->delete();

        return redirect()->route('pac_com_rates.index')->with('success', 'Packages deleted successfully');
    }
}
