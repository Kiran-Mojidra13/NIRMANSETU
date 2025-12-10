<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user(); // logged-in client

        $search = $request->input('search');
        $status = $request->input('status');
        $sort = $request->input('sort', 'start_date');

        // Only projects where client_name matches logged-in user's name
        $projects = Project::where('client_name', $user->name)
            ->when($search, function($query, $search) {
                $query->where('name', 'like', "%$search%")
                      ->orWhere('location', 'like', "%$search%");
            })
            ->when($status, function($query, $status) {
                $query->where('status', $status);
            })
            ->orderBy($sort, 'asc')
            ->get();

        // Get tasks for each project
        $tasksByProject = [];
        foreach ($projects as $project) {
            $tasksByProject[$project->id] = Task::where('project_id', $project->id)->get();
        }

        // Map user ids to names (created_by and assigned_to)
        $userIds = collect($projects)->pluck('created_by')
            ->merge(collect($tasksByProject)->flatten()->pluck('assigned_to'))
            ->unique()->toArray();

        $usersById = User::whereIn('id', $userIds)->pluck('name','id');

        return view('client.projects', compact('projects','tasksByProject','usersById'));
    }
}
