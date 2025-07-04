@extends('adminlte::page')

@section('title', 'Billing Dashboard')

@section('content_header')
    <h1>Billing Dashboard</h1>
@stop

@section('content')
    <h2>📄 Estimates</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th><th>Project</th><th>Client</th><th>Total</th><th>Status</th><th>PDF</th>
            </tr>
        </thead>
        <tbody>
        @foreach($estimates as $estimate)
            <tr>
                <td>{{ $estimate->title }}</td>
                <td>{{ $estimate->project_id }}</td>
                <td>{{ $estimate->client_id }}</td>
                <td>{{ $estimate->total_amount }}</td>
                <td>{{ $estimate->status }}</td>
                <td>
                    <a href="{{ route('admin.estimate.download', $estimate->id) }}">Download Estimate</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h2>🧾 Invoices</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th><th>Project</th><th>Client</th><th>Total</th><th>Status</th><th>Due Date</th><th>PDF</th>
            </tr>
        </thead>
        <tbody>
        @foreach($invoices as $invoice)
            <tr>
                <td>{{ $invoice->title }}</td>
                <td>{{ $invoice->project_id }}</td>
                <td>{{ $invoice->client_id }}</td>
                <td>{{ $invoice->total_amount }}</td>
                <td>{{ $invoice->status }}</td>
                <td>{{ $invoice->due_date }}</td>
                <td>
                    <a href="{{ route('admin.invoice.download', $invoice->id) }}">Download Invoice</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h2>💵 Payments</h2>
    <table class="table table-bordered">
        <thead>
            <tr><th>Project</th><th>Amount</th><th>Payer</th><th>Method</th><th>Paid On</th></tr>
        </thead>
        <tbody>
        @foreach($payments as $payment)
            <tr>
                <td>{{ $payment->project_id }}</td>
                <td>{{ $payment->amount }}</td>
                <td>{{ $payment->payer_name }}</td>
                <td>{{ $payment->method }}</td>
                <td>{{ $payment->payment_date }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop
