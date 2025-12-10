<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task; // Adjust if your model is named differently

class ContractorTaskController extends Controller
{
    public function index()
    {
        // Fetch only tasks assigned to the logged-in contractor
        $contractorId = auth()->id();
        $tasks = Task::where('assigned_to', $contractorId)->get();

        return view('contractor.tasks', compact('tasks'));
    }
}
