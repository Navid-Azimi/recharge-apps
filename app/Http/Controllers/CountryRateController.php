<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\GetCountries;
use App\Models\Countryrate;
use Illuminate\Http\Request;
use Illuminate\View\View;


class CountryRateController extends Controller
{
    use GetCountries;

    public function index()
    {
        $country_rates = Countryrate::latest()->paginate(10);
        return view('country_rate_and_tax.index', compact('country_rates'));
    }

    public function create(): View
    {
        $allCountries = $this->getCountries();
        return view('country_rate_and_tax.create', ['countries' => $allCountries]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'country_name' => 'required',
            'country_code' => 'required',
            'product_type' => 'required',
            'rate' => 'required',
            'tax' => 'required',
            'description' => 'string|nullable',
        ]);

        Countryrate::create($request->all());
        return redirect()->route('country_rate_and_tax.index')->with('success', 'Country Tax created successfully.');
    }

    public function edit(Countryrate $country_rate_and_tax)
    {
        $allCountries = $this->getCountries();
        return view('country_rate_and_tax.edit', ['countries' => $allCountries, 'country_rate_and_tax' => $country_rate_and_tax]);
    }

    public function update(Request $request, Countryrate $country_rate_and_tax)
    {
        $request->validate([
            'country_name' => 'required',
            'country_code' => 'required',
            'rate' => 'required',
            'tax' => 'required',
            'description' => 'string|nullable',
        ]);

        $country_rate_and_tax->country_name = $request->country_name;
        $country_rate_and_tax->country_code = $request->country_code;
        $country_rate_and_tax->product_type = $request->product_type;
        $country_rate_and_tax->rate = $request->rate;
        $country_rate_and_tax->tax = $request->tax;
        $country_rate_and_tax->description = $request->description;
        $country_rate_and_tax->save();

        return redirect()->route('country_rate_and_tax.index')->with('success', 'Country rate updated successfully');
    }

    public function destroy(Countryrate $country_rate_and_tax)
    {
        $country_rate_and_tax->delete();
        return redirect()->route('country_rate_and_tax.index')->with('success', 'Country rate deleted successfully');
    }
}
