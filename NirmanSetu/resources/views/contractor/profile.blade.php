@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-3xl py-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">Contractor Profile</h2>

    {{-- Success --}}
    @if (session('status'))
        <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-700">
            {{ session('status') }}
        </div>
    @endif

    {{-- Errors --}}
    @if ($errors->any())
        <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-700">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                   <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Update --}}
    <div class="bg-white shadow-lg rounded-2xl p-6 mb-8">
        <form method="POST" action="{{ route('contractor.profile.update') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}"
                       class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}"
                       class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Profile Photo</label>
                @if (!empty($user->profile_photo_path))
                    <img src="{{ asset('storage/'.$user->profile_photo_path) }}" alt="Profile Photo"
                         class="w-24 h-24 rounded-full border mt-2 mb-3">
                @endif
                <input type="file" name="profile_photo"
                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                              file:rounded-lg file:border-0 file:text-sm file:font-semibold
                              file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100">
            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-xl shadow hover:bg-blue-700 transition">
                    Update Profile
                </button>
            </div>
        </form>
    </div>
{{-- Change Password --}}
<div class="bg-white shadow-lg rounded-2xl p-6 mb-8 border border-yellow-200">
    <h3 class="text-lg font-semibold text-yellow-600 mb-4">Change Password</h3>
    <form method="POST" action="{{ route('contractor.profile.change_password') }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700">Current Password</label>
            <input type="password" name="current_password" required
                   class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-300">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">New Password</label>
            <input type="password" name="new_password" required
                   class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-300">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Confirm New Password</label>
            <input type="password" name="new_password_confirmation" required
                   class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-300">
        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="bg-yellow-600 text-white px-6 py-2 rounded-xl shadow hover:bg-yellow-700 transition">
                Update Password
            </button>
        </div>
    </form>
</div>

    {{-- Delete --}}
    <div class="bg-white shadow-lg rounded-2xl p-6 border border-red-200">
        <h3 class="text-lg font-semibold text-red-600 mb-4">Delete Contractor Account</h3>
        <form method="POST" action="{{ route('contractor.profile.destroy') }}" class="space-y-4">
            @csrf
            @method('DELETE')

            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" required
                       class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-300">
            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="bg-red-600 text-white px-6 py-2 rounded-xl shadow hover:bg-red-700 transition">
                    Delete Account
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
