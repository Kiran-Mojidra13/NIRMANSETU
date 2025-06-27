<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use App\Models\Payment;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Summary counts
        $totalUsers = User::count();
        $totalProjects = Project::count();
        $totalTasks = Task::count();
        $totalPayments = Payment::sum('amount');

        // Monthly Payments Chart (last 6 months)
        $monthlyPayments = Payment::select(
                DB::raw("DATE_FORMAT(payment_date, '%b %Y') as month"),
                DB::raw("SUM(amount) as total")
            )
            ->where('payment_date', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderByRaw("STR_TO_DATE(month, '%b %Y') ASC")
            ->get();

        $months = $monthlyPayments->pluck('month');
        $amounts = $monthlyPayments->pluck('total');

        // Recent Projects & Tasks
        $recentProjects = Project::latest()->take(5)->get();
        $recentTasks = Task::latest()->take(5)->get();

        // Notifications (only for logged-in admin)
        $notifications = Notification::where('user_id', Auth::id())
                            ->latest()
                            ->take(5)
                            ->get();

        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalProjects' => $totalProjects,
            'totalTasks' => $totalTasks,
            'totalPayments' => $totalPayments,
            'recentProjects' => $recentProjects,
            'recentTasks' => $recentTasks,
            'notifications' => $notifications,
            'months' => $months,
            'amounts' => $amounts,
        ]);
    }
}
