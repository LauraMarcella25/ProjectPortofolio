<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'problem' => 'nullable|string',
            'approach' => 'nullable|string',
            'result' => 'nullable|string',
            'tech_stack' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'demo_video' => 'nullable|file|mimes:mp4,webm,mov|max:51200',
            'github_link' => 'nullable|url|max:255',
            'demo_link' => 'nullable|url|max:255',
        ]);

        try {
            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('projects', 'public');
            }

            if ($request->hasFile('demo_video')) {
                $validated['demo_video'] = $request->file('demo_video')->store('project-videos', 'public');
            }

            Project::create($validated);

            return redirect()->route('projects.index')->with('success', 'Project created successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['image' => 'Failed to upload: ' . $e->getMessage()]);
        }
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'problem' => 'nullable|string',
            'approach' => 'nullable|string',
            'result' => 'nullable|string',
            'tech_stack' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'demo_video' => 'nullable|file|mimes:mp4,webm,mov|max:51200',
            'github_link' => 'nullable|url|max:255',
            'demo_link' => 'nullable|url|max:255',
        ]);

        try {
            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('projects', 'public');
            }

            if ($request->hasFile('demo_video')) {
                if ($project->demo_video) {
                    Storage::disk('public')->delete($project->demo_video);
                }
                $validated['demo_video'] = $request->file('demo_video')->store('project-videos', 'public');
            }

            $project->update($validated);

            return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['image' => 'Failed to upload: ' . $e->getMessage()]);
        }
    }

    public function destroy(Project $project)
    {
        if ($project->demo_video) {
            Storage::disk('public')->delete($project->demo_video);
        }
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }
}
