<?php

namespace App\Http\Controllers;

use App\Models\Networks;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class PhoneVerificationController extends Controller
{

    public function sendVerificationCode(Request $request)
    {

        try {
            $twilio = $this->get_client();

            $twilioPhoneNumber = env('Twillio_Phone');
            $twillio_service_id = env('Twilio_service_id');

            $verification = $twilio->verify->v2->services($twillio_service_id)
                ->verifications
                ->create($request->phone, 'sms', ['from' => $twilioPhoneNumber]);

            if ($verification->status === 'pending') {
                return response()->json(['message' => 'Verification Code Sent!'], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to send verification code. '. $e->getMessage()], 500);
        }
    }

    public function verifyCode(Request $request)
    {
        try {
            $phoneNumber = $request->input('phone');
            $operator = Networks::where('ntw_name', get_network_from_phone(substr($phoneNumber, 1)))->first();

            $verificationCode = $request->input('verification_code');

            $twilio = $this->get_client();
            $twillio_service_id = env('Twilio_service_id');

            $verificationCheck = $twilio->verify->v2->services($twillio_service_id)
                ->verificationChecks
                ->create(['code' => $verificationCode, 'to' => "$phoneNumber"]);

            if ($verificationCheck->status === 'approved') {

                $user = User::where('mobile_no', $phoneNumber)->first();

                if (!$user) {
                    $user = new User();
                }
                $user->mobile_no = $phoneNumber;
                $user->name = $phoneNumber;
                $user->user_country = getCountryFromPhone($request->phone);
                $user->phone_verified = true;
                $user->user_country_iso = $request->country_iso;
                $user->get_updates_from_gmail = $request->get_updates_from_gmail;
                $user->final_info_req_top = $request->final_info_req_top;
                $user->operator_name = $operator->ntw_name;
                $user->operator_logo = $operator->ntw_logo;
                $user->email = 'customer_' . $phoneNumber . '@gmail.com';
                $user->password = Hash::make(Str::random(8));
                $user->user_role = 'customer';
                $user->save();

                return respondWithToken(false, $user);
            } else {
                return response()->json([
                    'title' => 'Invalid Validation Code',
                    'content' => 'The validation code you entered is incorrect. Please double-check and try again.'
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Verification Failed.' . $e->getMessage()], 400);
        }
    }

    public function get_client()
    {

        $Twilio_SID = env('Twilio_SID');
        $twillio_token = env('Twilio_Token');

        return new Client($Twilio_SID, $twillio_token);
    }
}
