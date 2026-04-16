@extends('layouts.admin', ['title' => 'Edit Skill'])

@section('content')
<form action="{{ route('skills.update', $skill) }}" method="POST" class="max-w-lg">
    @csrf @method('PUT')
    @include('admin.skills._form', ['skill' => $skill])
    <div class="flex gap-3 mt-6">
        <button type="submit" class="px-6 py-2.5 bg-[#7A1C1C] hover:bg-[#D4AF37] hover:text-[#121212] text-white text-sm font-medium rounded-xl transition-all duration-300">Update Skill</button>
        <a href="{{ route('skills.index') }}" class="px-6 py-2.5 bg-[#1E1E1E] hover:bg-[#2A2A2A] text-gray-300 text-sm font-medium rounded-xl transition-all duration-300">Cancel</a>
    </div>
</form>
@endsection
