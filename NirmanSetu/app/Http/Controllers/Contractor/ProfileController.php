<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    /**
     * Show contractor profile form
     */
    public function edit(Request $request): View
    {
        return view('contractor.profile', [
            'user' => $request->user()
        ]);
    }

    /**
     * Update contractor profile
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $request->user()->id,
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = $request->user();

        $user->name = $request->name;
        $user->email = $request->email;

        // Upload contractor profile photo
        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo_path && Storage::exists($user->profile_photo_path)) {
                Storage::delete($user->profile_photo_path);
            }

            $path = $request->file('profile_photo')->store('contractors/profile_photos', 'public');
            $user->profile_photo_path = $path;
        }

        $user->save();

        return Redirect::route('contractor.profile.edit')
            ->with('status', 'Profile updated successfully!');
    }

    /**
     * Change contractor password
     */
    public function changePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:8|confirmed', // must match new_password_confirmation
        ]);

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return Redirect::route('contractor.profile.edit')
            ->with('status', 'Password changed successfully!');
    }

    /**
     * Delete contractor account
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => 'required'
        ]);

        $user = $request->user();

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Incorrect password']);
        }

        Auth::logout();

        if ($user->profile_photo_path && Storage::exists($user->profile_photo_path)) {
            Storage::delete($user->profile_photo_path);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with('status', 'Contractor account deleted successfully!');
    }
}
