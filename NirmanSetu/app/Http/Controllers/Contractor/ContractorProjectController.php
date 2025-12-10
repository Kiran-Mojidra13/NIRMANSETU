<?php
// app/Http/Controllers/Contractor/ContractorProjectController.php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;

class ContractorProjectController extends Controller
{
public function index()
{
$contractorId = Auth::id();

// Only fetch projects assigned to this contractor
$projects = Project::where('contractor_id', $contractorId)->get();

return view('contractor.projects', compact('projects'));
}
}