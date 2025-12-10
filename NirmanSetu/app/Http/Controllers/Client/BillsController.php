<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class BillsController extends Controller
{
public function __construct()
{
$this->middleware('auth');
}

public function index()
{
$clientId = Auth::id(); // filter by client_id

// fetch invoices for logged-in client
$invoices = Invoice::where('client_id', $clientId)
->orderBy('due_date', 'asc')
->get();

// fetch payments related to these invoices
$payments = Payment::whereIn('invoice_id', $invoices->pluck('id'))
->orderBy('payment_date', 'desc')
->get();

// attach project name to each invoice/payment
$projects = Project::all()->keyBy('id'); // all projects keyed by id

foreach ($invoices as $invoice) {
$invoice->project_name = $projects[$invoice->project_id]->name ?? '-';
}

foreach ($payments as $payment) {
$payment->project_name = $projects[$payment->project_id]->name ?? '-';
}

return view('client.bills', compact('invoices', 'payments'));
}

// Mark a payment as paid manually
public function markAsPaid($paymentId)
{
$clientId = Auth::id();

$payment = Payment::where('id', $paymentId)
->where('payer_name', Auth::user()->name) // optional extra check
->firstOrFail();

$payment->is_paid = 1;
$payment->save();

return redirect()->back()->with('success', 'Payment marked as done.');
}
}