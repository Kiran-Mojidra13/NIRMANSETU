<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'created_by',
    ];
public function contractor()
{
    return $this->belongsTo(User::class, 'contractor_id');
}

    // app/Models/Project.php
public function tasks() { return $this->hasMany(Task::class); }

}