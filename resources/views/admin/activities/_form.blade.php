<div class="space-y-5">
    <div>
        <label class="block text-sm font-medium text-gray-400 mb-2">Title (optional)</label>
        <input type="text" name="title" value="{{ old('title', $activity->title ?? '') }}"
            class="w-full px-4 py-2.5 bg-[#1E1E1E] border border-[#2A2A2A] rounded-xl text-white focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37]/30 outline-none transition-all duration-300 text-sm" placeholder="e.g. Hackathon 2025">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-400 mb-2">Description (optional)</label>
        <textarea name="description" rows="3" class="w-full px-4 py-2.5 bg-[#1E1E1E] border border-[#2A2A2A] rounded-xl text-white focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37]/30 outline-none transition-all duration-300 text-sm resize-none">{{ old('description', $activity->description ?? '') }}</textarea>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-400 mb-2">Photo *</label>
        <input type="file" name="image" accept="image/*" {{ isset($activity) ? '' : 'required' }}
            class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:bg-[#121212] file:text-gray-300 hover:file:bg-[#2A2A2A] transition-all">
        @if(isset($activity) && $activity->image)
        <div class="mt-3">
            <img src="{{ asset('storage/' . $activity->image) }}" alt="{{ $activity->title }}" class="h-32 rounded-xl object-cover">
        </div>
        @endif
    </div>
</div>
