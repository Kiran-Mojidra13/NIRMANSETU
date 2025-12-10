<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DailyProgress;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class DailyProgressController extends Controller
{
    public function index()
    {
        $contractorId = Auth::id();

        $dailyUpdates = DailyProgress::with(['project', 'task'])
            ->where('contractor_id', $contractorId)
            ->orderByDesc('date')
            ->get();

        return view('contractor.daily-updates', compact('dailyUpdates'));
    }

    public function create()
    {
        $projects = Project::where('contractor_id', Auth::id())->get();

        $tasks = Task::whereIn('project_id', $projects->pluck('id'))->get()->groupBy('project_id');

        $tasksByProject = [];
        foreach ($tasks as $projectId => $taskGroup) {
            $tasksByProject[$projectId] = $taskGroup->map(function ($task) {
                return ['id' => $task->id, 'title' => $task->title];
            });
        }

        return view('contractor.add_daily_update', compact('projects', 'tasksByProject'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'task_id' => 'required|exists:tasks,id',
            'progress_description' => 'required|string',
            'date' => 'required|date',
            'work_hours' => 'nullable|numeric',
            'labour_count' => 'nullable|integer',
            'status' => 'nullable|string',
            'work_done' => 'required|string',
            'remarks' => 'nullable|string',
            'before_photo' => 'nullable|image',
            'after_photo' => 'required|image',
        ]);

        // Handle image upload
        if ($request->hasFile('before_photo')) {
            $validated['before_photo'] = $request->file('before_photo')->store('progress_images', 'public');
        }

        if ($request->hasFile('after_photo')) {
            $validated['after_photo'] = $request->file('after_photo')->store('progress_images', 'public');
        }

        $validated['contractor_id'] = Auth::id();

        DailyProgress::create($validated);

        return redirect()->route('contractor.daily-updates')->with('success', 'Progress submitted successfully!');
    }

    // Update daily progress
    public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'progress' => 'required|numeric|min:0|max:100',
    ]);

    $dailyProgress = DailyProgress::findOrFail($id);
    $dailyProgress->title = $request->title;
    $dailyProgress->description = $request->description;
    $dailyProgress->progress = $request->progress;
    $dailyProgress->save();

    return redirect()->back()->with('success', 'Daily progress updated successfully!');
}


// Delete daily progress
public function destroy($id)
{
    $dailyProgress = DailyProgress::findOrFail($id);
    $dailyProgress->delete();

    return redirect()->back()->with('success', 'Daily progress deleted successfully!');
}


}