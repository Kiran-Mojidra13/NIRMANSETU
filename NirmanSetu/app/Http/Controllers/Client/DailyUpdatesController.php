<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DailyUpdatesController extends Controller
{
    public function index(Request $request)
    {
        $clientName = Auth::user()->name;

        // Get project IDs for this client
        $projectIds = DB::table('projects')
            ->where('client_name', $clientName)
            ->pluck('id');

        // Fetch daily updates with task titles
        $dailyUpdates = DB::table('daily_progress as dp')
            ->join('tasks as t', 'dp.task_id', '=', 't.id')
            ->select('dp.*', 't.title as task_title')
            ->whereIn('dp.project_id', $projectIds)
            ->orderBy('dp.date', 'desc')
            ->get();

        // Search filter
        if ($request->has('search') && $request->search != '') {
            $search = strtolower($request->search);
            $dailyUpdates = $dailyUpdates->filter(function($update) use ($search) {
                return str_contains(strtolower($update->progress_description), $search) ||
                       str_contains(strtolower($update->work_done), $search) ||
                       str_contains(strtolower($update->task_title), $search);
            });
        }

        return view('client.daily_updates', ['dailyUpdates' => $dailyUpdates]);
    }
}
