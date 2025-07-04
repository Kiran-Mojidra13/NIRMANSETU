<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    // 📂 List documents — show only what user can see
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            // Admin sees all documents
            $documents = Document::latest()->paginate(10);
        } elseif ($user->role === 'engineer' || $user->role === 'contractor') {
            // Engineer/Contractor sees only docs for projects they are assigned to
            $documents = Document::whereHas('project', function ($q) use ($user) {
                $q->whereHas('tasks', function ($task) use ($user) {
                    $task->where('assigned_to', $user->id);
                });
            })->latest()->paginate(10);
        } elseif ($user->role === 'client') {
            // Client sees only own docs
            $documents = Document::where('client_id', $user->id)->latest()->paginate(10);
        } else {
            abort(403, 'Unauthorized.');
        }

        return view('admin.documents.index', compact('documents'));
    }

    // 📂 Show upload form
    public function create()
    {
        return view('admin.documents.create');
    }

    // 📂 Handle upload and save
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'file' => 'required|file|mimes:pdf,jpg,png,docx,doc,xlsx,xls',
            'type' => 'nullable|string',
            'description' => 'nullable|string',
            'client_id' => 'nullable|exists:users,id',
            'project_id' => 'nullable|exists:projects,id',
        ]);

        $path = $request->file('file')->store('documents');

        Document::create([
            'title' => $request->title,
            'file_path' => $path,
            'type' => $request->type,
            'description' => $request->description,
            'uploaded_by' => auth()->id(),
            'client_id' => auth()->user()->role === 'client'
                ? auth()->id()
                : $request->client_id,
            'project_id' => $request->project_id,
        ]);

        return redirect()->route('admin.documents.index')
            ->with('success', 'Document uploaded successfully!');
    }

    // 📂 Delete a document
    public function destroy($id)
    {
        $document = Document::findOrFail($id);
        Storage::delete($document->file_path);
        $document->delete();

        return redirect()->route('admin.documents.index')
            ->with('success', 'Document deleted.');
    }
}
