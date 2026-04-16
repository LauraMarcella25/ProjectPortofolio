@extends('layouts.admin', ['title' => 'Certificates'])

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-gray-500 text-sm">Manage your certificates</p>
    <a href="{{ route('certificates.create') }}" class="px-4 py-2 bg-[#7A1C1C] hover:bg-[#D4AF37] hover:text-[#121212] text-white text-sm font-medium rounded-xl transition-all duration-300">+ Add Certificate</a>
</div>

<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($certificates as $cert)
    <div class="bg-[#1E1E1E] border border-[#2A2A2A] rounded-2xl overflow-hidden hover:border-[#D4AF37]/20 transition-all duration-300">
        <div class="h-48 overflow-hidden">
            <img src="{{ asset('storage/' . $cert->image) }}" alt="{{ $cert->name }}" class="w-full h-full object-cover">
        </div>
        <div class="p-4">
            <h3 class="text-white font-semibold text-sm mb-3">{{ $cert->name }}</h3>
            <div class="flex items-center gap-2">
                <a href="{{ route('certificates.edit', $cert) }}" class="text-[#D4AF37] hover:text-[#E4C55A] text-xs transition-colors duration-300">Edit</a>
                <form action="{{ route('certificates.destroy', $cert) }}" method="POST" class="inline" onsubmit="return confirm('Delete this certificate?')">
                    @csrf @method('DELETE')
                    <button class="text-red-400 hover:text-red-300 text-xs transition-colors duration-300">Delete</button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-12 text-gray-600">
        <p>No certificates yet. Add your first certificate!</p>
    </div>
    @endforelse
</div>
<div class="mt-4">{{ $certificates->links() }}</div>
@endsection
