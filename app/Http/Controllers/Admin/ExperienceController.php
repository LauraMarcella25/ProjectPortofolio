<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExperienceController extends Controller
{
    public function index()
    {
        $experiences = Experience::latest()->paginate(10);
        return view('admin.experiences.index', compact('experiences'));
    }

    public function create()
    {
        return view('admin.experiences.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'role' => 'nullable|string|max:255',
            'year' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        try {
            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('experiences', 'public');

                if (!$validated['image']) {
                    return back()->withInput()->withErrors(['image' => 'Failed to upload image. Please try again.']);
                }
            }

            Experience::create($validated);

            return redirect()->route('experiences.index')->with('success', 'Experience added successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['image' => 'Failed to upload: ' . $e->getMessage()]);
        }
    }

    public function edit(Experience $experience)
    {
        return view('admin.experiences.edit', compact('experience'));
    }

    public function update(Request $request, Experience $experience)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'role' => 'nullable|string|max:255',
            'year' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        try {
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($experience->image) {
                    Storage::disk('public')->delete($experience->image);
                }
                $validated['image'] = $request->file('image')->store('experiences', 'public');

                if (!$validated['image']) {
                    return back()->withInput()->withErrors(['image' => 'Failed to upload image. Please try again.']);
                }
            }

            $experience->update($validated);

            return redirect()->route('experiences.index')->with('success', 'Experience updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['image' => 'Failed to upload: ' . $e->getMessage()]);
        }
    }

    public function destroy(Experience $experience)
    {
        if ($experience->image) {
            Storage::disk('public')->delete($experience->image);
        }
        $experience->delete();
        return redirect()->route('experiences.index')->with('success', 'Experience deleted successfully.');
    }
}
