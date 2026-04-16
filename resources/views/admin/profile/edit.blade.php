@extends('layouts.admin', ['title' => 'Profile & CV'])

@section('content')
<form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="max-w-2xl">
    @csrf @method('PUT')

    {{-- Validation Errors --}}
    @if($errors->any())
    <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-xl">
        <ul class="text-sm text-red-400 space-y-1">
            @foreach($errors->all() as $error)
            <li>• {{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="space-y-6">

        {{-- Profile Photo Section --}}
        <div class="bg-[#1E1E1E] border border-[#2A2A2A] rounded-2xl p-6">
            <h3 class="font-semibold text-white mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Profile Photo (Hero Section)
            </h3>
            <p class="text-xs text-gray-500 mb-4">This photo will be displayed on the hero section of your portfolio homepage.</p>

            <div class="flex items-start gap-6">
                {{-- Current Photo Preview --}}
                <div class="flex-shrink-0">
                    <div id="photo-preview-container" style="width: 112px; height: 112px; border-radius: 9999px; overflow: hidden; border: 2px solid rgba(212,175,55,0.3); background: #121212; flex-shrink: 0;">
                        @if($profile->photo)
                            <img id="photo-preview" src="{{ asset('storage/' . $profile->photo) }}" alt="Current profile photo" style="width: 112px; height: 112px; object-fit: cover; display: block;">
                        @else
                            <div id="photo-placeholder" style="width: 112px; height: 112px; display: flex; align-items: center; justify-content: center;">
                                <svg style="width: 40px; height: 40px; color: #4B5563;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <img id="photo-preview" src="" alt="" style="width: 112px; height: 112px; object-fit: cover; display: none;">
                        @endif
                    </div>
                </div>

                {{-- Upload Controls --}}
                <div class="flex-1">
                    <label class="block cursor-pointer">
                        <div class="flex items-center gap-3 px-4 py-3 bg-[#121212] border border-dashed border-[#2A2A2A] rounded-xl hover:border-[#D4AF37]/40 transition-all duration-300">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <div>
                                <span class="text-sm text-gray-300" id="photo-filename">Choose a new photo...</span>
                                <p class="text-xs text-gray-600 mt-0.5">JPG, PNG, WebP — Max 2MB</p>
                            </div>
                        </div>
                        <input type="file" name="photo" accept="image/*" class="hidden" id="photo-input" onchange="previewPhoto(this)">
                    </label>
                    @if($profile->photo)
                    <p class="text-xs text-green-400/70 mt-2 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        Current photo: {{ basename($profile->photo) }}
                    </p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Name --}}
        <div>
            <label class="block text-sm font-medium text-gray-400 mb-2">Name</label>
            <input type="text" name="name" value="{{ old('name', $profile->name) }}" required
                class="w-full px-4 py-2.5 bg-[#1E1E1E] border border-[#2A2A2A] rounded-xl text-white focus:border-[#D4AF37] outline-none transition-all duration-300 text-sm">
        </div>

        {{-- Bio --}}
        <div>
            <label class="block text-sm font-medium text-gray-400 mb-2">Bio</label>
            <textarea name="bio" rows="4" class="w-full px-4 py-2.5 bg-[#1E1E1E] border border-[#2A2A2A] rounded-xl text-white focus:border-[#D4AF37] outline-none transition-all duration-300 text-sm resize-none">{{ old('bio', $profile->bio) }}</textarea>
        </div>

        {{-- CV Management --}}
        <div class="bg-[#1E1E1E] border border-[#2A2A2A] rounded-2xl p-6">
            <h3 class="font-semibold text-white mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                CV Management
            </h3>
            <input type="file" name="cv_file" accept=".pdf" class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:bg-[#121212] file:text-gray-300 hover:file:bg-[#2A2A2A] transition-all">
            @if($profile->cv_file)
            <div class="mt-3 flex items-center gap-3">
                <span class="text-xs text-green-400">CV uploaded: {{ basename($profile->cv_file) }}</span>
                <a href="{{ asset('storage/' . $profile->cv_file) }}" target="_blank" class="text-xs text-[#D4AF37] hover:underline">Preview &rarr;</a>
            </div>
            @else
            <p class="text-xs text-gray-600 mt-2">No CV uploaded yet. Upload a PDF to enable the "Download CV" button on your portfolio.</p>
            @endif
        </div>

        {{-- Social Links --}}
        <div class="grid md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">LinkedIn URL</label>
                <input type="url" name="linkedin" value="{{ old('linkedin', $profile->linkedin) }}"
                    class="w-full px-4 py-2.5 bg-[#1E1E1E] border border-[#2A2A2A] rounded-xl text-white focus:border-[#D4AF37] outline-none transition-all duration-300 text-sm" placeholder="https://linkedin.com/in/...">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">GitHub URL</label>
                <input type="url" name="github" value="{{ old('github', $profile->github) }}"
                    class="w-full px-4 py-2.5 bg-[#1E1E1E] border border-[#2A2A2A] rounded-xl text-white focus:border-[#D4AF37] outline-none transition-all duration-300 text-sm" placeholder="https://github.com/...">
            </div>
        </div>
    </div>

    <div class="flex gap-3 mt-6">
        <button type="submit" class="px-6 py-2.5 bg-[#7A1C1C] hover:bg-[#D4AF37] hover:text-[#121212] text-white text-sm font-medium rounded-xl transition-all duration-300">Save Changes</button>
    </div>
</form>

<script>
function previewPhoto(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const reader = new FileReader();

        // Update filename display
        document.getElementById('photo-filename').textContent = file.name;

        reader.onload = function(e) {
            const preview = document.getElementById('photo-preview');
            const placeholder = document.getElementById('photo-placeholder');

            preview.src = e.target.result;
            preview.style.display = 'block';

            if (placeholder) {
                placeholder.style.display = 'none';
            }
        };

        reader.readAsDataURL(file);
    }
}
</script>
@endsection
