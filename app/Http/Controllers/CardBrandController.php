<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\GetCountries;
use App\Http\Controllers\Traits\UploadImage;
use App\Models\CardBrand;
use App\Models\GiftCard;
use App\Models\GiftType;
use App\Models\RequestsReseller;
use App\Models\GiftCardTransaction;
use Illuminate\Http\Request;

class CardBrandController extends Controller
{
    use GetCountries;
    use UploadImage;
    public function index(Request $request)
    {
        $allCountries = $this->getCountries();
        $search = $request->only(['brand_country', 'brand_name']);
        if ($request->has('reset')) {
            $search = [
                'brand_country' => '',
                'brand_name' => '',
            ];}
        $brands = CardBrand::where(function ($query) use ($search) {
            if (!empty($search['brand_country'])) {
                $query->where('brand_country', 'like', '%' . $search['brand_country'] . '%');
            }
            if (!empty($search['brand_name'])) {
                $query->orWhere('brand_name', 'like', '%' . $search['brand_name'] . '%');
            }
        })->paginate(10);

        return view('card_brands.index', [
            'giftcardbrands' => $brands,
            'search' => $search,
            'countries' => $allCountries
        ]);
    }

    public function create()
    {
        return view('card_brands.create', [
            'allCountries' => $this->getCountries(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand_name' => 'required|min:3|string',
            'brand_logo' => 'required|image|mimes:jpeg,png,jpg,gif',
            'brand_country' => 'required|string|min:3|max:255',
        ]);

        $brand = new CardBrand();
        $brand->brand_name = $request->brand_name;
        $brand->brand_country = $request->brand_country;
        $brand->brand_description = $request->brand_description;
        $brand->brand_logo = $request->hasFile('brand_logo') ? $this->uploadImage('brand_logo') : null;
        $brand->save();

        return redirect()->route('giftcardbrands.index')->with('success', 'Gift card brand created successfully');
    }

    public function edit(string $id)
    {
        $brand = CardBrand::findOrFail($id);
        return view('card_brands.edit', [
            'brand' => $brand,
            'allCountries' => $this->getCountries(),
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'brand_name' => 'required|min:3|max:255|string',
            'brand_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'brand_country' => 'required|string|min:3|max:255',
        ]);

        $brand = CardBrand::findOrFail($id);

        if ($brand->brand_logo and $request->hasFile('brand_logo')) {
            $this->deleteImage($brand->brand_logo);
            $brand->brand_logo = null;
        }
        $brand->brand_description = $request->brand_description;
        $brand->brand_logo = $request->hasFile('brand_logo') ? $this->uploadImage('brand_logo') : $brand->brand_logo;
        $brand->brand_country = $request->brand_country;
        $brand->brand_name = $request->brand_name;
        $brand->save();

        return redirect()->route('giftcardbrands.index')->with('success', 'Gift card brand updated successfully');
    }

    public function destroy(string $id)
    {
        GiftType::where('brand_id', $id)->update(['brand_id' => null]);
        $brand = CardBrand::findOrFail($id);
        if ($brand->brand_logo) {
            $this->deleteImage($brand->brand_logo);
        }
        $brand->delete();

        return redirect()->route('giftcardbrands.index')->with('success', 'Gift card brand deleted successfully');
    }

    public function api_brands()
    {
        $brands = CardBrand::all();

        return response()->json([
            'status' => 200,
            'brands' => $brands,
        ]);
    }

    public function cardBrandsByCountry(Request $request)
    {
        $brands = CardBrand::where('brand_country', $request->country)->get();
        return response()->json([
            'status' => 200,
            'brands' => $brands
        ]);
    }

    public function worldwideBrands()
    {
        $brands = CardBrand::where('brand_country', 'Worldwide')->get();
        return response()->json([
            'status' => 200,
            'brands' => $brands
        ]);
    }

    public function buyGifts()
    {
        $buyGift = CardBrand::latest()->paginate(10);
        return view('buy_gifts.index', compact('buyGift'));
    }

    public function myGifts()
    {
        $giftReseller = GiftCardTransaction::latest()->paginate(10);
        return view('my_gifts.index', compact('giftReseller'));
    }

    public function giftTypeList(Request $request)
    {
        $brandName = $request->input('brand_name');
        $query = GiftCard::with('giftType')->latest();
        if ($brandName) {
            $query->whereHas('giftType.cardBrand', function ($query) use ($brandName) {
                $query->where('brand_name', $brandName);
            }); 
        }
        $gTypeList = $query->paginate(10);
        return view('buy_gifts.gift_type_list', compact('gTypeList'));
    }

    public function api_requestsReseller(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'business_name' => 'required|string',
            'email' => 'required|email',
            'country' => 'required|string',
            'state_province' => 'required|string',
            'city' => 'required|string',
            'address' => 'required|string',
            'postal_code' => 'nullable|string',
            'phone_number' => 'required|string',
            'partner_type' => 'required|string',
            'company_size' => 'required|string',
            'hear_about_ding' => 'required|string',
            'interests' => ['required', 'array'],
            'authorized_signatory' => 'required|string',
        ]);
        $validatedData['interests'] = implode(',', $validatedData['interests']);
        $requestsReseller = new RequestsReseller($validatedData);
        $requestsReseller->save();

        return response()->json([
            'status' => 200,
            'message' => 'Request successfully stored',
            'requests_resel' => $requestsReseller,
        ]);
    }
}
