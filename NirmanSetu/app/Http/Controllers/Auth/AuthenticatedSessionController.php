<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // This uses your custom LoginRequest logic
        $request->authenticate();

        // Regenerate session to prevent session fixation
        $request->session()->regenerate();

        $user = Auth::user();

        // ✅ Redirect based on user role
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');

            case 'engineer':
                return redirect()->route('contractor.dashboard');

            case 'client':
            case 'customer':
                return redirect()->route('client.dashboard');

            default:
                Auth::logout();
                return redirect()->route('login')->withErrors([
                    'email' => 'Unauthorized role.',
                ]);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}