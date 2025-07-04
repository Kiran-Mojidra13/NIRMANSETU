@extends('adminlte::page')

@section('title', 'Profile')

@section('content_header')
    <h1>👤 My Profile</h1>
@stop

@section('content')
    @if(session('success'))
        <x-adminlte-alert theme="success" title="Success" dismissable>
            {{ session('success') }}
        </x-adminlte-alert>
    @endif

    <div class="row">
        {{-- Update Profile --}}
        <div class="col-md-6">
            <x-adminlte-card title="Update Profile" theme="primary" icon="fas fa-user-edit">
                <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Name --}}
                    <x-adminlte-input name="name" label="Name" value="{{ old('name', Auth::user()->name) }}" required />

                    {{-- Email (readonly) --}}
                    <x-adminlte-input name="email" label="Email" type="email" value="{{ Auth::user()->email }}" readonly />

                    {{-- Profile Image --}}
                    <div class="mb-3">
                        <x-adminlte-input-file name="profile_photo" label="Upload Profile Picture" />

                        @php
                            $photoPath = Auth::user()->profile_photo_path;
                            $photoUrl = $photoPath && file_exists(public_path('storage/' . $photoPath))
                                        ? asset('storage/' . $photoPath)
                                        : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=random&color=fff';
                        @endphp

                        <img src="{{ $photoUrl }}" class="mt-2 rounded-circle" width="100" height="100" alt="Profile Picture" />
                    </div>

                    <x-adminlte-button type="submit" label="Update Profile" theme="primary" icon="fas fa-save" />
                </form>
            </x-adminlte-card>
        </div>

        {{-- Change Password --}}
        <div class="col-md-6">
            <x-adminlte-card title="Change Password" theme="warning" icon="fas fa-key">
                <form method="POST" action="{{ route('admin.profile.changePassword') }}">
                    @csrf
                    @method('PUT')

                    <x-adminlte-input name="current_password" label="Current Password" type="password" required />
                    <x-adminlte-input name="new_password" label="New Password" type="password" required />
                    <x-adminlte-input name="new_password_confirmation" label="Confirm New Password" type="password" required />

                    <x-adminlte-button type="submit" label="Change Password" theme="warning" icon="fas fa-key" />
                </form>
            </x-adminlte-card>
        </div>
    </div>
@stop
