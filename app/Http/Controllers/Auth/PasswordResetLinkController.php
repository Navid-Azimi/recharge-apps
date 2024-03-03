<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    use SendsPasswordResetEmails;
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'title' => 'Email Not Found',
                'content' => 'The email you entered does not exist in our records. Please verify your email or sign up if you\'re new.'
            ], 404);
        }
    
        // Send the password reset link and get the status
        $status = Password::sendResetLink(
            $request->only('email')
        );
    
        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => __('passwords.sent')], 200);
        } elseif ($status === Password::INVALID_USER) {
            return response()->json(['message' => __('passwords.user')], 422);
        }
    
        return response()->json(['message' => 'An unknown error occurred'], 500);
    }
    
    
}
