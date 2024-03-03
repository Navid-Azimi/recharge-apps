<?php


namespace App\Http\Controllers;

use App\Models\Networks;
use App\Models\User;
use App\Models\NetworkCommissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NetworkCommissionsController extends Controller
{
    public function index()
    {
        $commissions = NetworkCommissions::latest()->paginate(10);
        return view('network_commissions.index', compact('commissions'));
    }

    public function create(): View
    {
        $networks = Networks::all();
        $users = User::where('user_role', 'reseller')->get();
        return view('network_commissions.create', ['networks' => $networks, 'users' => $users]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'com_ntw_id' => 'required',
            'com_user_id' => 'required',
            'com_custom_rate' => 'required',
        ]);

        NetworkCommissions::create($request->all());

        return redirect()->route('commissions.index')->with('success', 'Network Commissions created successfully.');
    }

    public function show(NetworkCommissions $commission)
    {
        return view('network_commissions.show', compact('commission'));
    }

    public function edit(NetworkCommissions $commission)
    {
        $networks = Networks::all();
        $users = User::where('user_role', 'reseller')->get();
        return view('network_commissions.edit', ['commission' => $commission, 'networks' => $networks, 'users' => $users]);
    }

    public function update(Request $request, NetworkCommissions $commission)
    {
        $request->validate([
            'com_ntw_id' => 'required',
            'com_user_id' => 'required',
            'com_custom_rate' => 'required',
        ]);

        $commission->update($request->all());

        return redirect()->route('commissions.index')->with('success', 'Network Commissions updated successfully');
    }

    public function destroy(NetworkCommissions $commission)
    {
        $commission->delete();

        return redirect()->route('commissions.index')->with('success', 'Network Commissions deleted successfully');
    }
}
