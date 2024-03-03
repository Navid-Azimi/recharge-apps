<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Traits\UploadImage;
use App\Models\CardBrand;
use App\Models\GiftCard;
use App\Models\GiftType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PragmaRX\Countries\Package\Services\Countries;

class GiftCardTypesController extends Controller
{
    use UploadImage;
    public function index(Request $request)
    {
        $search = $request->only(['title','brand_name']);
        if ($request->has('reset')) {
            $search = [
                'title' => '',
                'brand_name' => '',
            ];}
        $types = GiftType::where(function ($query) use ($search) {
            if (!empty($search['title'])) {
                $query->where('title', 'like', '%' . $search['title'] . '%');
            }
            if (!empty($search['brand_name'])) {
                $query->orWhereHas('cardBrand', function ($brandQuery) use ($search) {
                    $brandQuery->where('brand_name', 'like', '%' . $search['brand_name'] . '%');
                });
            }
        })->paginate(10);

        return view('gift_card_types.index', [
            'giftcardtypes' => $types,
            'search' => $search 
        ]);
    }


    public function create()
    {
        $brands = CardBrand::all();
        return view('gift_card_types.create', [
            'brands' => $brands,
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'brand_id' => 'required',
        ], [
            'brand_id.required' => 'Brand field is required',
        ]);

        $type = new GiftType();
        $type->title = $request->title;
        $type->image = $request->hasFile('image') ? $this->uploadImage('image') : null;
        $type->brand_id = $request->brand_id;
        $type->terms = $request->terms;
        $type->description = $request->description;
        $type->save();

        return redirect()->route('giftcardtypes.index')->with('success', 'Gift card type created successfully!');
    }

    public function edit(string $id)
    {
        $type = GiftType::findOrFail($id);
        return view('gift_card_types.edit', [
            'type' => $type,
            'brands' => CardBrand::all(),
        ]);
    }


    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|min:3|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'brand_id' => 'required',
        ], [
            'brand_id.required' => 'Brand field is required',
        ]);

        $type = GiftType::find($id);

        if ($request->brand_id) {
            $type->brand_id = $request->brand_id;
        }

        $type->title = $request->title;
        $type->image = $request->hasFile('image') ? $this->uploadImage('image') : $type->image;
        $type->terms = $request->terms;
        $type->description = $request->description;
        $type->save();

        return redirect()->route('giftcardtypes.index')->with('success', 'Gift card type updated successfully!');
    }

    public function destroy(string $id)
    {
        $type = GiftType::findOrFail($id);
        if ($type->image) {
            $this->deleteImage($type->image);
        }
        $type->delete();

        return redirect()->route('giftcardtypes.index')->with('success', 'Gift card type deleted successfully!');
    }

    public function getGiftCardTypesByBrand(Request $request)
    {
        $country = 'United States';

        $giftBrand = CardBrand::find($request->brand_id);
        $giftTypes = $giftBrand->giftTypes;
        $exchangeRates = $this->getExchangeRate($this->getCountryCurrencyByCountryName($country));

        if ($exchangeRates) {
            foreach ($giftTypes as $giftType) {
                // $giftType = $this->getExchangedGiftCard($giftType, $country);
                $giftCard = $giftType->giftCards->first();
            
                if ($giftCard) {
                    $giftType = $this->getExchangedGiftCard($giftCard, $country);
                }
            }
        }

        return response()->json([
            'status' => 200,
            'gift_brand' => $giftBrand,
        ]);
    }

    public function giftCardDetails(Request $request)
    {
        try {
            $country = 'United States';
            $exchangeRates = $this->getExchangeRate($country);
    
            if ($exchangeRates) {

                $giftType = GiftType::with('giftCards')->findOrFail($request->id);
                $giftCard = $giftType->giftCards->first();
                $giftCard = $this->getExchangedGiftCard($giftCard, $country);
    
                return response()->json([
                    'status' => 200,
                    'gift_Card' => $giftCard->giftType->load('cardBrand'),
                ]);
            } else {
                return response()->json(['message' => 'Failed to fetch exchange rates'], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'errors' => [$e->getMessage()],
            ], 500);
        }
    }

    private function convertCurrency($amount, $fromExchangeRate, $toCurrency)
    {
        $toExchangeRate = 1;
        if ($toCurrency !== 'USD') {
            $toExchangeRate = $this->getExchangeRate($toCurrency);
        }

        return $amount * ($toExchangeRate / $fromExchangeRate);
    }

    private function getCountryCurrencyByCountryName($countryName)
    {
        $countries = new Countries();
        $countryName = $countries->where('name.common', $countryName)->first();
        return $countryName->currencies[0];
    }

    private function getExchangedGiftCard($giftCard, $country)
    {
        $giftCard->price = number_format($this->convertCurrency($giftCard->price, $this->getExchangeRate($giftCard->currency), $this->getCountryCurrencyByCountryName($country)), 2, '.', '');
        $giftCard->currency = $this->getCountryCurrencyByCountryName($country);
        return $giftCard;
    }

    private function getExchangeRate($currency)
    {
        $exchangeRateApiUrl = 'https://api.exchangerate-api.com/v4/latest/USD';

        try {
            $response = Http::get($exchangeRateApiUrl);

            if ($response->successful()) {
                $exchangeRateData = $response->json();

                $targetExchangeRate = $exchangeRateData['rates'][$currency] ?? null;

                if ($targetExchangeRate !== null) {
                    return $targetExchangeRate;
                }
            }

            return 1;
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
            return 1;
        }
    }
}
