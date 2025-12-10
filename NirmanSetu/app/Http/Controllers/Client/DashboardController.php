<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $clientName = Auth::user()->name; // assuming client_name matches logged-in user's name

        // -------------------------
        // 1. Projects
        // -------------------------
        $projects = DB::table('projects')
            ->where('client_name', $clientName)
            ->get();

        // -------------------------
        // 2. Tasks (for completed/total)
        // -------------------------
        $totalTasks = DB::table('tasks as t')
            ->join('projects as p', 't.project_id', '=', 'p.id')
            ->where('p.client_name', $clientName)
            ->count();

        $completedTasks = DB::table('tasks as t')
            ->join('projects as p', 't.project_id', '=', 'p.id')
            ->where('p.client_name', $clientName)
            ->where('t.status', 'completed')
            ->count();

        // -------------------------
        // 3. Invoices
        // -------------------------
        $invoices = DB::table('invoices as i')
            ->join('projects as p', 'i.project_id', '=', 'p.id')
            ->where('p.client_name', $clientName)
            ->get();

        // -------------------------
        // 4. Estimates
        // -------------------------
        $estimates = DB::table('estimates as e')
            ->join('projects as p', 'e.project_id', '=', 'p.id')
            ->where('p.client_name', $clientName)
            ->get();

        // -------------------------
        // 5. Documents
        // -------------------------
        $documents = DB::table('documents as d')
            ->join('projects as p', 'd.project_id', '=', 'p.id')
            ->where('p.client_name', $clientName)
            ->get();

        // -------------------------
        // 6. Site Visits (future only)
        // -------------------------
        $siteVisits = DB::table('site_visits as sv')
            ->join('projects as p', 'sv.project_id', '=', 'p.id')
            ->where('p.client_name', $clientName)
            ->where('sv.visit_date', '>=', Carbon::now())
            ->select('sv.*', 'p.name as project_name')
            ->orderBy('sv.visit_date', 'asc')
            ->get();

        // -------------------------
        // 7. Status Counts (for pie chart)
        // -------------------------
      $statusCounts = [
    'in_progress' => (int) $projects->where('status', 'in_progress')->count(),
    'planned'     => (int) $projects->where('status', 'planned')->count(),
    'on_hold'     => (int) $projects->where('status', 'on_hold')->count(),
    'completed'   => (int) $projects->where('status', 'completed')->count(),
    'delayed'     => (int) $projects->where('status', 'delayed')->count(),
];


        return view('client.dashboard', compact(
            'projects',
            'completedTasks',
            'totalTasks',
            'invoices',
            'estimates',
            'documents',
            'siteVisits',
            'statusCounts'
        ));
    }
}
