<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile()
    {
        return view('admin.profile');
    }

    public function updateProfile(Request $request)
    {
        // handle update logic here
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/'); // or wherever the main user page is
    }
}
