<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ActivityPhotoController extends Controller
{
    public function index()
    {
        $photos = ActivityPhoto::latest()->paginate(12);
        return view('admin.activities.index', compact('photos'));
    }

    public function create()
    {
        return view('admin.activities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:10240',
        ]);

        try {
            $validated['image'] = $request->file('image')->store('activities', 'public');

            if (!$validated['image']) {
                return back()->withInput()->withErrors(['image' => 'Failed to upload image. Please try again.']);
            }

            ActivityPhoto::create($validated);

            return redirect()->route('activities.index')->with('success', 'Activity photo added successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['image' => 'Failed to upload image: ' . $e->getMessage()]);
        }
    }

    public function edit(ActivityPhoto $activity)
    {
        return view('admin.activities.edit', compact('activity'));
    }

    public function update(Request $request, ActivityPhoto $activity)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:10240',
        ]);

        try {
            if ($request->hasFile('image')) {
                if ($activity->image) {
                    Storage::disk('public')->delete($activity->image);
                }
                $validated['image'] = $request->file('image')->store('activities', 'public');

                if (!$validated['image']) {
                    return back()->withInput()->withErrors(['image' => 'Failed to upload image. Please try again.']);
                }
            }

            $activity->update($validated);

            return redirect()->route('activities.index')->with('success', 'Activity photo updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['image' => 'Failed to upload image: ' . $e->getMessage()]);
        }
    }

    public function destroy(ActivityPhoto $activity)
    {
        if ($activity->image) {
            Storage::disk('public')->delete($activity->image);
        }
        $activity->delete();
        return redirect()->route('activities.index')->with('success', 'Activity photo deleted successfully.');
    }
}
