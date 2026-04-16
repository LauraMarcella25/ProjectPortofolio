<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\ActivityPhoto;
use App\Models\Certificate;
use App\Models\Experience;
use App\Models\Message;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index()
    {
        $profile = Profile::first();
        $projects = Project::latest()->get();
        $skills = Skill::all()->groupBy('category');
        $experiences = Experience::latest()->get();
        $achievements = Achievement::latest()->get();
        $certificates = Certificate::latest()->get();
        $activityPhotos = ActivityPhoto::latest()->get();

        return view('portfolio.index', compact(
            'profile', 'projects', 'skills', 'experiences', 'achievements',
            'certificates', 'activityPhotos'
        ));
    }

    public function downloadCV()
    {
        $profile = Profile::first();

        if ($profile && $profile->cv_file && file_exists(storage_path('app/public/' . $profile->cv_file))) {
            return response()->download(storage_path('app/public/' . $profile->cv_file));
        }

        return back()->with('error', 'CV file not available.');
    }

    public function sendMessage(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:5000',
        ]);

        Message::create($validated);

        return back()->with('success', 'Message sent successfully! I will get back to you soon.');
    }
}
