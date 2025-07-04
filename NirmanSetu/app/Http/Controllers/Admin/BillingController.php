<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Estimate;
use App\Models\Invoice;
use App\Models\Payment;

class BillingController extends Controller
{
    public function index()
    {
        $estimates = Estimate::latest()->get();
        $invoices = Invoice::latest()->get();
        $payments = Payment::latest()->get();

        return view('admin.billing.index', compact('estimates', 'invoices', 'payments'));
    }
}