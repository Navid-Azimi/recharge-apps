<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\GetCountries;
use App\Models\GiftCard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GiftCardController extends Controller
{
    use GetCountries;
    public function index(): View
    {
        $filterConditions = getRequestFilters(['country_iso', 'giftCard_name']);
        $giftcard = GiftCard::getRecords($filterConditions)->get();
        $countries = $this->getCountries();

        return view('giftcard.index', compact('giftcard', 'countries'))->with('i');
    }

    public function create(): View
    {
        return view('giftcard.create', ['countries' => $this->getCountries()]);
    }

    public function store(Request $request)
    {
        $this->validator($request);
        $giftcard = new GiftCard;
        $giftcard->name = $request->name;
        $giftcard->country_iso = $request->country_iso;
        $giftcard->discription = $request->discription ?? "";
        $giftcard->save();

        return redirect()->route('giftcard.index')->with('success', 'Giftcard created successfully.');
    }


    public function show(GiftCard $giftcard): View
    {
        return view('giftcard.show', ['giftcard' => $giftcard]);
    }

    public function update(Request $request, GiftCard $giftcard): RedirectResponse
    {
        $this->validator($request);

        $giftcard->name = $request->name;
        $giftcard->discription = $request->discription;
        $giftcard->save();

        return redirect()->route('giftcard.index')->with('success', 'Giftcard updated successfully.');
    }


    protected function validator($request)
    {
        return  $request->validate([
            'name' => 'required|string',
            'discription' => 'string'
        ]);
    }

    public function destroy(GiftCard $giftcard): RedirectResponse
    {

        $giftcard->delete();
        return redirect()->route('giftcard.index')->with('success', 'Giftcard deleted successfully.');
    }
}
