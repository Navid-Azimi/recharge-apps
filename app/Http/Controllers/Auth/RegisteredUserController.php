<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Carbon\Carbon;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Validation\Rule;
use Laravel\Socialite\Facades\Socialite;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'user_role' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = new User();
        $user->name  = $request->name;
        $user->email  = $request->email;
        $user->user_role  = $request->user_role;
        $user->password  = Hash::make($request->password);
        $user->save();

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    // api user update
    public function user_update(Request $request, $id)
    {

        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        if ($request->has('phone') && User::where('mobile_no', $request->phone)->where('id', '!=', $id)->exists()) {
            return response()->json([
                'title' => 'Phone Number Already Taken',
                'content' => 'The phone number you entered is already associated with another user in our database. Please choose a different phone number.'
            ], 400);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->user_country = $request->country_name;
        $user->user_country_iso = $request->country_iso;
        $user->get_updates_from_gmail = $request->get_updates_from_gmail;
        $user->final_info_req_top = $request->final_info_req_top;
        $user->operator_name = $request->operator_name;
        $user->phone_verified = $request->phone_verified;
        $user->operator_logo = $request->operator_logo;
        $user->mobile_no = $request->phone;
        $user->save();

        return response()->json(['message' => 'User updated successfully', 'user_info' => $user], 200);
    }

    // api login with gmail
    public function login_with_email(Request $request)
    {
        try {

            $user = new User();
            $user->name  = null;
            $user->email  = $request->email;
            $user->user_role  = 'customer';
            $user->password  = Hash::make($request->password);
            $user->save();

            return respondWithToken(false, $user, 'Welcome! You\'re now logged in');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create user. Some information is missing or the email is duplicate.'], 500);
        }
    }

    public function login_api(Request $request)
    {
        $request->merge([
            'email' => strtolower($request->email),
        ]);

        $req = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($req->fails()) {
            return response()->json($req->errors(), 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'title' => 'Email Not Found',
                'content' => 'The email you entered does not exist in our system. Please check your email or sign up if you\'re new.',
            ], 400);
        }

        if (!$user->hasVerifiedEmail()) {
            return response()->json([
                'title' => 'Email Not Verified',
                'content' => 'You need to verify your email address before logging in. Please check your email for the verification link.',
            ], 400);
        }

        if (!auth()->attempt(array_merge($req->validated()))) {

            return response()->json([
                'title' => 'Incorrect Password',
                'content' => 'The password you entered is incorrect. Please double-check your password and try again.',
            ], 400);
        }


        return respondWithToken(false, auth()->user(), 'Welcome! You\'re logged in successfully');
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout_api()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh_api()
    {
        return respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard('api');
    }


    /**
     *  loged in usr name and phone
     */
    public function getUserDetails()
    {
        $user = auth()->user(); // Just logged-in users detailse well availablem
        $responseData = [
            'name' => $user->name,
            'mobile_no' => $user->mobile_no,
        ];
        return response()->json($responseData);
    }

    public function getSingleUser($id)
    {

        $user = User::findOrFail($id);
        try {
            if ($user) {
                return response()->json([
                    'success' => true,
                    'user' => $user,
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'User not found',
            ]);
        }
    }
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register_api(Request $request)
    {

        if (User::where('email', $request->email)->exists()) {
            return response()->json([
                'title' => 'Duplicate Email',
                'content' => 'The email you entered is already in use. Please use a different email address.'
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'nullable',
            'email' => ['required', 'email'],
            'user_role' => 'required',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 400);
        }

        try {

            $user = new User();
            $user->name  = $request->name;
            $user->email  = $request->email;
            $user->user_role  = $request->user_role;
            $user->password  = Hash::make($request->password);
            $user->save();

            $user->notify(new VerifyEmailNotification());

            return response()->json([
                'success' => true,
                'message' => 'Your registration was successful! Please check your email for verification.',
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create user, Probably some infos are missing or email is duplicate.'], 500);
        }
    }

    public function verify_email(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        if (!hash_equals((string) $id, (string) $user->getKey())) {
            return response()->json(['error' => 'Invalid verification link'], 403);
        }

        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return response()->json(['error' => 'Invalid verification link'], 403);
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->to('https://kikwek.com/#/login');
        }

        $user->markEmailAsVerified();

        event(new Verified($user));
        return redirect()->to('https://kikwek.com/#/login');
    }


    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified'], 200);
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->json(['message' => 'Verification email sent'], 200);
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function googleCallback(Request $request)
    {
        try {
            $user = Socialite::driver('google')->user();

            $findUser = User::where('google_id', $user->id)
                ->orWhere('email', $user->email)
                ->first();

            if ($findUser) {

                Auth::login($findUser);
                return $this->redirectWithToken($findUser, 'Welcome! You\'re logged in successfully');
            } else {
                $newUser = new User();
                $newUser->name = $user->name;
                $newUser->email = $user->email;
                $newUser->google_id = $user->id;
                $newUser->email_verified_at = '2023-11-16 07:13:51';
                $newUser->password = encrypt('123456dummy');
                $newUser->save();

                Auth::login($newUser);

                return $this->redirectWithToken($newUser, 'Welcome! You\'re logged in successfully');
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Problem with Sign in, Do you have an account?']);
        }
    }

    protected function redirectWithToken($user, $message)
    {
        $tokenResponse = respondWithToken(false, $user, $message);

        $token = json_decode($tokenResponse->getContent())->access_token;

        return redirect('https://kikwek.com/#/?token=' . $token . '&id=' . $user->id);
    }
}
