<div class="space-y-5">
    <div>
        <label class="block text-sm font-medium text-gray-400 mb-2">Certificate Name *</label>
        <input type="text" name="name" value="{{ old('name', $certificate->name ?? '') }}" required
            class="w-full px-4 py-2.5 bg-[#1E1E1E] border border-[#2A2A2A] rounded-xl text-white focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37]/30 outline-none transition-all duration-300 text-sm" placeholder="e.g. Google Cloud Certification">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-400 mb-2">Certificate Image *</label>
        <input type="file" name="image" accept="image/*" {{ isset($certificate) ? '' : 'required' }}
            class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:bg-[#121212] file:text-gray-300 hover:file:bg-[#2A2A2A] transition-all">
        @if(isset($certificate) && $certificate->image)
        <div class="mt-3">
            <img src="{{ asset('storage/' . $certificate->image) }}" alt="{{ $certificate->name }}" class="h-32 rounded-xl object-cover">
        </div>
        @endif
    </div>
</div>
