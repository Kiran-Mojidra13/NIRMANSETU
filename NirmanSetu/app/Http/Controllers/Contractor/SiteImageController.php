<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class SiteImageController extends Controller
{
    // Show only projects for the logged-in contractor
    public function index(Request $request)
    {
        $contractorId = auth()->id();

        $query = Project::where('contractor_id', $contractorId);

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $projects = $query->get();

        return view('contractor.site-images', compact('projects'));
    }

    // Upload multiple images and save as JSON
    public function store(Request $request, $id)
    {
        $request->validate([
            'images'   => 'required',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $project = Project::where('id', $id)
            ->where('contractor_id', auth()->id())
            ->firstOrFail();

        $uploadedUrls = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $uploaded = Cloudinary::upload(
                    $image->getRealPath(),
                    ['folder' => "projects/{$project->id}"]
                )->getSecurePath();

                $uploadedUrls[] = $uploaded;
            }
        }

        // Get existing images (JSON array)
        $existing = $project->image_url ? json_decode($project->image_url, true) : [];
        $allUrls  = array_merge($existing, $uploadedUrls);

        // Save back as JSON
        $project->image_url = json_encode($allUrls);
        $project->save();

        return back()->with('success', 'Images uploaded successfully!');
    }

    // Delete single image
    public function destroy($id, Request $request)
    {
        $project = Project::where('id', $id)
            ->where('contractor_id', auth()->id())
            ->firstOrFail();

        $url = $request->image_url;

        // ✅ Extract Cloudinary public_id safely
        $parts = parse_url($url);
        if (!empty($parts['path'])) {
            $path = ltrim($parts['path'], '/');
            $pathWithoutExt = preg_replace('/\.[^.]+$/', '', $path);
            $publicId = preg_replace('/^.*upload\//', '', $pathWithoutExt);

            if ($publicId) {
                Cloudinary::destroy($publicId);
            }
        }

        // ✅ Remove from DB JSON
        $images = $project->image_url ? json_decode($project->image_url, true) : [];
        $images = array_values(array_filter($images, fn($img) => $img !== $url));

        $project->image_url = json_encode($images);
        $project->save();

        return back()->with('success', 'Image deleted successfully!');
    }
}
