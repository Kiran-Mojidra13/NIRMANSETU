<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalendarController extends Controller
{
    // Calendar page (Blade)
    public function index(Request $request)
    {
        $contractorId = auth()->id();

        // For the "Add Visit" form project dropdown
        $projects = DB::table('projects')
            ->select('id', 'name')
            ->where('contractor_id', $contractorId)
            ->orderBy('name')
            ->get();

        return view('contractor.calendar', compact('projects'));
    }

    // JSON feed for FullCalendar
    public function events(Request $request)
    {
        $contractorId = auth()->id();
        $categories   = collect(explode(',', (string)$request->query('categories', 'task,milestone,visit')))
                            ->filter()
                            ->map(fn($c) => strtolower(trim($c)))
                            ->values();
        $search       = trim((string)$request->query('search', ''));

        $events = [];

        // --- TASK DEADLINES ---
        if ($categories->contains('task')) {
            $tasks = DB::table('tasks')
                ->join('projects', 'projects.id', '=', 'tasks.project_id')
                ->where('tasks.contractor_id', $contractorId)
                ->when($search !== '', function ($q) use ($search) {
                    $q->where('projects.name', 'like', "%{$search}%");
                })
                ->whereNotNull('tasks.due_date')
                ->select([
                    'tasks.id',
                    'tasks.title',
                    'tasks.description',
                    'tasks.due_date',
                    'projects.name as project_name',
                ])
                ->get();

            foreach ($tasks as $t) {
                $events[] = [
                    'id'    => 'task-'.$t->id,
                    'title' => 'Task: '.$t->title,
                    'start' => $t->due_date,        // all-day
                    'allDay'=> true,
                    'color' => '#2563eb',           // blue
                    'extendedProps' => [
                        'category'     => 'Task Deadline',
                        'description'  => (string)$t->description,
                        'project_name' => (string)$t->project_name,
                        'can_edit'     => false,     // only visits are editable here
                    ],
                ];
            }
        }

        // --- PROJECT MILESTONES (use start_date / end_date as examples) ---
        if ($categories->contains('milestone')) {
            $projects = DB::table('projects')
                ->where('contractor_id', $contractorId)
                ->when($search !== '', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->select('id','name','start_date','end_date','status','description')
                ->get();

            foreach ($projects as $p) {
                if (!empty($p->start_date)) {
                    $events[] = [
                        'id'    => 'milestone-start-'.$p->id,
                        'title' => 'Milestone: Start - '.$p->name,
                        'start' => $p->start_date,
                        'allDay'=> true,
                        'color' => '#16a34a', // green
                        'extendedProps' => [
                            'category'     => 'Project Milestone',
                            'description'  => 'Project start'.(!empty($p->description) ? ' — '.mb_strimwidth($p->description, 0, 120, '…') : ''),
                            'project_name' => (string)$p->name,
                            'can_edit'     => false,
                        ],
                    ];
                }
                if (!empty($p->end_date)) {
                    $events[] = [
                        'id'    => 'milestone-end-'.$p->id,
                        'title' => 'Milestone: End - '.$p->name,
                        'start' => $p->end_date,
                        'allDay'=> true,
                        'color' => '#16a34a', // green
                        'extendedProps' => [
                            'category'     => 'Project Milestone',
                            'description'  => 'Project end'.(!empty($p->description) ? ' — '.mb_strimwidth($p->description, 0, 120, '…') : ''),
                            'project_name' => (string)$p->name,
                            'can_edit'     => false,
                        ],
                    ];
                }
            }
        }

        // --- CONTRACTOR SITE VISITS ---
        if ($categories->contains('visit')) {
            $visits = DB::table('site_visits')
                ->join('projects', 'projects.id', '=', 'site_visits.project_id')
                ->where('site_visits.contractor_id', $contractorId)
                ->when($search !== '', function ($q) use ($search) {
                    $q->where('projects.name', 'like', "%{$search}%");
                })
                ->select([
                    'site_visits.id',
                    'site_visits.project_id',
                    'site_visits.visit_date',
                    'site_visits.place',
                    'site_visits.time',
                    'site_visits.description',
                    'projects.name as project_name',
                ])
                ->get();

            foreach ($visits as $v) {
                $start = $v->visit_date . (!empty($v->time) ? ' '.$v->time : '');
                $events[] = [
                    'id'    => 'visit-'.$v->id,
                    'title' => 'Visit: '.$v->place,
                    'start' => $start,
                    'allDay'=> empty($v->time),
                    'color' => '#f59e0b', // amber
                    'extendedProps' => [
                        'category'     => 'Site Visit',
                        'description'  => (string)$v->description,
                        'project_name' => (string)$v->project_name,
                        'visit_id'     => (int)$v->id,
                        'place'        => (string)$v->place,
                        'date'         => (string)$v->visit_date,
                        'time'         => (string)$v->time,
                        'can_edit'     => true, // contractor-created
                    ],
                ];
            }
        }

        return response()->json($events);
    }

    // Create visit
    public function storeVisit(Request $request)
    {
        $contractorId = auth()->id();

        $data = $request->validate([
            'project_id'  => 'required|exists:projects,id',
            'visit_date'  => 'required|date',
            'place'       => 'required|string|max:255',
            'time'        => 'nullable|date_format:H:i',
            'description' => 'nullable|string',
        ]);

        // Ensure the project belongs to this contractor
        $owns = DB::table('projects')
            ->where('id', $data['project_id'])
            ->where('contractor_id', $contractorId)
            ->exists();

        if (!$owns) {
            abort(403, 'You do not have access to this project.');
        }

        DB::table('site_visits')->insert([
            'project_id'   => $data['project_id'],
            'contractor_id'=> $contractorId,
            'visit_date'   => $data['visit_date'],
            'place'        => $data['place'],
            'time'         => $data['time'] ?? null,
            'description'  => $data['description'] ?? null,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        return back()->with('success', 'Site visit added.');
    }

    // Update visit
    public function updateVisit(Request $request, $id)
    {
        $contractorId = auth()->id();

        $data = $request->validate([
            'project_id'  => 'required|exists:projects,id',
            'visit_date'  => 'required|date',
            'place'       => 'required|string|max:255',
            'time'        => 'nullable|date_format:H:i',
            'description' => 'nullable|string',
        ]);

        // Ensure the visit belongs to this contractor
        $visit = DB::table('site_visits')
            ->where('id', $id)
            ->where('contractor_id', $contractorId)
            ->first();

        if (!$visit) {
            abort(404);
        }

        // Ensure the new project also belongs to contractor
        $owns = DB::table('projects')
            ->where('id', $data['project_id'])
            ->where('contractor_id', $contractorId)
            ->exists();

        if (!$owns) {
            abort(403, 'You do not have access to this project.');
        }

        DB::table('site_visits')
            ->where('id', $id)
            ->update([
                'project_id'   => $data['project_id'],
                'visit_date'   => $data['visit_date'],
                'place'        => $data['place'],
                'time'         => $data['time'] ?? null,
                'description'  => $data['description'] ?? null,
                'updated_at'   => now(),
            ]);

        return back()->with('success', 'Site visit updated.');
    }

    // Delete visit
    public function destroyVisit($id)
    {
        $contractorId = auth()->id();

        DB::table('site_visits')
            ->where('id', $id)
            ->where('contractor_id', $contractorId)
            ->delete();

        return back()->with('success', 'Site visit deleted.');
    }
}
