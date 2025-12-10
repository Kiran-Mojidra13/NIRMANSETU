@extends('client.layouts.app')

@section('title', 'My Bills')

@section('content')
<div class="container mx-auto p-4">

    <h1 class="text-2xl font-bold mb-6">My Bills</h1>

    {{-- Search --}}
    <div class="flex items-center gap-2 mb-4">
        <input type="text" id="search" placeholder="Search invoices..." class="border rounded p-2 flex-1" />
        <button id="searchBtn" class="btn-gradient px-4 py-2 rounded text-white font-semibold">Search</button>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded shadow">
            <thead class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-white">
                <tr>
                    <th class="px-4 py-2">Invoice ID</th>
                    <th class="px-4 py-2">Project</th>
                    <th class="px-4 py-2">Amount</th>
                    <th class="px-4 py-2">Payment Status</th>
                    <th class="px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody id="billsTable" class="divide-y">
                @foreach($payments as $payment)
<tr>
    <td>{{ $payment->invoice_id }}</td>
    <td>{{ $payment->project_name }}</td>
    <td>₹{{ number_format($payment->amount, 2) }}</td>
    <td>
        @if($payment->is_paid)
            <span class="bg-green-200 text-green-800 px-2 py-1 rounded">Paid</span>
        @else
            <span class="bg-red-200 text-red-800 px-2 py-1 rounded">Pending</span>
        @endif
    </td>
    <td>
        @if(!$payment->is_paid)
        <form method="POST" action="{{ route('client.bills.markPaid', $payment->id) }}">
            @csrf
            <button class="btn-gradient px-4 py-2 rounded text-white">Mark as Paid</button>
        </form>
        @else
            <button disabled class="px-4 py-2 bg-gray-300 text-gray-600 rounded">Done</button>
        @endif
    </td>
</tr>
@endforeach

            </tbody>
        </table>
    </div>
</div>

{{-- Custom Gradient Button --}}
<style>
.btn-gradient {
    background: linear-gradient(90deg, #6a11cb 0%, #2575fc 100%);
    transition: transform 0.2s, box-shadow 0.2s;
}
.btn-gradient:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}
</style>

<script>
// Search functionality
document.getElementById('searchBtn').addEventListener('click', function(){
    let search = document.getElementById('search').value.toLowerCase();
    document.querySelectorAll('#billsTable tr').forEach(tr=>{
        tr.style.display = tr.innerText.toLowerCase().includes(search) ? '' : 'none';
    });
});
</script>
@endsection
