<!DOCTYPE html>
<html>
<head>
    <title>Estimate PDF</title>
</head>
<body>
    <h1>Estimate #{{ $estimate->id }}</h1>
    <p>Title: {{ $estimate->title }}</p>
    <p>Project ID: {{ $estimate->project_id }}</p>
    <p>Client ID: {{ $estimate->client_id }}</p>
    <p>Total Amount: ₹{{ number_format($estimate->total_amount, 2) }}</p>
    <p>Status: {{ $estimate->status }}</p>
</body>
</html>
