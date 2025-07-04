<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $invoice->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #333; }
        .header { text-align: center; }
        .header h1 { margin: 0; }
        .info { margin: 20px 0; }
        .info p { margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .totals { text-align: right; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Nirman Setu</h1>
        <p>Let's Build Together Your Dream</p>
    </div>

    <div class="info">
        <p><strong>Invoice #:</strong> {{ $invoice->id }}</p>
        <p><strong>Date:</strong> {{ $invoice->created_at->format('d-m-Y') }}</p>
        <p><strong>Client:</strong> {{ $invoice->client->name ?? 'N/A' }}</p>
        <p><strong>Project:</strong> {{ $invoice->project->name ?? 'N/A' }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Item Description</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            {{-- If you have items, loop here --}}
            <tr>
                <td>1</td>
                <td>Service / Item Name</td>
                <td>1</td>
                <td>{{ number_format($invoice->total_amount, 2) }}</td>
                <td>{{ number_format($invoice->total_amount, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="totals">
        <p><strong>Sub Total:</strong> {{ number_format($invoice->total_amount, 2) }}</p>
        <p><strong>Tax:</strong> -- </p>
        <p><strong>Total:</strong> {{ number_format($invoice->total_amount, 2) }}</p>
    </div>

    <p style="margin-top: 50px;">Thank you for your business!</p>
</body>
</html>
