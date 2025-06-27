@extends('adminlte::page')

@section('title', 'Admin Dashboard')

@section('content_header')
    <h1>Admin Dashboard</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-3">
        <x-adminlte-small-box title="Total Users" text="{{ $totalUsers }}" icon="fas fa-users" theme="info" url="#" url-text="More info"/>
    </div>
    <div class="col-md-3">
        <x-adminlte-small-box title="Projects" text="{{ $totalProjects }}" icon="fas fa-project-diagram" theme="primary" url="#" url-text="More info"/>
    </div>
    <div class="col-md-3">
        <x-adminlte-small-box title="Tasks" text="{{ $totalTasks }}" icon="fas fa-tasks" theme="warning" url="#" url-text="More info"/>
    </div>
    <div class="col-md-3">
        <x-adminlte-small-box title="Total Payments" text="₹{{ number_format($totalPayments) }}" icon="fas fa-rupee-sign" theme="success" url="#" url-text="More info"/>
    </div>
</div>

{{-- Recent Projects & Tasks --}}
<div class="row">
    <div class="col-md-6">
        <x-adminlte-card title="Recent Projects" theme="primary" icon="fas fa-folder">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th><th>Status</th><th>Start</th><th>End</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentProjects as $project)
                    <tr>
                        <td>{{ $project->name }}</td>
                        <td>{{ $project->status }}</td>
                        <td>{{ $project->start_date }}</td>
                        <td>{{ $project->end_date }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4">No recent projects.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </x-adminlte-card>
    </div>

    <div class="col-md-6">
        <x-adminlte-card title="Recent Tasks" theme="warning" icon="fas fa-tasks">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Title</th><th>Status</th><th>Due Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentTasks as $task)
                    <tr>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->status }}</td>
                        <td>{{ $task->due_date }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3">No recent tasks.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </x-adminlte-card>
    </div>
</div>

{{-- Notifications --}}
<div class="row">
    <div class="col-md-12">
        <x-adminlte-card title="Recent Notifications" theme="info" icon="fas fa-bell">
            @if($notifications->isEmpty())
                <p>No notifications yet.</p>
            @else
                <ul class="list-group">
                    @foreach($notifications as $note)
                        <li class="list-group-item">{{ $note->message }}</li>
                    @endforeach
                </ul>
            @endif
        </x-adminlte-card>
    </div>
</div>

{{-- Chart Section --}}
<div class="row">
    <div class="col-md-12">
        <x-adminlte-card title="Overview: Project Status & Payments" theme="dark" icon="fas fa-chart-bar">
            <canvas id="paymentChart" height="100"></canvas>
        </x-adminlte-card>
    </div>
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('paymentChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($months) !!},
            datasets: [{
                label: 'Monthly Payments (₹)',
                backgroundColor: '#28a745',
                borderColor: '#1e7e34',
                borderWidth: 1,
                data: {!! json_encode($amounts) !!}
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@stop
