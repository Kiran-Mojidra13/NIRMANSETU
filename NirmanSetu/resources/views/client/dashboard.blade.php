@extends('client.layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    /* Card base */
    .card.custom-card {
        border: none;
        border-radius: 0.9rem;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(16,24,40,0.06);
    }
    .card.custom-card .card-body {
        padding: 1.25rem;
    }
    .card.custom-card .card-title {
        margin: 0;
        font-weight: 600;
        color: rgba(255,255,255,0.95);
    }

    /* Gradients */
    .card-grad-blue { background: linear-gradient(135deg,#4f46e5 0%, #06b6d4 100%); color: #fff; }
    .card-grad-green { background: linear-gradient(135deg,#34d399 0%, #059669 100%); color: #fff; }
    .card-grad-pink  { background: linear-gradient(135deg,#fb7185 0%, #ec4899 100%); color: #fff; }
    .card-grad-cyan  { background: linear-gradient(135deg,#5a8d96 0%, #78c1e3 100%); color: #fff; }
    .card-grad-purple{ background: linear-gradient(135deg,#4e6bc8 0%, #7066c6 100%); color: #fff; }

    /* Chart box - UPDATED CSS */
    .chart-box {
        border-radius: 0.75rem;
        background: #ffffff;
        padding: 0.6rem;
        position: relative; /* Needed for padding trick */
        width: 100%;
        min-height: 250px; /* Fallback min-height */
    }

    /* Force a 1:1 aspect ratio container */
    .chart-container-wrapper {
        position: relative;
        padding-bottom: 100%; /* Forces height to match width */
        height: 0;
    }

    .chart-box canvas {
        position: absolute;
        top: 0;
        left: 0;
        width: 100% !important;
        height: 100% !important;
        display: block;
    }

    /* Legend dots */
    .legend-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 0.6rem;
        vertical-align: middle;
    }

    /* Site visits list items */
    .visit-item {
        background: rgba(255,255,255,0.06);
        padding: 0.65rem;
        border-radius: 0.5rem;
        margin-bottom: 0.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #fff;
    }

    .muted-white { color: rgba(255,255,255,0.85); }

    @media (max-width: 991.98px) { .ml-lg-4 { margin-left: 0 !important; } }
</style>

<div class="content">
    <div class="container-fluid">
        {{-- Top row: 3 summary cards --}}
        <div class="row">
            {{-- Total Projects --}}
            <div class="col-12 col-md-4 mb-4">
                <div class="card custom-card card-grad-blue">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="card-title"><i class="fas fa-cubes mr-2"></i> Total Projects</h5>
                                <div class="mt-3">
                                    <h2 class="mb-0">{{ count($projects ?? []) }}</h2>
                                </div>
                            </div>
                            <div class="text-right">
                                <i class="fas fa-folder-open fa-2x muted-white"></i>
                            </div>
                        </div>
                        <hr style="border-color: rgba(255,255,255,0.10); margin-top:1rem; margin-bottom:1rem;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="muted-white"><i class="fas fa-file-alt mr-1"></i> Documents</div>
                            <div class="font-weight-bold" style="color: rgba(255,255,255,0.95)">{{ count($documents ?? []) }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tasks Completed --}}
            <div class="col-12 col-md-4 mb-4">
                <div class="card custom-card card-grad-green">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="card-title"><i class="fas fa-check-circle mr-2"></i> Tasks Completed</h5>
                                <div class="mt-3">
                                    <h2 class="mb-0">{{ $completedTasks ?? 0 }} / {{ $totalTasks ?? 0 }}</h2>
                                </div>
                            </div>
                            <div class="text-right">
                                <i class="fas fa-tasks fa-2x muted-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Invoices --}}
            <div class="col-12 col-md-4 mb-4">
                <div class="card custom-card card-grad-pink">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="card-title"><i class="fas fa-file-invoice-dollar mr-2"></i> Invoices</h5>
                                <div class="mt-3">
                                    <p class="mb-0" style="color: rgba(255,255,255,0.95); font-weight:600;">
                                        {{ collect($invoices ?? [])->where('status','paid')->count() }} Paid /
                                        {{ collect($invoices ?? [])->where('status','unpaid')->count() }} Outstanding
                                    </p>
                                    <div class="h4 mt-2" style="color: #fff; font-weight:700;">007BIFF</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <i class="fas fa-dollar-sign fa-2x muted-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Lower row: chart + upcoming visits --}}
        <div class="row">
            {{-- Project Status Overview - UPDATED STRUCTURE --}}
            <div class="col-12 col-lg-7 mb-4">
                <div class="card custom-card card-grad-cyan h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><i class="fas fa-chart-pie mr-2"></i> Project Status Overview</h5>
                        <div class="d-flex flex-column flex-lg-row align-items-start mt-3">
                            {{-- Chart Container with Aspect Ratio Wrapper --}}
                            <div class="chart-box" style="flex: 1 1 50%; max-width: 50%;">
                                <div class="chart-container-wrapper">
                                    <canvas id="statusChart"></canvas>
                                </div>
                            </div>

                            {{-- Legend --}}
                            <ul class="list-unstyled ml-lg-4 mt-3 mt-lg-0 w-100" style="max-width: 220px;">
                                <li class="mb-2"><span class="legend-dot" style="background:#2563EB;"></span> In Progress</li>
                                <li class="mb-2"><span class="legend-dot" style="background:#3B82F6;"></span> Planned</li>
                                <li class="mb-2"><span class="legend-dot" style="background:#F59E0B;"></span> On Hold</li>
                                <li class="mb-2"><span class="legend-dot" style="background:#10B981;"></span> Completed</li>
                                <li class="mb-2"><span class="legend-dot" style="background:#EF4444;"></span> Delayed</li>
                            </ul>
                        </div>

                        {{-- EMBEDDED SCRIPT: MOVED HERE FOR GUARANTEED INITIALIZATION --}}
                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const statusCounts = @json($statusCounts);
                            const chartBox = document.querySelector('.chart-box');
                            const chartCanvas = document.getElementById('statusChart');

                            const totalProjects = Object.values(statusCounts).reduce((sum, count) => sum + count, 0);

                            const chartData = [
                                statusCounts.in_progress || 0,
                                statusCounts.planned || 0,
                                statusCounts.on_hold || 0,
                                statusCounts.completed || 0,
                                statusCounts.delayed || 0
                            ];

                            if (totalProjects > 0) {
                                const ctx = chartCanvas.getContext('2d');

                                new Chart(ctx, {
                                    type: 'doughnut',
                                    data: {
                                        labels: ['In Progress','Planned','On Hold','Completed','Delayed'],
                                        datasets: [{
                                            data: chartData,
                                            backgroundColor: ['#2563EB','#3B82F6','#F59E0B','#10B981','#EF4444'],
                                            borderColor: '#fff',
                                            borderWidth: 2
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        cutout: '70%',
                                        plugins: {
                                            legend: { display: false },
                                            tooltip: { padding: 10 }
                                        }
                                    }
                                });
                            } else {
                                // If no data, replace the canvas with a simple message
                                chartBox.innerHTML = `
                                    <div class="d-flex align-items-center justify-content-center" style="height:220px;">
                                        <p class="mb-0 text-muted">No project data available for chart overview.</p>
                                    </div>
                                `;
                                chartBox.style.padding = '0';
                            }
                        });
                        </script>
                        {{-- END EMBEDDED SCRIPT --}}

                    </div>
                </div>
            </div>

            {{-- Upcoming Site Visits --}}
            <div class="col-12 col-lg-5 mb-4">
                <div class="card custom-card card-grad-purple h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><i class="fas fa-calendar-alt mr-2"></i> Upcoming Site Visits</h5>
                        <div class="mt-3 flex-fill">
                            @if(empty($siteVisits) || count($siteVisits) == 0)
                                <div class="d-flex align-items-center justify-content-center" style="height:180px;">
                                    <p class="muted-white text-center mb-0"><em>No upcoming site visits</em></p>
                                </div>
                            @else
                                <div class="overflow-auto" style="max-height: 220px;">
                                    @foreach($siteVisits as $visit)
                                        <div class="visit-item">
                                            <div class="font-weight-medium">{{ $visit['project_name'] ?? 'Project XYZ' }}</div>
                                            <div class="font-weight-bold muted-white">
                                                {{ \Carbon\Carbon::parse($visit['visit_date'] ?? now())->format('d M Y') }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- REMOVED @section('scripts') BLOCK --}}
