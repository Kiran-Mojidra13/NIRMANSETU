<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    // Show all site images
    public function index()
    {
        $images = DB::table('projects')->select('id', 'name', 'image_url')->get();
        return view('Contractor.site-images', compact('images'));
    }

    // Store new image
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = $request->file('image')->store('projects', 'public');

        DB::table('projects')->insert([
            'name'  => $request->name,
            'image' => $path,
        ]);

        return redirect()->route('contractor.site_images')->with('success', 'Image uploaded successfully.');
    }

    // Delete image
    public function destroy($id)
    {
        $project = DB::table('projects')->where('id', $id)->first();

        if ($project && $project->image) {
            Storage::disk('public')->delete($project->image);
        }

        DB::table('projects')->where('id', $id)->delete();

        return redirect()->route('contractor.site_images')->with('success', 'Image deleted successfully.');
    }
}
