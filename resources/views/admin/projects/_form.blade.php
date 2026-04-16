<div class="space-y-5">
    <div>
        <label class="block text-sm font-medium text-gray-400 mb-2">Title *</label>
        <input type="text" name="title" value="{{ old('title', $project->title ?? '') }}" required
            class="w-full px-4 py-2.5 bg-[#1E1E1E] border border-[#2A2A2A] rounded-xl text-white focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37]/30 outline-none transition-all duration-300 text-sm">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-400 mb-2">Description</label>
        <textarea name="description" rows="3" class="w-full px-4 py-2.5 bg-[#1E1E1E] border border-[#2A2A2A] rounded-xl text-white focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37]/30 outline-none transition-all duration-300 text-sm resize-none">{{ old('description', $project->description ?? '') }}</textarea>
    </div>
    <div class="grid md:grid-cols-3 gap-5">
        <div>
            <label class="block text-sm font-medium text-gray-400 mb-2">Problem</label>
            <textarea name="problem" rows="3" class="w-full px-4 py-2.5 bg-[#1E1E1E] border border-[#2A2A2A] rounded-xl text-white focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37]/30 outline-none transition-all duration-300 text-sm resize-none">{{ old('problem', $project->problem ?? '') }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-400 mb-2">Approach</label>
            <textarea name="approach" rows="3" class="w-full px-4 py-2.5 bg-[#1E1E1E] border border-[#2A2A2A] rounded-xl text-white focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37]/30 outline-none transition-all duration-300 text-sm resize-none">{{ old('approach', $project->approach ?? '') }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-400 mb-2">Result</label>
            <textarea name="result" rows="3" class="w-full px-4 py-2.5 bg-[#1E1E1E] border border-[#2A2A2A] rounded-xl text-white focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37]/30 outline-none transition-all duration-300 text-sm resize-none">{{ old('result', $project->result ?? '') }}</textarea>
        </div>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-400 mb-2">Tech Stack (comma separated)</label>
        <input type="text" name="tech_stack" value="{{ old('tech_stack', $project->tech_stack ?? '') }}"
            class="w-full px-4 py-2.5 bg-[#1E1E1E] border border-[#2A2A2A] rounded-xl text-white focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37]/30 outline-none transition-all duration-300 text-sm" placeholder="Python, Flask, TensorFlow">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-400 mb-2">Project Image</label>
        <input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:bg-[#121212] file:text-gray-300 hover:file:bg-[#2A2A2A] transition-all">
        @if(isset($project) && $project->image)
        <p class="text-xs text-gray-500 mt-1">Current: {{ basename($project->image) }}</p>
        @endif
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-400 mb-2">Demo Video (MP4, WebM, MOV — max 100MB)</label>
        <input type="file" name="demo_video" accept="video/mp4,video/webm,video/quicktime" class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:bg-[#121212] file:text-gray-300 hover:file:bg-[#2A2A2A] transition-all">
        @if(isset($project) && $project->demo_video)
        <div class="mt-2 flex items-center gap-2">
            <span class="text-xs text-green-400">Video uploaded: {{ basename($project->demo_video) }}</span>
            <a href="{{ asset('storage/' . $project->demo_video) }}" target="_blank" class="text-xs text-[#D4AF37] hover:underline">Preview &rarr;</a>
        </div>
        @endif
    </div>
    <div class="grid md:grid-cols-2 gap-5">
        <div>
            <label class="block text-sm font-medium text-gray-400 mb-2">GitHub Link</label>
            <input type="url" name="github_link" value="{{ old('github_link', $project->github_link ?? '') }}"
                class="w-full px-4 py-2.5 bg-[#1E1E1E] border border-[#2A2A2A] rounded-xl text-white focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37]/30 outline-none transition-all duration-300 text-sm" placeholder="https://github.com/...">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-400 mb-2">Demo Link</label>
            <input type="url" name="demo_link" value="{{ old('demo_link', $project->demo_link ?? '') }}"
                class="w-full px-4 py-2.5 bg-[#1E1E1E] border border-[#2A2A2A] rounded-xl text-white focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37]/30 outline-none transition-all duration-300 text-sm" placeholder="https://demo.example.com">
        </div>
    </div>
</div>
