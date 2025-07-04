<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'client_id',
        'title',
        'total_amount',
        'pdf_path',
        'status',
        'due_date',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
