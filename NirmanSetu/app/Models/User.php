<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    // ✅ Add this:
    public function projects()
    {
        return $this->hasMany(Project::class, 'created_by');
    }
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo_path',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // ✅ Used by AdminLTE for profile image
    public function adminlte_image()
    {
        return $this->profile_photo_path && file_exists(public_path('storage/' . $this->profile_photo_path))
            ? asset('storage/' . $this->profile_photo_path)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=random&color=fff';
    }

    // ✅ Used by AdminLTE for user description
    public function adminlte_desc()
    {
        return 'Admin'; // You can return dynamic value like $this->role if you have one
    }

    // ✅ Used by AdminLTE for profile link
    public function adminlte_profile_url()
    {
        return route('admin.profile');
    }
}
