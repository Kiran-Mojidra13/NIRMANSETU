<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // ✅ Admin Profile Page
    public function profile()
    {
        return view('admin.profile');
    }

    // ✅ Update Profile
    public function updateProfile(Request $request)
    {
         /** @var \App\Models\User $user */
    $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'profile_photo' => 'nullable|image|max:2048',
        ]);

        $user->name = $request->name;

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->profile_photo_path = $path;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    // ✅ Change Password
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

         /** @var \App\Models\User $user */
    $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password changed successfully.');
    }

    // ✅ Logout
    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }

    // ✅ User List with Search + Pagination
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
        }

        $users = $query->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    // ✅ Show Add User Form
    public function create()
    {
        return view('admin.users.create');
    }

    // ✅ Store New User
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,customer,engineer',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'status' => 'active',
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully!');
    }

    // ✅ Show Edit User Form
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    // ✅ Update User
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$id}",
        ]);

        $user = User::findOrFail($id);
        $user->update($request->only(['name', 'email']));

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
    }

    // ✅ Delete User
    public function destroy($id)
    {
        User::destroy($id);

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
    }

    // ✅ Toggle Status
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = $user->status === 'active' ? 'suspended' : 'active';
        $user->save();

        return redirect()->back()->with('success', 'User status updated!');
    }
}
