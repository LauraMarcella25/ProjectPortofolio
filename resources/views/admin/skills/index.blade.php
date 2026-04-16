@extends('layouts.admin', ['title' => 'Skills'])

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-gray-500 text-sm">Manage your skills by category</p>
    <a href="{{ route('skills.create') }}" class="px-4 py-2 bg-[#7A1C1C] hover:bg-[#D4AF37] hover:text-[#121212] text-white text-sm font-medium rounded-xl transition-all duration-300">+ Add Skill</a>
</div>

<div class="bg-[#1E1E1E] border border-[#2A2A2A] rounded-xl overflow-hidden">
    <table class="w-full">
        <thead class="bg-[#121212]/50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Category</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[#2A2A2A]">
            @forelse($skills as $skill)
            <tr class="hover:bg-[#121212]/30 transition-colors">
                <td class="px-6 py-4 text-sm font-medium text-white">{{ $skill->name }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs rounded-md {{ $skill->category === 'AI' ? 'bg-cyan-500/10 text-cyan-400' : ($skill->category === 'Web' ? 'bg-purple-500/10 text-purple-400' : 'bg-pink-500/10 text-pink-400') }}">{{ $skill->category }}</span>
                </td>
                <td class="px-6 py-4 text-right">
                    <a href="{{ route('skills.edit', $skill) }}" class="text-[#D4AF37] hover:text-[#E4C55A] text-sm mr-3">Edit</a>
                    <form action="{{ route('skills.destroy', $skill) }}" method="POST" class="inline" onsubmit="return confirm('Delete this skill?')">
                        @csrf @method('DELETE')
                        <button class="text-red-400 hover:text-red-300 text-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="3" class="px-6 py-8 text-center text-gray-600">No skills yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $skills->links() }}</div>
@endsection
