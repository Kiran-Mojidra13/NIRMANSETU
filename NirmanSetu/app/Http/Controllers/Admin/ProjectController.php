<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
   public function index(Request $request)
{
    $query = Project::query();

    if ($request->has('search') && $request->search != '') {
        $query->where('name', 'like', "%{$request->search}%");
    }

    $projects = $query->orderBy('created_at', 'desc')->paginate(10);
    return view('admin.projects.index', compact('projects'));
}

public function create()
{
    return view('admin.projects.create'); // You'll create this blade next
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'description' => 'nullable|string',
    ]);

    Project::create([
        'name' => $request->name,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'description' => $request->description,
        'created_by' => auth()->id(),
    ]);

    return redirect()->route('admin.projects.index')->with('success', 'Project created successfully!');
}

public function edit($id)
{
    $project = Project::findOrFail($id);
    return view('admin.projects.edit', compact('project'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'description' => 'nullable|string',
    ]);

    $project = Project::findOrFail($id);
    $project->update($request->all());

    return redirect()->route('admin.projects.index')->with('success', 'Project updated!');
}

public function destroy($id)
{
    Project::destroy($id);
    return redirect()->route('admin.projects.index')->with('success', 'Project deleted.');
}

public function archive($id)
{
    $project = Project::findOrFail($id);
    $project->update(['status' => 'archived']); // Ensure your model has `status`
    return redirect()->route('admin.projects.index')->with('success', 'Project archived.');
}

public function show($id)
{
    $project = Project::findOrFail($id);
    return view('admin.projects.show', compact('project'));
}

}
