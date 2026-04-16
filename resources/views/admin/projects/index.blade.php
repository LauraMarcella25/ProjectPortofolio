@extends('layouts.admin', ['title' => 'Projects'])

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-gray-500 text-sm">Manage your portfolio projects</p>
    <a href="{{ route('projects.create') }}" class="px-4 py-2 bg-[#7A1C1C] hover:bg-[#D4AF37] hover:text-[#121212] text-white text-sm font-medium rounded-xl transition-all duration-300">+ Add Project</a>
</div>

<div class="bg-[#1E1E1E] border border-[#2A2A2A] rounded-2xl overflow-hidden">
    <table class="w-full">
        <thead class="bg-[#121212]/50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Title</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Tech Stack</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Created</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[#2A2A2A]">
            @forelse($projects as $project)
            <tr class="hover:bg-[#121212]/30 transition-colors duration-300">
                <td class="px-6 py-4 text-sm font-medium text-white">{{ $project->title }}</td>
                <td class="px-6 py-4 text-sm text-gray-400">{{ $project->tech_stack ?? '—' }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $project->created_at->format('M d, Y') }}</td>
                <td class="px-6 py-4 text-right">
                    <a href="{{ route('projects.edit', $project) }}" class="text-[#D4AF37] hover:text-[#E4C55A] text-sm mr-3 transition-colors duration-300">Edit</a>
                    <form action="{{ route('projects.destroy', $project) }}" method="POST" class="inline" onsubmit="return confirm('Delete this project?')">
                        @csrf @method('DELETE')
                        <button class="text-red-400 hover:text-red-300 text-sm transition-colors duration-300">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-6 py-8 text-center text-gray-600">No projects yet. Add your first project!</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $projects->links() }}</div>
@endsection
