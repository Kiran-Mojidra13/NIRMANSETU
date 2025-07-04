@extends('adminlte::page')

@section('title', 'Inventory')

@section('content_header')
    <h1>Inventory</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.inventory.create') }}" class="btn btn-primary mb-3">+ Add Material</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Unit</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Alert Quantity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($materials as $material)
                <tr @if($material->quantity <= $material->alert_quantity) class="table-danger" @endif>
                    <td>{{ $material->name }}</td>
                    <td>{{ $material->unit }}</td>
                    <td>{{ $material->quantity }}</td>
                    <td>
                        @if($material->quantity <= $material->alert_quantity)
                            <span class="badge bg-danger">Low Stock</span>
                        @else
                            <span class="badge bg-success">Sufficient</span>
                        @endif
                    </td>
                    <td>{{ $material->alert_quantity }}</td>
                    <td>
                        <a href="{{ route('admin.inventory.edit', $material->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.inventory.delete', $material->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button onclick="return confirm('Delete?')" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop
