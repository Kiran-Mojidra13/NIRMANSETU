@extends('adminlte::page')

@section('title', 'Reports')

@section('content_header')
    <h1 class="m-0 text-dark">📊 Overall Reports & Analytics</h1>
@stop

@section('content')
<div class="row">

    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">1️⃣ Project Summary</div>
            <div class="card-body">
                <p>Total Projects: <span class="badge bg-info">{{ $totalProjects }}</span></p>
                <p>Active Projects: <span class="badge bg-success">{{ $activeProjects }}</span></p>
                <p>Completed Projects: <span class="badge bg-success">{{ $completedProjects }}</span></p>
                <p>Delayed Projects: <span class="badge bg-danger">{{ $delayedProjects }}</span></p>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-secondary text-white">2️⃣ Task & Work Progress</div>
            <div class="card-body">
                <p>Total Tasks: <span class="badge bg-info">{{ $totalTasks }}</span></p>
                <p>Completed Tasks: <span class="badge bg-success">{{ $completedTasks }}</span></p>
                <p>Pending Tasks: <span class="badge bg-warning">{{ $pendingTasks }}</span></p>
            </div>
        </div>
    </div>

    <div class="col-md-6 mt-3">
        <div class="card shadow">
            <div class="card-header bg-success text-white">3️⃣ Financials</div>
            <div class="card-body">
                <p>Total Estimated Cost: <strong>₹{{ number_format($totalEstimates, 2) }}</strong></p>
                <p>Total Invoices Billed: <strong>₹{{ number_format($totalInvoices, 2) }}</strong></p>
                <p>Total Payments Received: <strong>₹{{ number_format($totalPaid, 2) }}</strong></p>
            </div>
        </div>
    </div>

    <div class="col-md-6 mt-3">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark">4️⃣ Materials Low Stock</div>
            <div class="card-body">
                @if($lowStockMaterials->count())
                    <ul class="list-group">
                        @foreach($lowStockMaterials as $material)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $material->name }}
                                <span class="badge bg-danger">{{ $material->quantity }} units left</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-success">All materials sufficiently stocked! ✅</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-12 mt-3">
        <div class="card shadow">
            <div class="card-header bg-info text-white">5️⃣ Clients & Projects</div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach($clients as $client)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $client->name }}
                            <span class="badge bg-primary">{{ $client->projects_count }} projects</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

</div>

<div class="mt-4">
    <a href="{{ route('admin.reports.exportExcel') }}" class="btn btn-success">
        📊 Download Excel
    </a>
</div>
@stop
