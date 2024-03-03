<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\GetCountries;
use App\Mail\GiftCardEmail;
use App\Models\GiftCard;
use App\Models\GiftCardOwner;
use App\Models\GiftCardTransaction;
use App\Models\GiftType;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Stripe\Exception\CardException;
use Stripe\ExchangeRate;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Stripe\Token;

class GiftCardsController extends Controller
{
    use GetCountries;
    public function index(Request $request)
    {
        $activeGiftCardsCount = GiftCard::where('status', 'active')->count();
        $search = $request->only(['title','status']);
        if ($request->has('reset')) {
            $search = [
                'title' => '',
                'status' => '',
            ];}
        $giftCard = GiftCard::where(function ($query) use ($search) {
            if (!empty($search['status'])) {
                $query->where('status', 'like', '%' . $search['status'] . '%');
            }
            if (!empty($search['title'])) {
                $query->orWhereHas('giftType', function ($typeQuery) use ($search) {
                    $typeQuery->where('title', 'like', '%' . $search['title'] . '%');
                });
            }
        })->paginate(10);

        return view('gift_cards.index', [
            'giftcards' => $giftCard,
            'activeGiftCardsCount' => $activeGiftCardsCount,
            'search' => $search
        ]);
    }

    public function create()
    {
        return view('gift_cards.create', [
            'allCountries' => $this->getCountries(),
            'types' => GiftType::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|min:1|max:255',
            'value' => 'required|string|min:3|max:255|unique:gift_cards,value',
            // 'bar_code' => 'required|string|min:3|max:255|unique:gift_cards,bar_code',
        ]);

        $oldInput = $request->except('value');

        $giftcard = new GiftCard();
        $giftcard->price = $request->price;
        $giftcard->currency = $request->currency;
        $giftcard->discount = $request->discount;
        $giftcard->value = $request->value;
        $giftcard->total = $this->calculateTotal($request->price, $request->discount);
        $giftcard->bar_code = $request->bar_code;
        $giftcard->gift_type_id = $request->gift_type_id;
        $giftcard->save();

        return redirect()->route('giftcards.create')->with('success', 'Gift card created successfully')->withInput($oldInput);
    }

    public function edit(string $id)
    {
        $giftcard = GiftCard::findOrFail($id);
        return view('gift_cards.edit', [
            'giftcard' => $giftcard,
            'allCountries' => $this->getCountries(),
            'types' => GiftType::all(),
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|min:1|max:255',
            'value' => 'required|string|min:3|max:255|unique:gift_cards,value,' . $id,
            'bar_code' => 'required|string|min:3|max:255|unique:gift_cards,bar_code,' . $id,
        ]);


        $giftcard = GiftCard::findOrFail($id);

        $giftcard->price = $request->price;
        $giftcard->currency = $request->currency;
        $giftcard->discount = $request->discount;
        $giftcard->value = $request->value;
        $giftcard->total = $this->calculateTotal($request->price, $request->discount);
        $giftcard->bar_code = $request->bar_code;
        $giftcard->gift_type_id = $request->gift_type_id;
        $giftcard->save();

        return redirect()->route('giftcards.index')->with('success', 'Gift card updated successfully');
    }

    public function destroy(string $id)
    {
        $giftcard = GiftCard::findOrFail($id);
        $giftcard->delete();

        return redirect()->route('giftcards.index')->with('success', 'Gift card deleted successfully');
    }

    private function calculateTotal($price, $discount)
    {
        $price = floatval($price);

        $discount = floatval($discount);

        $total = $price - $discount;

        $total = max(0, $total);

        return $total;
    }

