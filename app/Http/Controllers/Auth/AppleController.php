<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AppleController extends Controller
{
    public function redirectToApple()
    {
        return Socialite::driver('apple')->redirect();
    }

    public function handleAppleCallback()
    {
        try {
            $appleUser = Socialite::driver('apple')->user();

            $existingUser = User::where('email', $appleUser->getEmail())->first();

            if ($existingUser) {
                Auth::login($existingUser);
                return $this->redirectWithToken($existingUser, 'Welcome! You\'re logged in successfully');
            } else {
                $newUser = new User;
                $newUser->name = $appleUser->getName();
                $newUser->email = $appleUser->getEmail();
                $newUser->email_verified_at = '2023-11-16 07:13:51';
                $newUser->apple_id = $appleUser->getId();
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
