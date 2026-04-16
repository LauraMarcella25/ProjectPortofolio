@extends('layouts.admin', ['title' => 'Edit Project'])

@section('content')
<form action="{{ route('projects.update', $project) }}" method="POST" enctype="multipart/form-data" class="max-w-3xl">
    @csrf @method('PUT')
    @include('admin.projects._form', ['project' => $project])
    <div class="flex gap-3 mt-6">
        <button type="submit" class="px-6 py-2.5 bg-[#7A1C1C] hover:bg-[#D4AF37] hover:text-[#121212] text-white text-sm font-medium rounded-xl transition-all duration-300">Update Project</button>
        <a href="{{ route('projects.index') }}" class="px-6 py-2.5 bg-[#1E1E1E] hover:bg-[#2A2A2A] text-gray-300 text-sm font-medium rounded-xl transition-all duration-300">Cancel</a>
    </div>
</form>
@endsection
