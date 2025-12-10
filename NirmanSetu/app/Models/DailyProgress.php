<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'contractor_id',
        'project_id',
        'task_id',
        'progress_description',
        'date',
        'work_hours',
        'labour_count',
        'status',
        'work_done',
        'remarks',
        'before_photo',
        'after_photo',
    ];

    public function contractor()
    {
        return $this->belongsTo(User::class, 'contractor_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
