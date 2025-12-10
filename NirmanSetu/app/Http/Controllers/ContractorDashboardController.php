<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;
use App\Models\DailyProgress;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth; // ✅ FIXED

class ContractorDashboardController extends Controller
{public function index()
{
    $contractorId = Auth::id();

    $totalProjects = Project::where('contractor_id', $contractorId)->count();

    $totalProgressEntries = DailyProgress::where('contractor_id', $contractorId)->count();

    $todayProgress = DailyProgress::where('contractor_id', $contractorId)
                                  ->whereDate('date', Carbon::today())
                                  ->count();

    $upcomingDeadlines = Task::where('contractor_id', $contractorId)
                             ->whereDate('due_date', '>=', now())
                             ->whereDate('due_date', '<=', now()->addDays(7))
                             ->count();

    return view('contractor.dashboard', compact(
        'totalProjects',
        'totalProgressEntries',
        'todayProgress',
        'upcomingDeadlines'
    ));
}

}
