<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'details',
        'project_id',
        'assigned_to',
        'status',
        'due_date',
    ];

    // ✅ Add this relationship to Project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // ✅ Add this relationship to the User assigned
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    
}