    public function sendGiftCard(Request $request)
    {
        $request->validate([
            'gift_type_id' => 'required|exists:gift_cards,id',
        ]);

        $giftType = GiftType::find($request->gift_type_id);
        $giftCard = GiftCard::where('gift_type_id', $giftType->id)
            ->where('status', 'active')->first();

        try {
            if ($request->has('promo_code')) {
                $promoCode = PromoCode::where('promo_code', $request->promo_code)->first();

                if (!$promoCode) {
                    return response()->json(['error' => 'Promo code is invalid'], 422);
                }

                $userHasUsedPromoCode = $promoCode->users()->where('user_id', auth()->id())->exists();

                if ($userHasUsedPromoCode) {
                    return response()->json(['error' => 'You have already used this promo code'], 422);
                }
    
                // If hasn't used, associate the promo code with the user
                $promoCode->users()->attach(auth()->id());

                if ($giftCard->price < $promoCode->min_amount || $giftCard->price > $promoCode->max_amount) {
                    return response()->json(['error' => 'Discount amount of this promo code is not valid for this gift card'], 422);
                }

                $discountAmount = $giftCard->price * ($promoCode->discount / 100);

                if ($discountAmount < $promoCode->min_amount || $discountAmount > $promoCode->max_amount) {
                    return response()->json(['error' => 'Calculated discount amount is not valid for this promo code'], 422);
                }

                $amountAfterDiscount = $giftCard->price - $discountAmount;

                $currency = $giftCard->currency;
                if (strtolower($currency) !== 'usd') {
                    $exchangeRate = ExchangeRate::retrieve([
                        'from' => strtolower($currency),
                        'to' => 'usd',
                    ]);
                    $amountInCents = round($amountAfterDiscount * $exchangeRate->rates['usd']) * 100;
                } else {
                    $amountInCents = round($amountAfterDiscount * 100);
                }
            } else {
                $amountInCents = $this->calculateAmountInCents($giftCard);
            }

            $card = $this->createStripeToken($request);
            $paymentIntent = PaymentIntent::create([
                'amount' => $amountInCents,
                'currency' => 'usd',
                'payment_method' => $card,
                'confirmation_method' => 'manual',
                'confirm' => true,
            ]);

            if (
                $paymentIntent->status === 'requires_action' ||
                $paymentIntent->status === 'requires_source_action'
            ) {
                return response()->json(['requires_action' => true, 'payment_intent_client_secret' => $paymentIntent->client_secret]);
            } elseif ($paymentIntent->status === 'succeeded') {
                $this->storeTransaction($giftCard, $paymentIntent);
                $this->updateGiftCardStatus($giftCard, 'sold');
                return response()->json([
                    'success' => true,
                    'giftCard' => $giftCard,
                ]);
            } else {
                return response()->json(['error' => 'Payment failed'], 500);
            }
        } catch (CardException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function resellerSendGiftCardToCustomer(Request $request)
    {
        dd($request->all());
    }

    public function giftCardsReports()
    {
        $filterConditions = getRequestFilters(['start_date', 'end_date', 'email', 'trans_id', 'status']);

        $transactions = GiftCardTransaction::getRecords($filterConditions)->paginate(10);
        return view('reports.giftcards', [
            'transactions' => $transactions,
        ]);
    }
    private function storeTransaction($giftCard, $paymentIntent)
    {
        $user = auth()->user();

        $gift_ownership = new GiftCardOwner();
        $gift_ownership->gift_card_id = $giftCard->id;
        $gift_ownership->owner_id = $user->id;
        $gift_ownership->save();

        $transaction = new GiftCardTransaction();
        $transaction->product = $giftCard->giftType->title;
        $transaction->currency = $giftCard->currency;
        $transaction->country = $giftCard->giftType->cardBrand->brand_country;
        $transaction->price = $giftCard->price;
        $transaction->discount = $giftCard->discount;
        $transaction->total = $this->calculateTotal($giftCard->price, $giftCard->discount);
        $transaction->status = $paymentIntent->status;
        $transaction->recipient_name = $user->name;
        $transaction->recipient_email = $user->email;
        $transaction->recipient_phone = $user->mobile_no;
        $transaction->save();

        $giftCard->recipient_name = $user->name;
        $giftCard->brand_name = $giftCard->giftType->cardBrand->brand_name;
        Mail::to($user->email)->send(new GiftCardEmail($giftCard));
    }

    private function updateGiftCardStatus($giftCard, $status)
    {
        $giftCard->status = $status;
        $giftCard->save();
    }

    private function calculateAmountInCents($giftCard)
    {
        $currency = $giftCard->currency;
        if (strtolower($currency) !== 'usd') {
            $exchangeRate = ExchangeRate::retrieve([
                'from' => strtolower($currency),
                'to' => 'usd',
            ]);
            return round($giftCard->price * $exchangeRate->rates['usd']) * 100;
        } else {
            return round($giftCard->price * 100);
        }
    }

    private function createStripeToken(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'card_number' => 'required|string',
            'cvc' => 'required|string',
            'exp_month' => 'required|string',
            'exp_year' => 'required|string',
        ]);

        try {
             Stripe::setApiKey(env('STRIPE_SECRET'));

             $token = Token::create([
                'card' => [
                    'number' => $request->input('card_number'),
                    'exp_month' => $request->input('exp_month'),
                    'exp_year' => $request->input('exp_year'),
                    'cvc' => $request->input('cvc'),
                    'name' => $request->input('name'),
                ],
            ]);

            return response()->json(['token' => $token->id], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
