@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
<div class="row">
    <x-adminlte-info-box title="Total Users" text="{{ $totalUsers }}" icon="fas fa-users" theme="info" />
    <x-adminlte-info-box title="Total Projects" text="{{ $totalProjects }}" icon="fas fa-folder" theme="success" />
    <x-adminlte-info-box title="Total Tasks" text="{{ $totalTasks }}" icon="fas fa-tasks" theme="warning" />
    <x-adminlte-info-box title="Total Payments" text="₹{{ number_format($totalPayments) }}" icon="fas fa-money-bill-wave" theme="primary" />
</div>

{{-- Chart Section --}}
<x-adminlte-card title="Monthly Payment Chart" theme="light" icon="fas fa-chart-bar" collapsible>
    <canvas id="paymentChart" height="100"></canvas>
</x-adminlte-card>

{{-- Recent Projects --}}
<x-adminlte-card title="Recent Projects" theme="light" icon="fas fa-project-diagram" collapsible>
    <ul class="list-group list-group-flush">
        @forelse($recentProjects as $project)
            <li class="list-group-item">{{ $project->name }} – {{ $project->created_at->format('d M Y') }}</li>
        @empty
            <li class="list-group-item">No recent projects found.</li>
        @endforelse
    </ul>
</x-adminlte-card>

{{-- Notifications --}}
{{-- Notifications --}}
<x-adminlte-card title="Notifications" theme="light" icon="fas fa-bell" collapsible>
    <ul class="list-group list-group-flush">
        @forelse($notifications as $note)
            <li class="list-group-item">{{ $note->message }}</li>
        @empty
            <li class="list-group-item">No notifications found.</li>
        @endforelse
    </ul>
</x-adminlte-card>


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
                backgroundColor: '#4CAF50',
                borderColor: '#388E3C',
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
