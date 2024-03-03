<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\GetCountries;
use App\Exports\PaymentExport;
use App\Models\BillingInfo;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Maatwebsite\Excel\Facades\Excel;

class PaymentController extends Controller
{
    use GetCountries;

    public function index()
    {
        $filterConditions = getRequestFilters(['start_date', 'end_date', 'currency']);
        $countries = $this->getCountries();
        $user = Auth::user();
        switch ($user->user_role) {
            case 'admin':
                $payments = Payment::getPaymentsList($filterConditions)
                    ->paginate(10);
                $route = 'payments.paymentHistory.index';
                break;

            case 'reseller':
                $payments = Payment::getPaymentsList()
                    ->paginate(10);

                $route = 'payments.index';
                break;
        }

        return view($route, [
            'payments' => $payments,
            'countries' => $countries,
            'balance' => Payment::getBalance(),
        ]);
    }

    public function createPayment()
    {
        return view('my_wallet.create', [
            'balance' => Payment::getBalance(),
            'card' => BillingInfo::getCardDetails(),
            'otherCards' => BillingInfo::getAllCards()
        ]);
    }

    public function handlePayment(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('success.payment'),
                "cancel_url" => route('cancel.payment'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" =>  (float) $request->amount,
                    ],
                ],
            ],
        ]);

        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
            return redirect()
                ->route('cancel.payment')
                ->with('error', 'Something went wrong.');
        } else {
            return redirect()
                ->route('create.payment')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

    public function paymentCancel()
    {
        return redirect()
            ->route('create.payment')
            ->with('error', $response['message'] ?? 'You have canceled the transaction.');
    }

    public function paymentSuccess(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            return redirect()
                ->route('create.payment')
                ->with('success', 'Transaction complete.');
        } else {
            return redirect()
                ->route('create.payment')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }
 
    public function stripePost(Request $request)
    {
        // Create an instance of TopupsController and Call the doTopup function
        $topupController = new TopupsController();
        $topupOutput = $topupController->doTopup($request);

        if ($request->is_api) {
            return response()->json(["topup_info" => $topupOutput], 200);
        }

        return redirect('/')->with('flash_message', "Topup Done!");


        // try {

        //     $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        //     $payment_info = $stripe->paymentIntents->create([
        //         'amount' => (int) $request->top_amount,
        //         'currency' => 'usd',
        //         'payment_method' => 'pm_card_visa',
        //     ]);
        //     $request->payment_status = ($payment_info->status == "requires_confirmation");
        //     $this->storePayment($payment_info);

        //     // // Create an instance of TopupsController and Call the doTopup function
        //     // $topupController = new TopupsController();
        //     // $topupOutput = $topupController->doTopup($request);

        //     // if ($request->is_api) {
        //     //     return response()->json(["topup_info" => $topupOutput], 200);
        //     // }

        //     // return redirect('/')->with('flash_message', "Topup Done!");
        // } catch (\Exception $e) {
        //     return response()->json(['error' => 'Payment Failed', 'details' => $e->getMessage()], 500);
        // }
    }

    public function resellerPayment(Request $request)
    {
        try {
            // Stripe payment logic
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $existingCustomer = $stripe->customers->all([
                'email' => $request->user()->email,
                'limit' => 1,
            ]);

            if (count($existingCustomer->data) > 0) {
                $customer = $existingCustomer->data[0];
            } else {
                $customer = $stripe->customers->create([
                    'email' => $request->user()->email,
                    'description' => 'Customer for ' . $request->user()->name,
                ]);
            }

            $payment_info = $stripe->paymentIntents->create([
                'amount' => (float) $request->amount,
                'currency' => 'usd',
                'payment_method' => 'pm_card_visa',
                'customer' => $customer->id,
            ]);

            if ($request->has('stripeToken')) {
                $card_response = $stripe->customers->createSource(
                    $customer->id,
                    [
                        'source' => $request->stripeToken
                    ]
                );
            }

            $card = BillingInfo::where('card_number', $request->card_number)->first();

            if (empty($card)) {
                $this->storeCardDetails($request, $card_response->brand);
            }
            // Storing Payment information
            if ($request->has('amount')) {
                $this->storePayment($payment_info);
            }

            if (!$request->has('auto_recharge')) {
                return redirect()->back()->with('success', "Payment Created Successfully!");
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'Auto Recharge Implemented Successfully',
                ]);
            }
        } catch (\Exception $e) {
            if ($request->has('auto_recharge')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Auto Recharge Failed, ' . $e->getMessage(),
                ]);
            } else {
                return redirect()->back()->with('fail', 'Payment failed, ' . $e->getMessage());
            }
        }
    }

    public function storePayment($payment_info)
    {

        Payment::create([
            'amount' => $payment_info['amount'],
            'payment_method_types' => $payment_info['payment_method_types'][0],
            'status' => $payment_info['status'],
            'payment_method' => $payment_info['payment_method'],
            'currency' => $payment_info['currency'],
            'user_id' => Auth::user()->id,
            'payment_info_id' => $payment_info['id'],
        ]);

        return true;
    }
    public function storeCard(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name_on_card' => 'required|string',
            'card_number' => 'required|numeric',
            'expire_month' => 'required|numeric|between:1,12',
            'expire_year' => 'required|numeric|digits:4',
            'cvc' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->all(),
            ]);
        }

        $brand = getCardBrand($request);

        if (in_array('errors', array_keys($brand))) {
            return response()->json([
                'success' => false,
                'errors' => $brand['errors'],
            ]);
        }


        try {
            $card = BillingInfo::where('card_number', $request->card_number)->first();

            if (empty($card)) {
                $this->storeCardDetails($request, $brand['brand']);
            } else {
                return response()->json([
                    'success' => false,
                    'errors' => ['This Card is already exists!'],
                ]);
            }

            Session::flash('success', 'Card Added Successfully!');
            return response()->json([
                "status" => 200,
                'redirectURL' => route('create.payment'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function setAutoRechargeStatus(Request $request, $userId)
    {
        $this->autoRechargeSingleValueStore($request, 'is_auto_recharge_enabled', $userId);
    }

    public function setAutoRechargeAmount(Request $request, $userId)
    {
        if (auth()->user()->is_auto_recharge_enabled) {
            $this->autoRechargeSingleValueStore($request, 'recharge_amount', $userId);
        }
    }

    public function setAutoRechargeBalance(Request $request, $userId)
    {
        if (auth()->user()->is_auto_recharge_enabled) {
            $this->autoRechargeSingleValueStore($request, 'threshould_amount', $userId);
        }
    }

    protected function storeCardDetails($request, $brand)
    {
        $billing = new BillingInfo();
        $billing->card_number = $request->card_number;
        $billing->cvc = $request->cvc;
        $billing->expiration_month = $request->expire_month;
        $billing->expiration_year = $request->expire_year;
        $billing->name_on_card = $request->name_on_card;
        $billing->brand_name = $brand;
        $billing->user_id = Auth::user()->id;
        $billing->save();
        return true;
    }

    protected function autoRechargeSingleValueStore($request, $field, $userId)
    {
        $user = User::findOrFail($userId);
        $user->$field = $request->value;
        $user->save();
    }

    public function excelExport()
    {
        return Excel::download(new PaymentExport, 'payments-history.xlsx');
    }
}
