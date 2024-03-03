<?php

namespace App\Http\Controllers;

use App\Models\PromoCode;
use Illuminate\Http\Request;

class PromoCodesController extends Controller
{
    public function index()
    {
        $filterConditions = getRequestFilters(['promo_code', 'min_amount', 'max_amount', 'discount', 'start_date', 'end_date']);
        $promoCodes = PromoCode::getRecords($filterConditions)->paginate(10);
        return view('promo_codes.index', [
            'promoCodes' => $promoCodes,
        ]);
    }

    public function create()
    {
        return view('promo_codes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'promo_code' => 'required|string|min:3',
            'min_amount' => 'required|numeric|min:0',
            'max_amount' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0',
            'start_date' => 'required|string|min:0',
            'end_date' => 'required|string|min:0',
        ]);

        $existingPromoCode = PromoCode::where('promo_code', $request->promo_code)->first();

        if ($existingPromoCode) {
            return redirect()->back()->withErrors(['promo_code' => 'This code is already exists']);
        }

        $promoCode = new PromoCode();
        $promoCode->promo_code = $request->promo_code;
        $promoCode->min_amount = $request->min_amount;
        $promoCode->max_amount = $request->max_amount;
        $promoCode->discount = $request->discount;
        $promoCode->start_date = $request->start_date;
        $promoCode->end_date = $request->end_date;
        $promoCode->save();

        return redirect()->route('promocodes.index')->with('success', 'Promo Code Created Successfully!');
    }

    public function edit(string $id)
    {
        $promoCode = PromoCode::findOrFail($id);
        return view('promo_codes.edit', [
            'promoCode' => $promoCode,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'promo_code' => 'required|string|min:3',
            'min_amount' => 'required|numeric|min:0',
            'max_amount' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0',
            'start_date' => 'required|string|min:0',
            'end_date' => 'required|string|min:0',
        ]);

        $promoCode = PromoCode::find($id);
        $promoCode->promo_code = $request->promo_code;
        $promoCode->min_amount = $request->min_amount;
        $promoCode->max_amount = $request->max_amount;
        $promoCode->discount = $request->discount;
        $promoCode->start_date = $request->start_date;
        $promoCode->end_date = $request->end_date;
        $promoCode->save();

        return redirect()->route('promocodes.index')->with('success', 'Promo Code Updated Successfully!');
    }

    public function destroy(string $id)
    {
        $promoCode = PromoCode::find($id);
        $promoCode->delete();
        return redirect()->route('promocodes.index')->with('success', 'Promo Code deleted successfully!');
    }
}
