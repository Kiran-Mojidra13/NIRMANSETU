<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            // Ignore Intelephense warning — this method works
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                return redirect('/login')->withErrors(['email' => 'Unauthorized user. Contact admin.']);
            }

            if ($user->status !== 'active') {
                return redirect('/login')->withErrors(['email' => 'Your account is ' . $user->status . '.']);
            }

            Auth::login($user);

            return redirect()->intended(\App\Providers\RouteServiceProvider::redirectBasedOnRole());

        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['email' => 'Google login failed. Try again.']);
        }
    }
}