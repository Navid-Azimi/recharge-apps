<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class FacebookController extends Controller
{
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();

            $existingUser = User::where('email', $facebookUser->getEmail())->first();

            if ($existingUser) {
                Auth::login($existingUser);
                return $this->redirectWithToken($existingUser, 'Welcome! You\'re logged in successfully');
            } else {
                $newUser = new User;
                $newUser->name = $facebookUser->getName();
                $newUser->email = $facebookUser->getEmail();
                $newUser->email_verified_at = '2023-11-16 07:13:51';
                $newUser->facebook_id = $facebookUser->getId();
                $newUser->save();

                Auth::login($newUser);

                return $this->redirectWithToken($newUser, 'Welcome! You\'re logged in successfully');
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    protected function redirectWithToken($user, $message)
    {
        $tokenResponse = respondWithToken(false, $user, $message);

        $token = json_decode($tokenResponse->getContent())->access_token;

        return redirect('https://kikwek.com/#/?token=' . $token . '&id=' . $user->id);
    }
}
