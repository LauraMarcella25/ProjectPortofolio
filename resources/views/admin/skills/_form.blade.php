<div class="space-y-5">
    <div>
        <label class="block text-sm font-medium text-gray-400 mb-2">Skill Name *</label>
        <input type="text" name="name" value="{{ old('name', $skill->name ?? '') }}" required
            class="w-full px-4 py-2.5 bg-[#1E1E1E] border border-[#2A2A2A] rounded-xl text-white focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37]/30 outline-none transition-all duration-300 text-sm" placeholder="e.g. Machine Learning">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-400 mb-2">Category *</label>
        <select name="category" required class="w-full px-4 py-2.5 bg-[#1E1E1E] border border-[#2A2A2A] rounded-xl text-white focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37]/30 outline-none transition-all duration-300 text-sm">
            <option value="AI" {{ old('category', $skill->category ?? '') === 'AI' ? 'selected' : '' }}>AI & Machine Learning</option>
            <option value="Web" {{ old('category', $skill->category ?? '') === 'Web' ? 'selected' : '' }}>Web Development</option>
            <option value="Tools" {{ old('category', $skill->category ?? '') === 'Tools' ? 'selected' : '' }}>Tools & Platforms</option>
        </select>
    </div>
</div>
