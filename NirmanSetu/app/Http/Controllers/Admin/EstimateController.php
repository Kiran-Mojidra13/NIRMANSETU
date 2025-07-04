<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Estimate;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class EstimateController extends Controller
{
    public function index()
    {
        $estimates = Estimate::latest()->paginate(10);
        return view('admin.estimates.index', compact('estimates'));
    }

    public function create()
    {
        return view('admin.estimates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'pdf' => 'nullable|file|mimes:pdf',
            'project_id' => 'required|exists:projects,id',
            'client_id' => 'required|exists:users,id',
            'total_amount' => 'required|numeric',
        ]);

        $path = null;

        if ($request->hasFile('pdf')) {
            $path = $request->file('pdf')->store('estimates');
        }

        Estimate::create([
            'title' => $request->title,
            'pdf_path' => $path,
            'project_id' => $request->project_id,
            'client_id' => $request->client_id,
            'total_amount' => $request->total_amount,
            'status' => 'draft',
        ]);

        return redirect()->route('admin.estimates.index')->with('success', 'Estimate uploaded successfully!');
    }

    public function download($id)
    {
        $estimate = Estimate::findOrFail($id);

        // If PDF was uploaded, download it
        if ($estimate->pdf_path) {
            return Storage::download($estimate->pdf_path);
        }

        // Else generate PDF dynamically
        $pdf = Pdf::loadView('pdf.estimate', compact('estimate'));
        return $pdf->download('estimate_' . $estimate->id . '.pdf');
    }

    public function destroy($id)
    {
        $estimate = Estimate::findOrFail($id);

        if ($estimate->pdf_path) {
            Storage::delete($estimate->pdf_path);
        }

        $estimate->delete();

        return redirect()->route('admin.estimates.index')->with('success', 'Estimate deleted.');
    }
}
