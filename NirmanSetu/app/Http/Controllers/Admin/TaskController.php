<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;
use App\Models\User;

class TaskController extends Controller
{
    // ✅ List all tasks
    public function index()
    {
        $tasks = Task::with(['project', 'assignedTo'])->latest()->paginate(10);
        return view('admin.tasks.index', compact('tasks'));
    }

    // ✅ Show create form
    public function create()
    {
        $projects = Project::all();
        $users = User::where('role', 'engineer')->get();
        return view('admin.tasks.create', compact('projects', 'users'));
    }

    // ✅ Store task
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'required|exists:users,id',
            'due_date' => 'required|date',
        ]);

        Task::create($request->all());

        return redirect()->route('tasks.index')->with('success', 'Task assigned successfully!');
    }

    // ✅ Edit task
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $projects = Project::all();
        $users = User::where('role', 'engineer')->get();
        return view('admin.tasks.edit', compact('task', 'projects', 'users'));
    }

    // ✅ Update task
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'required|exists:users,id',
            'due_date' => 'required|date',
        ]);

        $task = Task::findOrFail($id);
        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', 'Task updated!');
    }

    // ✅ Delete task
    public function destroy($id)
    {
        Task::destroy($id);
        return redirect()->route('tasks.index')->with('success', 'Task deleted!');
    }
}
