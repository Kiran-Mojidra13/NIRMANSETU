@extends('client.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <!-- Page Header -->
            <div class="card card-primary card-outline mb-4">
                <div class="card-header">
                    <h3 class="card-title">Client Profile</h3>
                </div>
            </div>

            <!-- Success Message -->
            @if(session('status'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{ session('status') }}
                </div>
            @endif

            <!-- Validation Errors -->
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Update Profile -->
            <div class="card card-primary mb-4">
                <div class="card-header">
                    <h3 class="card-title">Update Profile</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('client.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control"
                                   value="{{ old('name', $user->name ?? '') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control"
                                   value="{{ old('email', $user->email ?? '') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="profile_photo">Profile Photo</label>
                            @if(!empty($user->profile_photo_path))
                                <div class="mb-2">
                                    <img src="{{ asset('storage/'.$user->profile_photo_path) }}" alt="Profile Photo"
                                         class="img-thumbnail" style="width:120px;height:120px;">
                                </div>
                            @endif
                            <input type="file" name="profile_photo" class="form-control-file">
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Password -->
            <div class="card card-warning mb-4">
                <div class="card-header">
                    <h3 class="card-title">Change Password</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('client.profile.change_password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <input type="password" name="current_password" id="current_password" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <input type="password" name="new_password" id="new_password" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="new_password_confirmation">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required>
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-warning">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Account -->
            <div class="card card-danger mb-4">
                <div class="card-header">
                    <h3 class="card-title">Delete Client Account</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('client.profile.destroy') }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <div class="form-group">
                            <label for="password">Confirm Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-danger">Delete Account</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
