<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
public function index(Request $request)
{
$clientId = Auth::id(); // logged-in client ID

// Fetch projects for this client with docs
$projects = Project::where('client_name', $clientId)->get();

// Fetch documents from documents table for this client
$documents = Document::where('client_id', $clientId)->get();

// Optional: search filter
if ($request->has('search') && $request->search != '') {
$search = $request->search;

$projects = $projects->filter(function($project) use ($search) {
return str_contains(strtolower($project->name), strtolower($search)) ||
str_contains(strtolower($project->description), strtolower($search));
});

$documents = $documents->filter(function($doc) use ($search) {
return str_contains(strtolower($doc->title), strtolower($search)) ||
str_contains(strtolower($doc->description), strtolower($search));
});
}

return view('client.documents', compact('projects', 'documents'));
}
}
