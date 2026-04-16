<div class="space-y-5">
    <div>
        <label class="block text-sm font-medium text-gray-400 mb-2">Title *</label>
        <input type="text" name="title" value="{{ old('title', $experience->title ?? '') }}" required
            class="w-full px-4 py-2.5 bg-[#1E1E1E] border border-[#2A2A2A] rounded-xl text-white focus:border-cyan-500 outline-none transition-all text-sm" placeholder="e.g. President of HIMTI">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-400 mb-2">Role</label>
        <input type="text" name="role" value="{{ old('role', $experience->role ?? '') }}"
            class="w-full px-4 py-2.5 bg-[#1E1E1E] border border-[#2A2A2A] rounded-xl text-white focus:border-cyan-500 outline-none transition-all text-sm" placeholder="e.g. President">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-400 mb-2">Year</label>
        <input type="text" name="year" value="{{ old('year', $experience->year ?? '') }}"
            class="w-full px-4 py-2.5 bg-[#1E1E1E] border border-[#2A2A2A] rounded-xl text-white focus:border-cyan-500 outline-none transition-all text-sm" placeholder="e.g. 2024 - 2025">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-400 mb-2">Image</label>
        @if(isset($experience) && $experience->image)
        <div class="mb-3">
            <img src="{{ asset('storage/' . $experience->image) }}" alt="{{ $experience->title }}" class="w-40 h-28 object-cover rounded-xl border border-[#2A2A2A]">
            <p class="text-xs text-gray-500 mt-1">Current image</p>
        </div>
        @endif
        <input type="file" name="image" accept="image/jpeg,image/png,image/webp"
            class="w-full px-4 py-2.5 bg-[#1E1E1E] border border-[#2A2A2A] rounded-xl text-white focus:border-cyan-500 outline-none transition-all text-sm file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-[#7A1C1C] file:text-white hover:file:bg-[#D4AF37] hover:file:text-[#121212]">
        <p class="text-xs text-gray-600 mt-1">JPG, PNG, or WebP. Max 5MB.</p>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-400 mb-2">Description</label>
        <textarea name="description" rows="4" class="w-full px-4 py-2.5 bg-[#1E1E1E] border border-[#2A2A2A] rounded-xl text-white focus:border-cyan-500 outline-none transition-all text-sm resize-none">{{ old('description', $experience->description ?? '') }}</textarea>
    </div>
</div>
