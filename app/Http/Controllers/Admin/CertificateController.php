<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::latest()->paginate(10);
        return view('admin.certificates.index', compact('certificates'));
    }

    public function create()
    {
        return view('admin.certificates.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        try {
            $validated['image'] = $request->file('image')->store('certificates', 'public');

            if (!$validated['image']) {
                return back()->withInput()->withErrors(['image' => 'Failed to upload image. Please try again.']);
            }

            Certificate::create($validated);

            return redirect()->route('certificates.index')->with('success', 'Certificate added successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['image' => 'Failed to upload image: ' . $e->getMessage()]);
        }
    }

    public function edit(Certificate $certificate)
    {
        return view('admin.certificates.edit', compact('certificate'));
    }

    public function update(Request $request, Certificate $certificate)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        try {
            if ($request->hasFile('image')) {
                if ($certificate->image) {
                    Storage::disk('public')->delete($certificate->image);
                }
                $validated['image'] = $request->file('image')->store('certificates', 'public');

                if (!$validated['image']) {
                    return back()->withInput()->withErrors(['image' => 'Failed to upload image. Please try again.']);
                }
            }

            $certificate->update($validated);

            return redirect()->route('certificates.index')->with('success', 'Certificate updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['image' => 'Failed to upload image: ' . $e->getMessage()]);
        }
    }

    public function destroy(Certificate $certificate)
    {
        if ($certificate->image) {
            Storage::disk('public')->delete($certificate->image);
        }
        $certificate->delete();
        return redirect()->route('certificates.index')->with('success', 'Certificate deleted successfully.');
    }
}
