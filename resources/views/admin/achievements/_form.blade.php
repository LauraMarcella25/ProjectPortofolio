<div class="space-y-5">
    <div>
        <label class="block text-sm font-medium text-gray-400 mb-2">Title *</label>
        <input type="text" name="title" value="{{ old('title', $achievement->title ?? '') }}" required
            class="w-full px-4 py-2.5 bg-[#1E1E1E] border border-[#2A2A2A] rounded-xl text-white focus:border-cyan-500 outline-none transition-all text-sm">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-400 mb-2">Year</label>
        <input type="text" name="year" value="{{ old('year', $achievement->year ?? '') }}"
            class="w-full px-4 py-2.5 bg-[#1E1E1E] border border-[#2A2A2A] rounded-xl text-white focus:border-cyan-500 outline-none transition-all text-sm" placeholder="e.g. 2026">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-400 mb-2">Description</label>
        <textarea name="description" rows="3" class="w-full px-4 py-2.5 bg-[#1E1E1E] border border-[#2A2A2A] rounded-xl text-white focus:border-cyan-500 outline-none transition-all text-sm resize-none">{{ old('description', $achievement->description ?? '') }}</textarea>
    </div>
</div>
