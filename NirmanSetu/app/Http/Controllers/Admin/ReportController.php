<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;
use App\Models\Invoice;
use App\Models\Estimate;
use App\Models\Material;
use App\Models\User;
use App\Models\Payment;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportExport;

class ReportController extends Controller
{
    public function index()
    {
        // 1️⃣ Project Summary
        $totalProjects = Project::count();
        $activeProjects = Project::where('status', 'active')->count();
        $completedProjects = Project::where('status', 'completed')->count();
        $delayedProjects = Project::where('status', 'delayed')->count();

        // 2️⃣ Task Summary
        $totalTasks = Task::count();
        $completedTasks = Task::where('status', 'completed')->count();
        $pendingTasks = Task::where('status', 'pending')->count();

        // 3️⃣ Financial
        $totalEstimates = Estimate::sum('total_amount');
        $totalInvoices = Invoice::sum('total_amount');
        $totalPaid = Payment::sum('amount');

        // 4️⃣ Materials
        $lowStockMaterials = Material::where('quantity', '<', 50)->get();

        // 5️⃣ Clients
        $clients = User::where('role', 'client')->withCount('projects')->get();

        return view('admin.reports.index', compact(
            'totalProjects', 'activeProjects', 'completedProjects', 'delayedProjects',
            'totalTasks', 'completedTasks', 'pendingTasks',
            'totalEstimates', 'totalInvoices', 'totalPaid',
            'lowStockMaterials',
            'clients'
        ));
    }

    public function exportExcel()
    {
        $projects = Project::all();
        $tasks = Task::all();
        $estimates = Estimate::all();
        $invoices = Invoice::all();
        $payments = Payment::all();
        $materials = Material::all();
        $clients = User::where('role', 'client')->get();

        $data = [
            ['Total Projects', $projects->count()],
            ['Total Tasks', $tasks->count()],
            ['Total Estimates', $estimates->sum('total_amount')],
            ['Total Invoices', $invoices->sum('total_amount')],
            ['Total Payments', $payments->sum('amount')],
        ];

        return Excel::download(new ReportExport($data), 'project_report.xlsx');
    }
}
