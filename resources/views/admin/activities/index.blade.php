@extends('layouts.admin', ['title' => 'Activity Photos'])

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-gray-500 text-sm">Manage your activity & event photos</p>
    <a href="{{ route('activities.create') }}" class="px-4 py-2 bg-[#7A1C1C] hover:bg-[#D4AF37] hover:text-[#121212] text-white text-sm font-medium rounded-xl transition-all duration-300">+ Add Photo</a>
</div>

<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($photos as $photo)
    <div class="bg-[#1E1E1E] border border-[#2A2A2A] rounded-2xl overflow-hidden hover:border-[#D4AF37]/20 transition-all duration-300">
        <div class="h-48 overflow-hidden">
            <img src="{{ asset('storage/' . $photo->image) }}" alt="{{ $photo->title }}" class="w-full h-full object-cover">
        </div>
        <div class="p-4">
            @if($photo->title)
            <h3 class="text-white font-semibold text-sm mb-1">{{ $photo->title }}</h3>
            @endif
            @if($photo->description)
            <p class="text-gray-500 text-xs mb-3">{{ Str::limit($photo->description, 80) }}</p>
            @endif
            <div class="flex items-center gap-2">
                <a href="{{ route('activities.edit', $photo) }}" class="text-[#D4AF37] hover:text-[#E4C55A] text-xs transition-colors duration-300">Edit</a>
                <form action="{{ route('activities.destroy', $photo) }}" method="POST" class="inline" onsubmit="return confirm('Delete this photo?')">
                    @csrf @method('DELETE')
                    <button class="text-red-400 hover:text-red-300 text-xs transition-colors duration-300">Delete</button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-12 text-gray-600">
        <p>No activity photos yet. Add your first photo!</p>
    </div>
    @endforelse
</div>
<div class="mt-4">{{ $photos->links() }}</div>
@endsection
