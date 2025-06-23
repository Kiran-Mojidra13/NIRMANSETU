<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class DashboardController extends Controller
{
    public function index()
    {
        // Summary counts
        $totalUsers = User::count();
        $totalProjects = Project::count();
        $totalTasks = Task::count();
        $totalPayments = Payment::sum('amount');

        // Notifications for the logged-in user
        $notifications = Notification::where('user_id', Auth::id())
                            ->latest()
                            ->take(5)
                            ->get();

        $unreadCount = Notification::where('user_id', Auth::id())
                            ->where('is_read', false)
                            ->count();

        // Monthly payment summary
        $monthlyPayments = Payment::select(
                DB::raw("DATE_FORMAT(payment_date, '%b %Y') as month"),
                DB::raw("SUM(amount) as total")
            )
            ->groupBy('month')
            ->orderBy(DB::raw("MIN(payment_date)"))
            ->get();

        $months = $monthlyPayments->pluck('month');
        $amounts = $monthlyPayments->pluck('total');

        // Latest 5 projects
        $recentProjects = Project::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalProjects',
            'totalTasks',
            'totalPayments',
            'months',
            'amounts',
            'recentProjects',
            'notifications',
            'unreadCount'
        ));
    }
}
