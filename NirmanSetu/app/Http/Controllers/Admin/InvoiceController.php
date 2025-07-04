<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    /**
     * Download the invoice as a PDF — generated on the fly
     */
    public function download($id)
    {
        // Get invoice with related project & client if you have those relations
        $invoice = Invoice::with(['project', 'client'])->findOrFail($id);

        // Load PDF view and pass the data
        $pdf = Pdf::loadView('admin.invoices.pdf', compact('invoice'));

        // Dynamic file name
        $filename = 'Invoice_' . $invoice->id . '.pdf';

        // Stream download (not saved to storage!)
        return $pdf->download($filename);
    }
}
