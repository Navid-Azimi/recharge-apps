<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OperatorContact; // Updated the namespace
use PragmaRX\Countries\Package\Countries;
class OperatorContactController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->only(['name', 'operator', 'country']);
        if ($request->has('reset')) {
            $search = [
                'name' => '',
                'operator' => '',
                'country' => '',
            ];}
        $contacts = OperatorContact::where(function ($query) use ($search) {
            if (!empty($search['name'])) {
                $query->where('name', 'like', '%' . $search['name'] . '%');
            }
            if (!empty($search['operator'])) {
                $query->orWhere('operator', 'like', '%' . $search['operator'] . '%');
            }
            if (!empty($search['country'])) {
                $query->orWhere('country', 'like', '%' . $search['country'] . '%');
            }
        })->paginate(10);
    
        return view('networks_contact.index', compact('contacts', 'search'))->with('noResults', $contacts->isEmpty());
    }
    
    public function create()
    {
        $countries = new Countries();
        $allCountries = $countries->all();
        return view('networks_contact.create', ['countries' => $allCountries]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|string',
            'title' => 'required|string',
            'operator' => 'required|string',
            'country' => 'required|string',
            'address' => 'required|string',
            'town_city' => 'required|string',
            'zipcode' => 'required|string',

        ]);

        OperatorContact::create($request->all());

        return redirect()->route('networks_contact.index')->with('success', 'Operator contact created successfully');
    }

    public function edit($id)
    {
        $contact = OperatorContact::findOrFail($id);
        $countries = new Countries();
        $allCountries = $countries->all();
    
        return view('networks_contact.edit', ['countries' => $allCountries, 'contact' => $contact]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|string',
            'title' => 'required|string',
            'operator' => 'required|string',
            'country' => 'required|string',
            'address' => 'required|string',
            'town_city' => 'required|string',
            'zipcode' => 'required|string',

        ]);

        $contact = OperatorContact::findOrFail($id);
        $contact->update($request->all());

        return redirect()->route('networks_contact.index')
            ->with('success', 'Operator contact updated successfully');
    }

    public function destroy($id)
    {
        $contact = OperatorContact::findOrFail($id);
        $contact->delete();

        return redirect()->route('networks_contact.index')
            ->with('success', 'Operator contact deleted successfully');
    }
}
