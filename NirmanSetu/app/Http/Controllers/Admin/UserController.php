<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // ✅ Admin Profile Page
    public function profile()
    {
        return view('admin.profile');
    }

    // ✅ Logout
    public function logout()
    {
        auth()->logout();
        return redirect('/'); // Redirect to login or homepage
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