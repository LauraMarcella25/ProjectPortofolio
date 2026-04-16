@extends('layouts.admin', ['title' => 'Edit Achievement'])

@section('content')
<form action="{{ route('achievements.update', $achievement) }}" method="POST" class="max-w-lg">
    @csrf @method('PUT')
    @include('admin.achievements._form', ['achievement' => $achievement])
    <div class="flex gap-3 mt-6">
        <button type="submit" class="px-6 py-2.5 bg-[#7A1C1C] hover:bg-[#D4AF37] hover:text-[#121212] text-white text-sm font-medium rounded-xl transition-all duration-300">Update</button>
        <a href="{{ route('achievements.index') }}" class="px-6 py-2.5 bg-[#1E1E1E] hover:bg-[#2A2A2A] text-gray-300 text-sm font-medium rounded-xl transition-all duration-300">Cancel</a>
    </div>
</form>
@endsection
